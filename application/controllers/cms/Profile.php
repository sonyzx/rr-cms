<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    private $sessionID;
    public $bucket_name;
    public $AWS;
    public $directoryuser;
    
    public function __construct() {
        parent::__construct();   
        $this->sessionID = $this->mytemplate->mySessionID();   
        $this->AWS = new AmazonS3(); 
        $this->bucket_name = "roomsranger";
        $this->load->model("Users_model");     
        $this->directoryuser = $this->session->userdata("userName");       
    }

    public function index()
    {             
         $data['tittle'] = $this->lang->line('tittle_prof'); 
         $profile = $this->Users_model->get_data_byId($this->sessionID);                  
         $data['email'] = empty($profile->email) ? '' : $profile->email;
         $data['userName'] = empty($profile->userName) ? '' : $profile->userName;
         
         $data['firstname'] = empty($profile->firstname) ? '' : $profile->firstname;
         $data['lastname'] = empty($profile->lastname) ? '' : $profile->lastname;
         $data['phonenumber'] = empty($profile->phonenumber) ? '' : $profile->phonenumber;
         $data['address'] = empty($profile->address) ? '' : $profile->address;
         $data['city'] = empty($profile->city) ? '' : $profile->city;
         $data['state'] = empty($profile->state) ? '' : $profile->state;
         $data['zip'] = empty($profile->zip) ? '' : $profile->zip;
         $data['soc_fb'] = empty($profile->soc_fb) ? '' : $profile->soc_fb;
         $data['soc_in'] = empty($profile->soc_in) ? '' : $profile->soc_in;
         $data['soc_plus'] = empty($profile->soc_plus) ? '' : $profile->soc_plus;
         $data['soc_twit'] = empty($profile->soc_twit) ? '' : $profile->soc_twit;
         if(empty($profile->profile_pic)){
            $data['profile_pic'] = '<img id="avatarprofile" class="img-responsive img-profile" src="'.site_url("assets/img/no-profile.gif").'">';
         }else{
            $s3_img = unserialize($profile->profile_pic);
            $thumb = $s3_img['raw_name'].'_thumb'.$s3_img['file_ext'];
            $url_avatars3 = 'https://s3-us-west-1.amazonaws.com/'.$this->bucket_name.'/'.$this->directoryuser.'/'.$thumb; 
            $data['profile_pic'] = '<img id="avatarprofile" class="img-responsive thumb-article img-profile" src="'.$url_avatars3.'">';            
         }         
         $data['about'] = empty($profile->about) ? '' : show_data_serialize($profile->about,$this->mytemplate->currentLang());
         
         $this->mytemplate->loadTemplate(2,'users/profile',$data);        
    }
    
    public function submit_information(){
         $this->form_validation->set_rules('firstname', 'First name', 'required');
         $this->form_validation->set_rules('phonenumber', 'Phone number', 'required');
         $this->form_validation->set_rules('address', 'Address', 'required');
         $this->form_validation->set_rules('city', 'City', 'required');
         $this->form_validation->set_rules('state', 'State', 'required');
         $this->form_validation->set_rules('zip', 'ZIP', 'required|min_length[5]|max_length[6]');         
         $this->form_validation->set_rules('about', 'About', 'required');
         
         if ($this->form_validation->run() == FALSE){   
             $str = validation_errors();
             $res = loadMessage(2,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{              
              $return = $this->Users_model->update_info();             
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
    
    public function update_profile_pic(){
         $old = $this->Users_model->get_data_byId($this->sessionID);         
         if(filter_images($_FILES['pictureprofile'])) {                               
              $_data  = $this->mytemplate->upload_file('./uploads/','pictureprofile');                        
              $bigimg = array("name"=> $_data['file_name'],
                              "tmp_name" => $_data['full_path'] );
              $thumbimg = array("name"=> $_data['raw_name'].'_thumb'.$_data['file_ext'],
                              "tmp_name" => $_data['thumb'] );
              
              if ($old->profile_pic !=''){
                    $img_avatar = unserialize($old->profile_pic);            
                    $thumbavatar = $img_avatar['raw_name'].'_thumb'.$img_avatar['file_ext'];  
                    // delete thumbnail avatar 
                    if ($this->AWS->checkFiles($this->bucket_name, $thumbavatar)) $this->AWS->removeFile($this->bucket_name, $thumbavatar);
                    // delete image avatar  
                    if ($this->AWS->checkFiles($this->bucket_name, $img_avatar['file_name'])) $this->AWS->removeFile($this->bucket_name, $img_avatar['file_name']);
              }    
              
              $this->AWS->sendFile($this->bucket_name,$bigimg,'avatar image','public-read');
              $res["urlavatar"] =  $this->AWS->sendFile($this->bucket_name,$thumbimg, 'thumbnail avatar users','public-read');
              unlink($_data['full_path']);
              unlink($_data['thumb']);
              $filename    = serialize($_data);
              $return = $this->Users_model->update_picture($filename);             
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
    
    public function changepassword(){
        $this->form_validation->set_rules('oldpassword', 'Old password', 'required');
        $this->form_validation->set_rules('newpassword', 'New passwordr', 'required|min_length[8]|max_length[30]');
        $this->form_validation->set_rules('retypepassword', 'Retype password', 'required|matches[newpassword]');
        $check = $this->Users_model->get_data_byId($this->sessionID);
        $oldpassword1   = $check->userPassword;
        $oldpassword2 = filter_string($this->input->post('oldpassword',true)); 
        $newpassword = filter_string($this->input->post('newpassword',true));         
        if($oldpassword1 != sha1($oldpassword2)){        
            $res = loadMessage(2,'Old password wrong');  
            header('Content-Type: application/json');
            echo json_encode($res);exit;
        }
        if ($this->form_validation->run() == FALSE){            
             exit;
        }else{
              $return = $this->Users_model->update_password(sha1($newpassword));             
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
