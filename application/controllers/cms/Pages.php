<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    public $bucketname;
    public $directoryuser;
    public $check_data;    
    public $date; 
    public $AWS;    
    public $current_lang;
    public $sessionID;  

    public function __construct() {
        parent::__construct();        
        $this->load->model("Post_model");
        $this->load->model("Globals_model");
        $this->load->model("Assets_model");
        $this->sessionID = $this->mytemplate->mySessionID();          
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");                    
        $this->AWS  = new AmazonS3();   
        $this->date = new DateTime();                 
        $this->current_lang = $this->mytemplate->currentLang();      
    }

    public function section($moduleName)
    {                      
         $module_ = $this->uri->segment(4,'about');    
         $data['module'] = $module_;  
                          
         $check_data = $this->Post_model->get_pages_by_module(filter_string($module_));                  
         if (isset($check_data)){
            $data['postTitle']   = show_data_serialize($check_data->postTitle,$this->mytemplate->currentLang());
            $data['postDescription'] = show_data_serialize($check_data->postDescription,$this->mytemplate->currentLang()); 
         }else{
            $data['postTitle']  = '';
            $data['postDescription']  = '';
         }               
         $this->mytemplate->loadTemplate(2,'entries/form_pages',$data);      
    }
    
    public function services(){
        $module_ = "Services";
        $data['module'] = $module_;  
        $this->mytemplate->loadTemplate(2,'entries/form_services',$data);  
    }
    
    public function update(){           
        $this->form_validation->set_rules('postTitle', 'Post Title', 'required');
        $this->form_validation->set_rules('postDescription', 'Post Description', 'required');        
         if ($this->form_validation->run() == FALSE){   
             $str = validation_errors();
             $res = loadMessage(2,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{          
              $module_ = $this->input->post("module",true);                  
              $check_data = $this->Post_model->get_pages_by_module(filter_string($module_));   
              if (!isset($check_data)){
                 $return = $this->Post_model->insert_page(filter_string($module_));
              }else{                 
                 $old = array('postID'=> $check_data->postID, 
                              'postTitle' => $check_data->postTitle,
                              'postDescription' => $check_data->postDescription);  
                 $return = $this->Post_model->update_page(filter_string($module_),$old);
              }  
                         
              if ($return){
                   $id = 1;
                   $str = "Save data succesfully";
              }else{
                   $id = 2;
                   $str = "Save data failed";
              }             
              $res = loadMessage($id,$str);  
              header('Content-Type: application/json');
              echo json_encode($res);
         }
    }
    
    public function update_pic($module_){
        $check_data = $this->Post_model->get_pages_by_module(filter_string($module_));  
        if (isset($check_data)){
                if(!empty($_FILES['myfile']['name'])){                
                    if (filter_images($_FILES['myfile'])) {                                                                
                            $postDate    = $this->date->format('U = Y-m-d H:i:s');
                            $_data  = $this->mytemplate->upload_file('./uploads/','myfile');
                            
                            $bigimg = array("name"=> $_data['file_name'],
                                            "tmp_name" => $_data['full_path'] );
                            $thumbimg = array("name"=> $_data['raw_name'].'_thumb'.$_data['file_ext'],
                                              "tmp_name" => $_data['thumb'] );
                            // save on aws                                                                                           
                            $this->AWS->sendFile($this->bucketname,$bigimg, $module_,'public-read');                                  
                            $this->AWS->sendFile($this->bucketname,$thumbimg, $module_,'public-read');                     
                                                
                            $filename    = serialize($_data);
                            $array_data  = array(
                                    'typeassets' => $module_,
                                    'imagesCaption' => '',
                                    'imagesFile' => $filename,
                                    'postDate' => $postDate,
                                    'imagesDescription' => '',
                                    'userID' => $this->sessionID
                            );                        
                        // save on table
                        $this->Assets_model->insert($array_data);                                      
                        unlink($_data['full_path']);
                        unlink($_data['thumb']);
                      
                        
                     }else{
                         $res = loadMessage(2,"Uploaded failed...");  
                         header('Content-Type: application/json');
                         echo json_encode($res);    
                     }   
               } 
        }else{
            $res = loadMessage(2,"Content ".$module_." must fill before uploading images");  
            header('Content-Type: application/json');
            echo json_encode($res); 
        }               
    }
    
     public function filldata($type='filldata'){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'i.imagesFile'
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
                $imgID = encode_url($row["imagesID"]);
                $nestedData[] = '<img src="https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumb.'" style="max-width:100px;">'               
                                .'&nbsp;&nbsp;<a title="Delete" href="#" onclick="delete_assets('."'".$imgID."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
     
    
    public function language(){
        $var_lang = $this->input->post('lang',true);
        $this->session->set_userdata("lang",$var_lang);        
    }
    
   
    
  
    
    
    
        
   
                 
}
