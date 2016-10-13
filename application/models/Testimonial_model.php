<?php
/**
 * Description of Testimonial_model
 *
 * @author wahyu
 */
class Testimonial_model extends CI_model{
    
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
        $this->table = 'post';
        $this->date = new DateTime();                      
    }
    
     /**
    * Function get_data
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data($params){                   
       $where = !empty($params['search'])? " AND `postTitle` LIKE '%".$params['search']."%' OR postHeading LIKE '%".$params['search']."%'" : "";        
       $result = $this->db->query("SELECT * FROM post WHERE postModule='testimonial' ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
    public function get_testimony($userID){
        $result = $this->db->query("SELECT * FROM post WHERE postModule='testimonial' AND userID=".$userID);
        return $result->result_array();
    }
    
    public function get_count(){         
        $this->db->where("postModule","testimonial");
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
    
    
     /**
    * Function get_data_byId
    * description : take row data from database
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table,array('postID'=>$id));        
        return $result->row();
    }
    
    public function insert($picdb){    
        /* initial main value entries */
        $postTitle      = filter_string($this->input->post("postTitle",true));
        $postSubheading = $this->input->post("postSubheading",true);        
        $postDescription   = $this->input->post("postDescription",true);
        $postHeading        = filter_string($this->input->post("postHeading",true));
        
        $array_data  = array('postTitle' => $postTitle,
                         'postSubheading'=> $postSubheading,                         
                         'postDescription'=> create_serialize_data($postDescription,$this->lang),
                         'postHeading'=> $postHeading,
                         'postModule'=> "testimonial",
                         'postImages' => $picdb['logo'],
                         'dateEntry' => $this->date->format('U = Y-m-d H:i:s'), 
                         'userID'=>$this->sessionID);            
        $this->db->insert($this->table, $array_data);   
        return ($this->db->affected_rows()==1)? true : false;
    }
        
    
    public function update($id,$picdb){        
        $postTitle      = filter_string($this->input->post("postTitle",true));
        $postSubheading = $this->input->post("postSubheading",true);        
        $postDescription   = $this->input->post("postDescription",true);
        $postHeading        = filter_string($this->input->post("postHeading",true));
        
        $old = $this->get_data_byId($id);      
        
        if(empty($picdb['logo'])){
            $filelogo = $old->postImages;
        }else{
            $filelogo = $picdb['logo'];            
        }
        
         $array_data  = array('postTitle' => $postTitle,
                         'postSubheading'=> $postSubheading,                         
                         'postDescription'=> create_serialize_data($postDescription,$this->lang,$old->postDescription,$this->current_lang),
                         'postHeading'=> $postHeading,                         
                         'postImages' => $filelogo);                                  
        $this->db->where('postID', $old->postID);
        $this->db->update($this->table, $array_data);      
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function delete_data($id){               
        $this->db->where('postID', $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
  
}
