<?php
/**
 * Description of Hotel_model
 *
 * @author wahyu
 */
class Hotel_model extends CI_model{
    
    private $sessionID;
    private $levelaccess;
    private $lang;
    private $current_lang;
    private $table;
    private $date;        
    
    public function __construct() {
        parent::__construct();
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->levelaccess = $this->session->userdata("levelaccess");
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
        $this->table = 'hotel';
        $this->date = new DateTime();                      
    }
    
   /**
    * Function get_array_db
    * description : take array data from database
    * @param String $tablenm table name   
    * @return array 
    */
    public function get_array_db(){
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function get_array_db_byuserID($id){
       $result = $this->db->get_where($this->table,array('userID'=>$id));                
        return $result->result();
    }
    
    /**
    * Function get_data_byId
    * description : take row data from database
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table,array('hotelid'=>$id));        
        return $result->row();
    }
    
     /**
    * Function getHotel_byID
    * description : take hotel by ID
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function getHotel_byID($id){
        $result = $this->db->get_where($this->table,array('hotelid'=>$id));        
        return $result->row();
    }
    
     /**
    * Function get_data
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data($params){      
       $where = ($this->levelaccess=="admin")? "" : "WHERE h.userID='".$this->sessionID."' ";        
       $where .= !empty($params['search'])? " AND h.`hotelname` LIKE '%".$params['search']."%' OR h.street LIKE '%".$params['search']."%'" : "";        
       $result = $this->db->query("SELECT * FROM hotel AS h JOIN users AS s ON h.userID=s.userID  ".$where."  ORDER BY h.".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
     public function get_count(){
          if($this->levelaccess!="admin"){
            $this->db->where("userID",$this->sessionID);
        }   
        $this->db->where("act_delete",0);
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
    
    
    public function insert($picdb){    
        /* initial main value entries */
        $hotel_name  = filter_string($this->input->post("hotel_name",true));
        $slug        = filter_string($this->input->post("slug",true));
        $shortdesc   = $this->input->post("shortdesc",true);
        $maindesc   = $this->input->post("maindesc",true);
        $star        = filter_string($this->input->post("star",true));
        $ownerid     = filter_string($this->input->post("ownerid",true));        
        $businessname   = filter_string($this->input->post("businesname",true));
        $businessnumber   = filter_string($this->input->post("businesnumber",true));
        $street1   = filter_string($this->input->post("street1",true));
        $street2   = filter_string($this->input->post("street2",true));
        $state      = filter_string($this->input->post("state",true));  
        $postcode      = filter_string($this->input->post("postcode",true));
        $country      = filter_string($this->input->post("country",true));
        $longitude      = filter_string($this->input->post("longitude",true));
        $latitude      = filter_string($this->input->post("latitude",true));
        $phone1      = filter_string($this->input->post("phone1",true));
        $phone2      = filter_string($this->input->post("phone2",true));
        $email1      = filter_string($this->input->post("email1",true));
        $email2      = filter_string($this->input->post("email2",true));
        $fax        = filter_string($this->input->post("fax",true));
        $tra        = filter_string($this->input->post("tra",true));
        $roomtotal   = filter_string($this->input->post("roomtotal",true));
        $timezone   = filter_string($this->input->post("timezone",true));
        $deposit   = filter_string($this->input->post("deposit",true));
        $currency   = filter_string($this->input->post("currency",true));
       
        $array_data  = array('slug' => $slug,
                         'owner_id'=> $ownerid,
                         'hotelname'=> $hotel_name,
                         'business_name'=> $businessname,
                         'business_number'=> $businessnumber,
                         'street'=> $street1,
                         'street2'=> $street2,
                         'state'=> $state,
                         'postcode'=> $postcode,
                         'country'=> $country,
                         'short_description'=> create_serialize_data($shortdesc,$this->lang),
                         'main_description'=> create_serialize_data($maindesc,$this->lang),  
                         'stars'=> $star,
                         'phone1'=> $phone1,
                         'phone2'=> $phone2,
                         'email1'=> $email1,
                         'email2'=> $email2,
                         'fax'=> $fax,
                         'total_rooms_active'=> $tra,
                         'logo' => $picdb['logo'],
                         'feature_image' => $picdb['feature'],
                         'longitude'=> $longitude,
                         'latitude'=> $latitude,
                         'rooms_total'=> $roomtotal,
                         'timezone'=> $timezone,
                         'deposit'=> $deposit,
                         'currency_id' =>$currency,
                         'date_created' => $this->date->format('U = Y-m-d H:i:s'), 
                         'userID'=>$this->sessionID);            
        $this->db->insert($this->table, $array_data);   
        return ($this->db->affected_rows()==1)? true : false;
    }
        
    
    public function update($id,$picdb){        
        $hotel_name  = filter_string($this->input->post("hotel_name",true));
        $slug        = filter_string($this->input->post("slug",true));
        $shortdesc   = $this->input->post("shortdesc",true);
        $maindesc   = $this->input->post("maindesc",true);
        $star        = filter_string($this->input->post("star",true));
        $ownerid     = filter_string($this->input->post("ownerid",true));        
        $businessname   = filter_string($this->input->post("businesname",true));
        $businessnumber   = filter_string($this->input->post("businesnumber",true));
        $street1   = filter_string($this->input->post("street1",true));
        $street2   = filter_string($this->input->post("street2",true));
        $state      = filter_string($this->input->post("state",true));  
        $postcode      = filter_string($this->input->post("postcode",true));
        $country      = filter_string($this->input->post("country",true));
        $longitude      = filter_string($this->input->post("longitude",true));
        $latitude      = filter_string($this->input->post("latitude",true));
        $phone1      = filter_string($this->input->post("phone1",true));
        $phone2      = filter_string($this->input->post("phone2",true));
        $email1      = filter_string($this->input->post("email1",true));
        $email2      = filter_string($this->input->post("email2",true));
        $fax        = filter_string($this->input->post("fax",true));
        $tra        = filter_string($this->input->post("tra",true));
        $roomtotal   = filter_string($this->input->post("roomtotal",true));
        $timezone   = filter_string($this->input->post("timezone",true));
        $deposit   = filter_string($this->input->post("deposit",true));
        $currency   = filter_string($this->input->post("currency",true));
        
        $old = $this->get_data_byId($id);      
        
        if(empty($picdb['logo'])){
            $filelogo = $old->logo;
        }else{
            $filelogo = $picdb['logo'];            
        }
        
        if(empty($picdb['feature'])){
            $filefimage = $old->feature_image;
        }else{
            $filefimage = $picdb['feature'];            
        }
        
        $array_data  = array('slug' => $slug,
                         'owner_id'=> $ownerid,
                         'hotelname'=> $hotel_name,
                         'business_name'=> $businessname,
                         'business_number'=> $businessnumber,
                         'street'=> $street1,
                         'street2'=> $street2,
                         'state'=> $state,
                         'postcode'=> $postcode,
                         'country'=> $country,
                         'short_description'=> create_serialize_data($shortdesc,$this->lang,$old->short_description,$this->current_lang), 
                         'main_description'=> create_serialize_data($maindesc,$this->lang,$old->main_description,$this->current_lang),   
                         'stars'=> $star,
                         'phone1'=> $phone1,
                         'phone2'=> $phone2,
                         'email1'=> $email1,
                         'email2'=> $email2,
                         'fax'=> $fax,
                         'total_rooms_active'=> $tra,
                         'logo' => $filelogo,
                         'feature_image' => $filefimage,
                         'longitude'=> $longitude,
                         'latitude'=> $latitude,
                         'rooms_total'=> $roomtotal,
                         'timezone'=> $timezone,
                         'deposit'=> $deposit,
                         'currency_id' =>$currency);                          
        $this->db->where('hotelid', $old->hotelid);
        $this->db->update($this->table, $array_data);      
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function delete_data($id){       
        $this->db->where('hotelid', $id);
        $this->db->update($this->table,array('act_delete'=>1)); 
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function check_dependency($id){
         $result = $this->db->get_where('room_types',array('hotelid'=>$id));        
        return $result->row();
    }
    
}
