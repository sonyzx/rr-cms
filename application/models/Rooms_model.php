<?php
/**
 * Description of Rooms_model
 *
 * @author wahyu
 */
class Rooms_model extends CI_model{
    
    private $sessionID;
    private $lang;
    private $current_lang;
    private $levelaccess;
    private $table;
    private $date;        
    
    public function __construct() {
        parent::__construct();
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->levelaccess = $this->session->userdata("levelaccess");
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
        $this->table = array('room_types','room_types_photos','custom_room_amenities');
        $this->date = new DateTime();                      
    }
    
    
     /**
    * Function get_data_rooms
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_rooms($params){             
       $where = "WHERE r.act_delete=0 "; 
       $where .= !empty($params['search'])? " AND r.`roomname` LIKE '%".$params['search']."%' OR h.short_description LIKE '%".$params['search']."%'" : "";        
       $where .= ($this->levelaccess=="admin")? "" : "AND r.userID='".$this->sessionID."' ";
       $result = $this->db->query("SELECT * FROM hotel AS h JOIN room_types AS r ON h.hotelid=r.hotelid JOIN users AS u ON u.userID=r.userID  ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
    public function get_count_rooms(){
         if($this->levelaccess!="admin"){
            $this->db->where("userID",$this->sessionID);
        }   
        $this->db->where("act_delete",0);
        $result =  $this->db->count_all_results($this->table[0]);
        return $result;
    }
    
    
   /**
    * Function get_array_db
    * description : take array data from database
    * @param String $tablenm table name   
    * @return array 
    */
    public function get_array_db(){
        $query = $this->db->get($this->table[0]);
        return $query->result();
    }
    
    public function get_array_db_byuserID($id){        
        $query = $this->db->get_where($this->table[0],array('userID'=>$id));    
        return $query->result();
    }
    
     /**
    * Function get_types_photo
    * description : take array data from database
    * @param String $tablenm table name   
    * @return array 
    */
    public function get_types_photo(){
        $query = $this->db->get($this->table[1]);
        return $query->result();
    }
    
    /**
    * Function get_data_byId
    * description : take row data from database
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table[0],array('roomtypeid'=>$id));        
        return $result->row();
    }
    
    public function RoomTypesPhotos($id,$hotelid){                
        $result = $this->db->get_where($this->table[1],array('roomtypeid'=>$id,'hotelid'=>$hotelid));        
        return $result->result_array();
    }
          
   public function insert(){    
        /* initial main value entries */
        $roomnames  = filter_string($this->input->post("roomnames",true));
        $hotelid      = filter_string($this->input->post("hotelid",true));
        $short_description   = $this->input->post("short_description",true);
        $main_description   = $this->input->post("main_description",true);
        $enabled        = filter_string($this->input->post("enabled",true));
        $colours     = filter_string($this->input->post("colours",true));        
        $hourly_rate   = filter_string($this->input->post("hourly_rate",true));
        $private_room   = filter_string($this->input->post("private_room",true));
        $widget_minimum_stay   = filter_string($this->input->post("widget_minimum_stay",true));
        $gender   = filter_string($this->input->post("gender",true));
        $occupancy      = filter_string($this->input->post("occupancy",true));  
        $mon      = filter_string($this->input->post("mon",true));
        $tue      = filter_string($this->input->post("tue",true));
        $wed      = filter_string($this->input->post("wed",true));
        $thu      = filter_string($this->input->post("thu",true));
        $fri      = filter_string($this->input->post("fri",true));
        $sat      = filter_string($this->input->post("sat",true));
        $sun      = filter_string($this->input->post("sun",true));
        $widget_footer     = filter_string($this->input->post("widget_footer",true));
        $image_url        = $this->input->post("image_url",true);
      
       
        $array_data  = array('hotelid' => $hotelid,
                         'roomname'=> $roomnames,
                         'main_description'=> create_serialize_data($main_description,$this->lang),
                         'short_description'=> create_serialize_data($short_description,$this->lang),
                         'active'=> ($enabled=='on')? 1 : 0,
                         'colour'=> $colours,
                         'mon'=> $mon,
                         'tue'=> $tue,
                         'wed'=> $wed,
                         'thu'=> $thu,
                         'fri' => $fri,
                         'sat' => $sat,
                         'sun' => $sun,
                         'hourly_rate' => $hourly_rate,
                         'gender' => $gender,
                         'occupancy' => $occupancy,
                         'private_room' => $private_room,
                         'image_url' => $image_url,
                         'widget_footer' => $widget_footer,
                         'widget_minimum_stay' => $widget_minimum_stay);            
        $this->db->insert($this->table[0], $array_data);   
        $roomtypeid = $this->db->insert_id();         
        
        $otherImage = $this->input->post("urlimages[]",true);
         for($i=0;$i<count($otherImage);$i++){
           if(!empty($otherImage[$i])){
               $array_data1=array('roomtypeid '=>  $roomtypeid,
                               'hotelid' => $hotelid,
                               'url' =>  $otherImage[$i],
                               'sort_order' => 0 );
               $this->db->insert($this->table[1], $array_data1); 
           }
        }
        
        return ($this->db->affected_rows()==1)? true : false;
    }
    
    
     public function update(){
        $id = decode_url($this->input->post('id'));           
        $old  = $this->get_data_byId($id);         
        $oldp = $this->RoomTypesPhotos($id,$old->hotelid);        
        $roomnames  = filter_string($this->input->post("roomnames",true));
        $hotelid      = filter_string($this->input->post("hotelid",true));
        $short_description   = $this->input->post("short_description",true);
        $main_description   = $this->input->post("main_description",true);
        $enabled        = filter_string($this->input->post("enabled",true)); 
        $colours     = filter_string($this->input->post("colours",true));        
        $hourly_rate   = filter_string($this->input->post("hourly_rate",true));
        $private_room   = filter_string($this->input->post("private_room",true));
        $widget_minimum_stay   = filter_string($this->input->post("widget_minimum_stay",true));
        $gender   = filter_string($this->input->post("gender",true));
        $occupancy      = filter_string($this->input->post("occupancy",true));  
        $mon      = filter_string($this->input->post("mon",true));
        $tue      = filter_string($this->input->post("tue",true));
        $wed      = filter_string($this->input->post("wed",true));
        $thu      = filter_string($this->input->post("thu",true));
        $fri      = filter_string($this->input->post("fri",true));
        $sat      = filter_string($this->input->post("sat",true));
        $sun      = filter_string($this->input->post("sun",true));
        $widget_footer     = filter_string($this->input->post("widget_footer",true));
        $image_url        = $this->input->post("image_url",true);
        
        $otherImage = $this->input->post("urlimages[]",true);
//       echo count($otherImage);die();        
        if(!empty($oldp)){                                                                   
            $this->db->where('roomtypeid',$id);
            $this->db->where('hotelid',$old->hotelid);
            $this->db->delete($this->table[1]);                                            
        } 
        for($i=0;$i<count($otherImage);$i++){
           if(!empty($otherImage[$i])){
               $array_data1=array('roomtypeid '=>  $old->roomtypeid,
                               'hotelid' => $old->hotelid,
                               'url' =>  $otherImage[$i],
                               'sort_order' => 0 );
               $this->db->insert($this->table[1], $array_data1); 
           }                
        }
                      
       
        $array_data  = array('hotelid' => $hotelid,
                         'roomname'=> $roomnames,
                         'main_description'=> create_serialize_data($main_description,$this->lang,$old->main_description,$this->mytemplate->currentLang()),
                         'short_description'=> create_serialize_data($short_description,$this->lang,$old->short_description,$this->mytemplate->currentLang()),
                         'active'=> ($enabled=='on')? 1 : 0,
                         'colour'=> $colours,
                         'mon'=> $mon,
                         'tue'=> $tue,
                         'wed'=> $wed,
                         'thu'=> $thu,
                         'fri' => $fri,
                         'sat' => $sat,
                         'sun' => $sun,
                         'hourly_rate' => $hourly_rate,
                         'gender' => $gender,
                         'occupancy' => $occupancy,
                         'private_room' => $private_room,
                         'image_url' => $image_url,
                         'widget_footer' => $widget_footer,
                         'widget_minimum_stay' => $widget_minimum_stay);
        $this->db->where('roomtypeid', $id);
        $this->db->update($this->table[0], $array_data);                      
        return ($this->db->affected_rows()==0)? false : true;
    }
    
    
    public function delete_data($id){   
        $this->db->where(array('roomtypeid'=>$id));
        $this->db->update($this->table[0],array('act_delete'=>1));              
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
}
