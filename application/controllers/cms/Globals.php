<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Globals extends CI_Controller {
    
    var $sessionID;
    var $check;    
    public $AWS;
    public $bucketname;
    public $directoryuser;
    
    public function __construct() {
        parent::__construct();
        $this->load->library("myfly");
        $this->AWS = new Myfly(); 
        $this->load->model("Globals_model","GM");        
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->directoryuser = $this->session->userdata("userName"); 
        $this->check = $this->GM->get_data_byId($this->sessionID);        
        $this->lang->load('myform', $this->mytemplate->currentLang());   
        $this->bucketname = 'roomsranger';
    }

    public function index()
    {       
         $data['module'] = "Globals";           
         $data['email'] = (empty($this->check)) ? '' :  $this->check->email;  
         $data['contactUs'] = (empty($this->check)) ? '' :  show_data_serialize($this->check->contactUs,$this->mytemplate->currentLang());
         $data['metadata'] = (empty($this->check)) ? '' :  show_data_serialize($this->check->metadata,$this->mytemplate->currentLang());
         $data['copyright'] = (empty($this->check)) ? '' :  $this->check->copyright;
         $data['themes'] = (empty($this->check)) ? '' :  $this->check->themes_color;
         $this->mytemplate->loadTemplate(2,'globals/index',$data);      
    }
    
    public function footercontent(){              
         $this->form_validation->set_rules('titlesite', 'Website Title', 'required');
         $this->form_validation->set_rules('metadata', 'Metadata', 'required');
         $this->form_validation->set_rules('copyright', 'Copyright', 'required');
         $this->form_validation->set_rules('contactUs', 'Contact Us Label', 'required');
         $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
         if ($this->form_validation->run() == FALSE){        
              $res = loadMessage(2,  validation_errors());  
              header('Content-Type: application/json');
              echo json_encode($res);
             exit;
         }else{                                               
              if (!empty($_FILES['logoimg']['name'])){
                  $oldimg = $this->check->logo;
                  $AWSpic= unserialize($oldimg);     
                  $oldthumb = $AWSpic['raw_name'].'_thumb'.$AWSpic['file_ext'];         
                  $oriImg    = $AWSpic['file_name'];                 
                  $_data  = $this->mytemplate->upload_file('./uploads/','logoimg');  
                  $bigimg = array("private"=>"ACL_PUBLIC_READ",                                      
                                 "local_filepath"=>$_data['full_path'],
                                 "bucket"=>$this->bucketname,
                                 "replace"=> $this->directoryuser."/".$oriImg,// check old files 
                                 "folder_path"=>$this->directoryuser,
                                 "file_name"=>$_data['file_name']);
                  $this->myfly->s3_upload($bigimg);               
                  $thumbimg = array("private"=>"ACL_PUBLIC_READ",                                      
                                   "local_filepath"=>$_data['thumb'],
                                   "bucket"=>$this->bucketname,
                                   "replace"=> $this->directoryuser."/".$oldthumb,// check old files 
                                   "folder_path"=>$this->directoryuser,
                                   "file_name"=>$_data['raw_name'].'_thumb'.$_data['file_ext']);
                  $awsFile = $this->myfly->s3_upload($thumbimg);                                                    
                  // save on aws                                                                                                                          
                  $res["urlimg"] = $awsFile["s3_url"];                                                           
                  $filename    = serialize($_data);                                                   
                  $tmp_file = $filename;                  
                  unlink($_data['full_path']);
                  unlink($_data['thumb']);
              }else {
                  $res["urlimg"] = '';  
                  $tmp_file = $this->check->logo;
              }
                          
              if (empty($this->check)) { 
                  $return = $this->GM->insert($tmp_file); 
              }else{ 
                  $return = $this->GM->update($this->check,$tmp_file);
              }
              
              if ($return){
                   $id = 1;
                   $str = $this->lang->line('save_success');
              }else{
                   $id = 2;
                   $str = $this->lang->line('save_failed');
              }             
              $res["message"] = loadMessage($id,$str);  
              header('Content-Type: application/json');
              echo json_encode($res);
         }
    }
    
    public function map(){
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
         if ($this->form_validation->run() == FALSE){        
             $str = validation_errors();
             $id  = 2;               
         }else{ 
            $return = $this->GM->update_map();
            if ($return){
                $id = 1;
                $str = $this->lang->line('save_success');
            }else{
                $id = 2;
                $str = $this->lang->line('save_failed');
            }                           
         }
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);
                
    }
    
    public function updatelogo(){         
        if(filter_images($_FILES['logoimg'])) {
            $filename = $_FILES['logoimg']['name'];
            $AWS = new AmazonS3();  
            $old_logo = $this->GM->check_old_logo();
            if(!empty($old_logo)){
                if($AWS->checkFiles($this->bucketname, $old_logo)) $AWS->removeFile($this->bucketname,$old_logo); 
            }
            $AWS->sendFile($this->bucketname,$filename, 'Test...','public-read');
            $return = $this->GM->updatelogo($filename);                
            if ($return){
                 $id = 1;
                 $str = $this->lang->line('save_success');
            }else{
                 $id = 2;
                 $str = $this->lang->line('save_failed');
            }             
            $res = loadMessage($id,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);  
        }     
    }
        
   
                 
}
