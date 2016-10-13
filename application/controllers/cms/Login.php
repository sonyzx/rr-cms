<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
            
    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');        
    }
    
    public function index()
    {                     
        $data['module'] = "Login";
        $this->load->view('cms/login');
    }
    
    public function check(){
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE){   
             $str = validation_errors();
             $res = loadMessage(2,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{ 
             $return = $this->Users_model->check_login();
             if(!$return){
                $res = loadMessage(2,"You don't have access permission.");  
                header('Content-Type: application/json');                
                echo json_encode(array('ok'=>0,  'msg'=>$res));
                exit;
             }else{
                $url_location = site_url('cms/main'); 
                echo json_encode(array('ok'=>1,  'dashboad'=>strval($url_location)));
                exit;
             }
         }
        
    }
    
}

