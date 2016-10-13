<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends CI_Controller {
    
    private $AWS;    
    public $bucketname; 
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Post_model','PM');                        
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");  
    }
    
    public function index()
    {                     
        $data['module'] = "Entries";
        $this->mytemplate->loadTemplate(2,'entries/index',$data);
    }
    
    
     public function filldata($type='filldata'){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'postTitle', 
                    1 => 'dateEntry',
                    2 => 'userID'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length'],
                       'type' => $type
                      );
        
        $result = $this->PM->get_data($params);  
        $totalData = $this->PM->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){      
                $code = encode_url($row["postID"]);
                $val_date = convert_date($row["dateEntry"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $nestedData[] = show_data_serialize($row["postTitle"],$this->mytemplate->currentLang());              
                $nestedData[] = $val_date['date'].' '.$val_date['time'];
                $nestedData[] = $row["userName"];
                //add html for action
                $nestedData[] = '<a title="Update" href="'.site_url("cms/entries/post/update")."/".$code.'")"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_entries('."'".$code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
    
    
    public function post($mode,$id=''){       
        $data['title'] = ($mode=="add") ? "ADD ENTRIES" : "UPDATE ENTRIES";            
        $codeID = decode_url($id);
        $check = $this->PM->get_data_byId($codeID);               
        $data['postTitle'] = (empty($check)) ? '' :  show_data_serialize($check->postTitle,$this->mytemplate->currentLang());
        $data['shortdesc'] = (empty($check)) ? '' :  show_data_serialize($check->postDescription,$this->mytemplate->currentLang());
        $data['mainheading'] = (empty($check)) ? '' :  show_data_serialize($check->postHeading,$this->mytemplate->currentLang());
        $data['subheading'] = (empty($check)) ? '' :  show_data_serialize($check->postSubheading,$this->mytemplate->currentLang());
        $data['subheading'] = (empty($check)) ? '' :  show_data_serialize($check->postSubheading,$this->mytemplate->currentLang());
        $data['postSlug'] = (empty($check)) ? '' :  show_data_serialize($check->postSlug,$this->mytemplate->currentLang());
        $data['publish'] = (empty($check)) ? '' : $check->publish;
        $dateEntry = (empty($check)) ? '' :  convert_date($check->dateEntry);
        $data['postDate'] =  (empty($dateEntri)) ? '' : $dateEntry["date"];         
        $data['postTime'] =  (empty($dateEntri)) ? '' : $dateEntry["time"];
        $Expiration = (empty($check)) ? '' :  convert_date($check->dateExpiration);        
        $data['ExDate'] =  (empty($Expiration)) ? '' : $Expiration["date"];         
        $data['ExTime'] =  (empty($Expiration)) ? '' :$Expiration["time"];
        $data['postModule'] = (empty($check))? '' : $check->postModule;        
        // Display postbody 
        $postbody = $this->PM->get_postbody($codeID);
        
         if((!empty($postbody)) && ($mode=="update")){
            $tmp =''; 
            foreach($postbody as $row=>$key):
                if ($key['bodyType']=="heading"){               
                    $tmp.= view_heading(false,show_data_serialize($key["content"],$this->mytemplate->currentLang()));
                }
                if ($key['bodyType']=="text"){
                    $value['content']  = show_data_serialize($key["content"],$this->mytemplate->currentLang());
                    $value['position']  = $key['position'];
                    $tmp.= view_text(false,$value);
                }
                if ($key['bodyType']=="pullquote"){
                    $value['content']  = show_data_serialize($key["content"],$this->mytemplate->currentLang());
                    $value['position']  = $key['position'];
                    $tmp.= view_pullquote(false,$value);
                }

                if ($key['bodyType']=="images"){
                    $value['content']  = $key["content"];
                    $value['caption']  = show_data_serialize($key["caption"],$this->mytemplate->currentLang());
                    $value['position']  = $key['position'];
                    $tmp.= view_images(false,$value);
                }

                if ($key['bodyType']=="quote"){
                    $value['content']  = show_data_serialize($key["content"],$this->mytemplate->currentLang());              
                    $value['position']  = $key['position'];
                    $tmp.= view_quote(false,$value);
                }
            endforeach;
            $data['content_postbody']= $tmp;
        }else{
            $data['content_postbody']='';
        }
        $this->mytemplate->loadTemplate(2,'entries/form_article',$data);
    }
    
    
    public function pushdata($action='add'){         
        $title        = filter_string($this->input->post("title_name",true));         
        if (empty($title)){             
             exit;
         }else{         
              $id = $this->input->post('postID');
              $return =($action=='add')? $this->PM->insert() : $this->PM->update(decode_url($id)); 
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
    
    public function delete($id){         
         $return = $this->PM->delete_data(decode_url($id));
         $id = ($return)? 1 : 2;
         $str = ($return)? 'Delete data successfully' : 'Can not delete this data'; 
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);       
    }
    
    public function op_article_submit(){    
        $title = filter_string($this->input->post("title_name",true));              
        if (empty($title)){             
             exit;
         }else{                 
              if(!empty($_FILES['picture']['name'])){                 
                 $_data  = $this->mytemplate->upload_file('./uploads/','picture');                 
                 $bigimg = array("private"=>"ACL_PUBLIC_READ",                                      
                                 "local_filepath"=>$_data['full_path'],
                                 "bucket"=>$this->bucketname,
                                 "replace"=>"",// check old files 
                                 "folder_path"=>$this->directoryuser,
                                 "file_name"=>$_data['file_name']);
                 $this->myfly->s3_upload($bigimg);   
                 $thumbimg = array("private"=>"ACL_PUBLIC_READ",                                      
                                   "local_filepath"=>$_data['thumb'],
                                   "bucket"=>$this->bucketname,
                                   "replace"=>"",// check old files 
                                   "folder_path"=>$this->directoryuser,
                                   "file_name"=>$_data['raw_name'].'_thumb'.$_data['file_ext']);
                 $awsFile = $this->myfly->s3_upload($thumbimg);                                                     
                 $res["urlimg"] =  $awsFile['s3_url'];
                 $imgfile = serialize($_data);               
                 unlink($_data['full_path']);
                 unlink($_data['thumb']);
              }else{
                 $res["urlimg"] = '';
                 $imgfile = '';
              }    
              
              $return = $this->PM->insert_onepages($imgfile); 
              
              if ($return){
                   $id = 1;
                   $str = "Save data succesfully";                  
              }else{
                   $id = 2;
                   $str = "Save data failed";                   
              }             
              $res["message"] = loadMessage($id,$str);  
              header('Content-Type: application/json');              
              echo json_encode($res);
         }
    }
    
            
}

