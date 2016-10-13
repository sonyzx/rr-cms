<?php
/**
 * Description of Blocks_model
 *
 * @author wahyu
 */
class Blocks_model extends CI_model{
    
    private $sessionID;
    private $lang;
    private $table;
    private $date;
    private $current_lang;
    
    public function __construct() {
        parent::__construct();       
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->table = 'block';
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
       $where = !empty($params['search'])? " WHERE blockType LIKE '%".$params['search']."%' " : ""; 
       $result = $this->db->query("SELECT * FROM block ".$where."  ORDER BY ".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
    public function showblock(){
       $result = $this->db->get($this->table)->result_array();
       return $result;
    }
    
    public function get_count(){
        $result =  $this->db->count_all_results($this->table);
        return $result;
    }
    
    /**
    * Function get_data_byId
    * description : take row data from database
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where($this->table,array('blockID'=>$id));                
        return $result->row();
    }
    
   public function add(){                           
        $blocktype   = filter_string($this->input->post("blocktype",true));
        $array_data  = array('blockType' => create_serialize_data($blocktype,$this->lang),         
                           'datecreate'=> $this->date->format('U = Y-m-d H:i:s'));            
        $this->db->insert($this->table, $array_data);         
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function delete($id){
//        $this->db->where('blockID', $id);
//        $this->db->delete('userblocks');
        
        $this->db->where('blockID', $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function update_block(){          
        $id = decode_url($this->input->post('id'));
        $blockType= filter_string($this->input->post('blockType',true));
        $old = $this->get_data_byId($id);
        $array_data = array(
                'blockType' => create_serialize_data($blockType,$this->lang,$old->blockType,$this->current_lang),
        );                             
        $this->db->where('blockID', $id);
        $this->db->update($this->table, $array_data);                      
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    /**
    * Function get_array_db
    * description : take array data from database
    * @param String $tablenm table name   
    * @return array 
    */
    public function get_array_db(){
        $query = $this->db->query("SELECT * FROM block WHERE blockID NOT IN(SELECT blockID FROM userblocks WHERE act_delete=0 and userID={$this->sessionID})");
        return $query->result_array();
    }
    
     /**
    * Function get_myblock
    * description : show myblock ownsite
    * @param String $tablenm table name   
    * @return array 
    */
    public function get_myblock($id){
        $query = $this->db->query("SELECT * FROM userblocks u JOIN block c ON u.blockID=c.blockID WHERE u.act_delete=0 and u.userID={$id}");
        return $query->result_array();
    }
    
     /**
    * Function check_old_block
    * description : check old block has deleted
    * @param integer $blockID Block ID
    * @return integer 
    */
    
    public function check_old_block($blockID){        
        $arraydata=array('userID'=>$this->sessionID,
                       'act_delete'=>1,
                       'blockID'=>$blockID);                       
        $result = $this->db->get_where('userblocks',$arraydata);
        return $result->num_rows();
    }


    public function pushdata($id){  
        $check = $this->check_old_block($id);            
        if($check==0){
            $array_data  = array('blockID' => $id,
                               'userID'=> $this->sessionID,                           
                               'datecreate'=> $this->date->format('U = Y-m-d H:i:s'),                                                 
                               'userID'=>$this->sessionID);                      
            $this->db->insert('userblocks', $array_data);         
        }else{
            $this->db->where(array('blockID'=>$id,'userID'=>$this->sessionID));
            $this->db->update('userblocks',array('act_delete'=>0));
        }
        return ($this->db->affected_rows()!=0)? true : false;
    }
     
    public function deleteblock($id)
    {
        $this->db->where(array('blockID'=>$id,'userID'=>$this->sessionID));
        $this->db->update('userblocks',array('act_delete'=>1));
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function awsconnect(){        
        $this->db->truncate('awsconfig');
        $secret = $this->input->post('secret',true);
        $key   = $this->input->post('key',true);        
        $region = $this->input->post('region',true); 
        $arraydata = array('secret'=> encode_url($secret,'R4H421A'),
                        'key'=> encode_url($key,'R4H421A'),
                        'region'=>$region);
        $this->db->insert('awsconfig',$arraydata);
        return ($this->db->affected_rows()!=0)? true : false;
    }
    
    public function getawsconfig(){
        $aws = $this->db->get('awsconfig')->row();
        $return['key']   = isset($aws->key)? decode_url($aws->key,'R4H421A') : '';
        $return['secret'] = isset($aws->secret)? decode_url($aws->secret,'R4H421A') : '';
        $return['region'] = isset($aws->region)? $aws->region : '';
        return $return;
    }
    
   
   
    
    
   
    
}