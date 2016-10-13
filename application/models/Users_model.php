<?php
/**
 * Description of Users_model
 *
 * @author wahyu
 */
class Users_model extends CI_model{
    
    private $sessionID;
    private $lang;
    private $table;
    private $date;   
    public $bucket_name;
    
    public function __construct() {
        parent::__construct();       
        $this->sessionID = $this->mytemplate->mySessionID();       
        $this->table = 'users';
        $this->date = new DateTime();   
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();        
        $this->bucket_name = 'roomsranger'; 
    }
       
    
    /**
    * Function get_array_db
    * description : take array data from database    
    * @return array 
    */
    public function get_array_db(){
        $query = $this->db->query("SELECT * FROM users");
        return $query->result_array();
    }
    
    
     /**
    * Function get_data_byId
    * description : take row data from database
    * @param Integer Session ID
    * @param String $tablenm table name     
    * @return row 
    */
    public function get_data_byId($sessionID){
        $result = $this->db->get_where($this->table,array('userID'=>$sessionID));        
        return $result->row();
    }
    
    public function update_info(){   
        $firstname   =  filter_string($this->input->post("firstname",true)); 
        $lastname    = filter_string($this->input->post("lastname",true));
        $phonenumber   = filter_string($this->input->post("phonenumber",true));
        $address       = filter_string($this->input->post("address",true));    
        $city       = filter_string($this->input->post("city",true));    
        $state       = filter_string($this->input->post("state",true));
        $zip       = filter_string($this->input->post("zip",true));                
        $about   = $this->input->post("about",true);
        $facebook   = $this->input->post("facebook",true);
        $linkedin   = $this->input->post("linkedin",true);
        $googleplus   = $this->input->post("googleplus",true);
        $twitter   = $this->input->post("twitter",true);
        
        $old = $this->get_data_byId($this->sessionID);
               
        $array_data  = array('firstname' => $firstname,
                          'lastname' => $lastname,  
                          'phonenumber' => $phonenumber, 
                          'address' => $address,
                          'city' => $city,
                          'state' => $state,
                          'zip' => $zip,                        
                          'about'=> create_serialize_data($about,$this->lang,$old->about,$this->mytemplate->currentLang()),
                          'soc_fb'=> $facebook,
                          'soc_in' => $linkedin,
                          'soc_plus' => $googleplus,
                          'soc_twit' => $twitter
                        );         
        $this->db->where('userID', $this->sessionID);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    
    public function update_picture($filename){                                   
        $array_data  = array('profile_pic' => $filename);         
        $this->db->where('userID', $this->sessionID);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function update_password($newpassword,$userID){
        $array_data  = array('userPassword' => $newpassword);             
        $this->db->where('userID', $userID);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    
    /**
    * Function get_data
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data($params){             
       $where = !empty($params['search'])? " WHERE userName LIKE '%".$params['search']."%' OR firstname LIKE '%".$params['search']."%' OR email LIKE '%".$params['search']."%'" : "";        
       $result = $this->db->query("SELECT * FROM users ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
   public function get_count(){
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
   
    public function delete_data($id){              
        $this->db->where('userID', $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function check_login(){
        $username = filter_string($this->input->post("email",true));
        $password = filter_string($this->input->post("password",true));
        $valpass = sha1($password);       
        $result = $this->db->query("SELECT * FROM users WHERE (userName='".strval($username)."' OR email='".strval($username)."')  AND userPassword='".$valpass."' AND isblock='no' "); 
        if ($result->num_rows() > 0){
            $row = $result->row();
            $newdata = array(
                'userID' => $row->userID,
                'userName' => $row->userName,
                'levelaccess' => $row->levelaccess
            );
            $this->session->set_userdata($newdata);
            $this->update_activity(TRUE);
            return TRUE;
        }
        return FALSE;
    }
   
    
    public function update_activity($islogin){
        $array_data  = ($islogin)? array('lastlogin' => $this->date->format('U = Y-m-d H:i:s'), 'isonline'=>1) :
                               array('isonline'=>0);
        $this->db->where('userID', $this->sessionID);
        $this->db->update($this->table, $array_data);   
    }
    
    
    public function check_useremail(){
        $the_email = $this->input->post('email',true);
        $result = $this->db->get_where($this->table,array('email'=>  filter_string($the_email)));        
        return $result->row();
    }
    
    public function check_username($the_username){        
        $result = $this->db->get_where($this->table,array('userName'=>  filter_string($the_username)));        
        return $result->row();
    }
    
    public function registration(){
        $firstname   =  filter_string($this->input->post("firstname",true)); 
        $lastname    = filter_string($this->input->post("lastname",true));
        $username   = filter_string($this->input->post("username",true));
        $email       = filter_string($this->input->post("email",true));    
        $password    = filter_string($this->input->post("password",true));    
        $ipaddress    = $this->input->ip_address();
                      
        $array_data  = array('firstname' => $firstname,
                          'lastname' => $lastname,  
                          'userName' => $username, 
                          'userPassword' => sha1($password),
                          'email' => $email,
                          'isblock' => 'yes',
                          'reg_date' => $this->date->format('U = Y-m-d H:i:s'),  
                          'levelaccess' => 'users',                        
                          'ipaddress'=> $ipaddress
                        );         
        $this->db->insert($this->table,$array_data);        
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function activate_user($username){
        $array_data  = array('activatedate' => $this->date->format('U = Y-m-d H:i:s'), 'isblock'=>'no');
        $this->db->where('userName', filter_string($username));
        $this->db->update($this->table, $array_data); 
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function getdata_byusername($username){
        $result = $this->db->get_where($this->table,array('userName'=>$username));        
        return $result->row();
    }
    
    
    
    
}