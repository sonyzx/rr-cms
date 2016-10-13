<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    private $AWS;
    public $bucketname;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->AWS = new AmazonS3();
        $this->bucketname = 'roomsranger';
    }
    
    public function index()
    {                     
        $data['module'] = "Users";
        $this->mytemplate->loadTemplate(2,'users/index',$data);
    }
    
    
     public function filldata(){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'firstname', 
                    1 => 'userName',
                    2 => 'email',
                    3 => 'lastlogin'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Users_model->get_data($params);  
        $totalData = $this->Users_model->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){      
                $code = encode_url($row["userID"]);
                $val_date = convert_date($row["lastlogin"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $nestedData[] = $row["firstname"].' '.$row['lastname'];              
                $nestedData[] = $row["userName"];   
                $nestedData[] = $row['email'];
                $nestedData[] = $val_date['date'].' '.$val_date['time'];                
                //add html for action
                $nestedData[] = '<a title="Update" href="'.site_url("cms/users/post/update")."/".$code.'")"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_users('."'".$code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
         $codeID = decode_url($id);
         $data['tittle'] = $mode.' Users'; 
         $profile = $this->Users_model->get_data_byId($codeID);                  
         $data['email'] = empty($profile->email) ? '' : $profile->email;
         $data['userName'] = empty($profile->userName) ? '' : $profile->userName;
         $data['levelaccess'] = empty($profile->levelaccess) ? '' : $profile->levelaccess;
         
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
         $data['profile_pic'] = empty($profile->profile_pic) ? '<img class="img-responsive img-profile" src="'.site_url("assets/img/no-profile.gif").'">' : '<img class="img-responsive img-profile" src="'.site_url("uploads/profile/{$profile->profile_pic}").'">';
         $data['about'] = empty($profile->about) ? '' : show_data_serialize($profile->about,$this->mytemplate->currentLang());
         
        $this->mytemplate->loadTemplate(2,'users/frm_users',$data);
    }
    
    public function changepassword(){
        $this->form_validation->set_rules('oldpassword', 'Old password', 'required');
        $this->form_validation->set_rules('newpassword', 'New passwordr', 'required|min_length[8]|max_length[30]');
        $this->form_validation->set_rules('retypepassword', 'Retype password', 'required|matches[newpassword]');
        $this->form_validation->set_rules('level', 'Level access', 'required');
        $check = $this->Users_model->get_data_byId($this->sessionID);
        $oldpassword1   = $check->userPassword;
        $oldpassword2 = filter_string($this->input->post('oldpassword',true)); 
        $newpassword = filter_string($this->input->post('newpassword',true)); 
        
        if($oldpassword1 != md5($oldpassword2)){
            $res = loadMessage(2,'Old password wrong');  
            header('Content-Type: application/json');
            echo json_encode($res);exit;
        }
        if ($this->form_validation->run() == FALSE){            
             exit;
        }else{
              $return = $this->Users_model->update_password(md5($newpassword));             
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
    
    public function delete($id){           
         $return = $this->Users_model->delete_data(decode_url($id));
         $id = ($return)? 1 : 2;
         $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed');               
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);       
    }
    
    public function logout(){
        $this->Users_model->update_activity(FALSE);
        $newdata = array(
                'userID' => '',
                'userName' => '',
                'levelaccess' => ''
            );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('cms/login');
    }
    
    public function reset_password(){
        $result = $this->Users_model->check_useremail();
        if(empty($result)){
            $res = loadMessage(2,'Your email is not registered. Please create new user.');  
            header('Content-Type: application/json');
            echo json_encode($res); 
        }else{           
            // generate new password 
            $newpass = substr(encode_url(rand(1, 899),PUBKEY),1,10);            
            $this->Users_model->update_password(sha1($newpass),$result->userID);
            $email   = $result->email;
            $subject   = "Request Reset Password";  
            $bodyemail = "Dear ".$result->firstname." ".$result->lastname.",<br />";            
            $bodyemail .= "Your password has been reset to : <br /> <br />";
            $bodyemail .= $newpass;
            $bodyemail .= "<br /> <br />";
            $bodyemail .= "We recommend to change the password immediately when you log in to your site. <br />";
            $bodyemail .= "You can change the password using the menu items My Profile > Change Password.<br />";
            $bodyemail .= "Please note that for logging in you will need to use both your user name or your email and your password.";
            $bodyemail .= "Your user name was shown to you when you confirmed your password reset request. If you forgot your user ";
            $bodyemail .= "name, you should submit your password reset request again and save the user name.<br /><br />";
            $bodyemail .= "Best regards,<br />";
            $bodyemail .= "Administrator Site. <br /><br />";
            $bodyemail .= "<hr />";
            $bodyemail .= "Please do not reply to this email. This email address is used only for sending email so you will not receive a response.";                
            $sendmail = $this->myemail->send_email_smtp($email,$subject,'',$bodyemail);
             $res = loadMessage(4,'Reset password has been send to your email.');  
            header('Content-Type: application/json');
            echo json_encode($res); 
        }
    }
    
    public function signup(){
        $this->form_validation->set_rules('firstname', 'Fistname', 'required|callback_username_check');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Your email', 'required|valid_email|callback_email_check');        
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[30]');
        $this->form_validation->set_rules('retypepassword', 'Retype password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE){   
            $str = validation_errors(); 
            $res = loadMessage(2,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;    
        }else{                  
            $this->Users_model->registration();    
            $firstname   =  filter_string($this->input->post("firstname",true)); 
            $lastname    = filter_string($this->input->post("lastname",true));
            $username   = filter_string($this->input->post("username",true));
            $email       = filter_string($this->input->post("email",true)); 
            $link_activate = site_url("cms/users/activate/".encode_url($username));
            $subject   = "Please confirm your email addres.";  
            $bodyemail = "Dear ".$firstname." ".$lastname.",<br />";                        
            $bodyemail .= "Thanks for registering, please follow the link below to activate your account. <br /><br />";
            $bodyemail .= "<a href='".$link_activate."' target='_blank'>".$link_activate."</a><br /><br />";            
            $bodyemail .= "Please note that for logging in you will need to use both your user name or your email and your password, after activation process.<br />";
            $bodyemail .= "Your user name was shown to you when you confirmed your password reset request. If you forgot your user";
            $bodyemail .= "name, you should submit your password reset request again and save the user name.<br /><br />";
            $bodyemail .= "Best regards,<br />";
            $bodyemail .= "Administrator Site. <br />";
            $bodyemail .= "<hr />";
            $bodyemail .= "Please do not reply to this email. This email address is used only for sending email so you will not receive a response.";                
            $sendmail = $this->myemail->send_email_smtp($email,$subject,'',$bodyemail);
            $res = loadMessage(4,'The link activation email has been sent to your email. Please check to complete the registration process.');  
            header('Content-Type: application/json');
            echo json_encode($res); 
        }
    }
    
    public function username_check()
    {
        $the_username = $this->input->post('username',true);
        $username = $this->Users_model->check_username($the_username);
        if (!empty($username))
        {
            $this->form_validation->set_message('username_check', 'The username already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function email_check()
    {
        $username = $this->Users_model->check_useremail();
        if (!empty($username))
        {
            $this->form_validation->set_message('email_check', 'The email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function activate($username){           
        $data['module'] = "Login";      
        $username = decode_url($username);                  
        $result = $this->Users_model->activate_user($username);                       
        $data['activeuser'] =($result)? loadMessage(1,'Activation user successfully.'): '';
        // create new folder on AWS S3   
        $row = $this->Users_model->getdata_byusername($username);        
        if(isset($row->userName)){
            $this->AWS->createDir($this->bucketname,$row->username);
        }              
        $this->load->view('cms/login',$data);
    }
        
    
          
}

