<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {
        
    public $sessionID;   
    public $AWS;
    public $date; 
    public $lang;
    public $current_lang;
    public $bucketname;
    public $directoryuser;
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Assets_model");
        $this->sessionID = $this->mytemplate->mySessionID();                 
        $this->AWS = new AmazonS3();   
        $this->date = new DateTime();         
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");
    }

    public function index()
    {                  
         $data['title'] = "Assets";            
         $this->mytemplate->loadTemplate(2,'assets/index',$data);      
    }
    
    public function upload($type='siteassets'){  
       if(!empty($_FILES['myfile']['name'])){                
            if (filter_images($_FILES['myfile'])) {                      
                    $caption_img = filter_string($this->input->post('caption',true));                
                    $description  = filter_string($this->input->post('desc_image',true));                
                    $postDate    = $this->date->format('U = Y-m-d H:i:s');
                    $_data  = $this->mytemplate->upload_file('./uploads/','myfile');
                    
                    $bigimg = array("name"=> $_data['file_name'],
                                    "tmp_name" => $_data['full_path'] );
                    $thumbimg = array("name"=> $_data['raw_name'].'_thumb'.$_data['file_ext'],
                                      "tmp_name" => $_data['thumb'] );
                    // save on aws                                      
                    $this->AWS->sendFile($this->bucketname,$bigimg, $caption_img,'public-read');                                  
                    $this->AWS->sendFile($this->bucketname,$thumbimg, $caption_img,'public-read');                     
                                        
                    $filename    = serialize($_data);
                    $array_data  = array(
                            'typeassets' => $type,
                            'imagesCaption' => create_serialize_data($caption_img,$this->lang),
                            'imagesFile' => $filename,
                            'postDate' => $postDate,
                            'imagesDescription' => create_serialize_data($description,$this->lang),
                            'userID' => $this->sessionID
                    );                                       
                // save on table
                $this->Assets_model->insert($array_data);                                      
                unlink($_data['full_path']);
                unlink($_data['thumb']);
                $foldersettings = $this->session->userdata('userName').$this->date->format('U = Ymd');
                
             }else{
                 $res = loadMessage(2,"Uploaded failed...");  
                 header('Content-Type: application/json');
                 echo json_encode($res);    
             }   
       } 
    }
    
    
    public function filldata($type='filldata'){  
        $requestData= $_REQUEST;        
        $columns = array(             
                    0 => 'i.imagesFile', 
                    1 => 'i.imagesDescription',
                    2=> 'i.postDate'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length'],
                       'type' => $type
                      );
                              
        $result = $this->Assets_model->get_data($params);  
        $totalData = $this->Assets_model->get_count($type);          
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){    
                $val_date = convert_date($row["postDate"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $s3_img = unserialize($row["imagesFile"]);
                $thumb = $s3_img['raw_name'].'_thumb'.$s3_img['file_ext'];
                $nestedData[] = '<img src="https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumb.'" style="max-width:100px;">';
                $nestedData[] = show_data_serialize($row["imagesCaption"],$this->mytemplate->currentLang());
                $nestedData[] = $row['userName'].', '. $val_date['date'].' '.$val_date['time'];
                //add html for action
                $imgID = encode_url($row["imagesID"]);
                $nestedData[] = '<a title="Update" href="#" onclick="update_asset('."'".$imgID."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_assets('."'".$imgID."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
                $data[] = $nestedData;
        }
        
         $json_data = array(
                    "draw"         => intval( $requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                    "recordsTotal"   => intval( $totalData ),  // total number of records
                    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                    "data"          => $data   // total data array
                    );
        echo json_encode($json_data);  
    }
    
    
    public function update_assets($id){        
        $row = $this->Assets_model->get_data_byId(decode_url($id));         
        $data['id'] = encode_url($row->imagesID);          
        $data['imagesCaption'] = show_data_serialize($row->imagesCaption,$this->mytemplate->currentLang());
        $data['imagesDescription'] = show_data_serialize($row->imagesDescription,$this->mytemplate->currentLang());        
        echo json_encode($data);
    }
    
    public function delete_assets($id)
    {   
        $getdata = $this->Assets_model->get_data_byId(decode_url($id));
        $s3_img = unserialize($getdata->imagesFile);
        $thumb = $s3_img['raw_name'].'_thumb'.$s3_img['file_ext'];
        
        $this->Assets_model->delete_byId(decode_url($id));
        if(!empty($getdata->imagesFile)){     
             if ($this->AWS->checkFiles($this->bucketname,$s3_img['file_name']))
                $this->AWS->removeFile($this->bucketname,$s3_img['file_name']);
             if ($this->AWS->checkFiles($this->bucketname,$thumb))     
                $response =  $this->AWS->removeFile($this->bucketname,$getdata->imagesFile);  
             $id = ($response)? 1 : 2;
             $str = ($response)? 'Delete '.$s3_img['file_name'].' successfully' : 'Can not delete '.$s3_img['file_name'];              
             $res = loadMessage($id,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
        }        
     }
     
     public function push_update(){
         $result = $this->Assets_model->update_desc(); 
         $id = ($result)? 1 : 2;
         $str = ($result)? "Update data successfully" : "Update data failed"; 
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);               
     }
     
     
     
     
     
     
    
   
    
    
    
        
   
                 
}
