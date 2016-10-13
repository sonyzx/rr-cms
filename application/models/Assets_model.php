<?php
/**
 * Description of Globals_model
 *
 * @author wahyu
 */
class Assets_model extends CI_model{
    
    private $sessionID;
    private $levelaccess;
    private $lang;
    private $current_lang;
    private $date;
    private $table;
    
    
    public function __construct() {
        parent::__construct();       
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->levelaccess = $this->session->userdata("levelaccess");
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
        $this->date = new DateTime();                      
        $this->table = 'images';
    }
        
    /**
    * Function get_data_byId
    * description : take row data from database
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table,array('imagesID'=>$id));                
        return $result->row();
    }
    
    /**
    * Function get_array_bySession
    * description : take array data from database by session_id  
    * @return array 
    */
    public function get_array_bySession(){
        $result = $this->db->get_where($this->table,array('userID'=>$this->sessionID));                
        return $result->result_array();
    }
  
    public function get_array_by_userID($id){
        $result = $this->db->get_where($this->table,array('userID'=>$id));                
        return $result->result_array();
    }
    
     /**
    * Function get_data
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data($params){         
       $where  = " WHERE i.typeassets='".$params['type']."' ";
       $where .= ($this->levelaccess=="admin")? "" : "AND i.userID='".$this->sessionID."' ";
       $where .= !empty($params['search'])? " AND i.imagesCaption LIKE '%".$params['search']."%' OR u.userName LIKE '%".$params['search']."%' OR i.imagesDescription LIKE '%".$params['search']."%'" : "";                    
       $result = $this->db->query("SELECT * FROM images AS i JOIN users AS u ON u.userID=i.userID ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
    public function get_count($module){
        if($this->levelaccess!="admin"){
            $this->db->where(array("userID"=>$this->sessionID,"typeassets"=>$module));
        }    
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
    
    public function insert($row){  
        $array_data  = array('typeassets' => $row['typeassets'],
                           'imagesCaption'=> $row['imagesCaption'],
                           'imagesFile'=> $row['imagesFile'],                           
                           'postDate'=> $row['postDate'],  
                           'imagesDescription' => $row['imagesDescription'],
                           'userID'=>$row['userID']);            
        $this->db->insert($this->table, $array_data);         
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function update_desc(){ 
        $id = decode_url($this->input->post('id'));
        $old = $this->get_data_byId($id);
        $imgcaption = filter_string($this->input->post('imagesCaption',true));
        $imgdescription = $this->input->post('imagesDescription',true);
        $array_data = array(
                'imagesCaption' => create_serialize_data($imgcaption,$this->lang,$old->imagesCaption,$this->current_lang),
                'imagesDescription' => create_serialize_data($imgdescription,$this->lang,$old->imagesDescription,$this->current_lang)
        );                             
        $this->db->where('imagesID', $id);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function delete_byId($id)
    {
        $this->db->where('imagesID', $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows()!=0)? true : false;
    }
     
   
    
}