<?php
/**
 * Description of Buckets_model
 *
 * @author wahyu
 */
class Buckets_model extends CI_model{
    
    private $sessionID;
    private $lang;
    private $table;
    private $date;
    private $current_lang;
    
    public function __construct() {
        parent::__construct();       
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->table = 'bucket';
        $this->date = new DateTime();   
        $this->current_lang = $this->mytemplate->currentLang();
    }
       
     /**
    * Function get_data
    * description : publish data from database
    * @param array $select_data 
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data($params){             
       $where = !empty($params['search'])? " WHERE b.bucketName LIKE '%".$params['search']."%' " : ""; 
       $result = $this->db->query("SELECT * FROM bucket AS b JOIN block AS k ON b.blockID=k.blockID  ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
    public function get_count(){
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
    
    public function add(){           
        $bucketname   = filter_string($this->input->post("bucketname",true));
        $blocktype   = filter_string($this->input->post("blocktype",true));
        $array_data  = array('bucketName' => $bucketname,
                          'blockID' => $blocktype, 
                          'datecreate'=> $this->date->format('U = Y-m-d H:i:s'));            
        $this->db->insert($this->table, $array_data);         
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function delete($id){    
        $this->db->where('bucketID', $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
     /**
    * Function get_data_byId
    * description : take row data from database
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table,array('bucketID'=>$id));                
        return $result->row();
    }
    
    public function update_bucket(){          
        $id = decode_url($this->input->post('id'));
        $bucketname   = filter_string($this->input->post("bucketname",true));
        $blocktype   = filter_string($this->input->post("blocktype",true));      
        $array_data  = array('bucketName' => $bucketname,
                          'blockID' => $blocktype);                           
        $this->db->where('bucketID', $id);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function showblock(){
       $result = $this->db->get($this->table)->result_array();
       return $result;
    }
        
    
   
   
   
    
    
   
    
}