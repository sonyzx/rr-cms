<?php
/**
 * Description of Globals_model
 *
 * @author wahyu
 */
class Globals_model extends CI_model{
    
    var $sessionID;
    var $lang;
    var $current_lang;
    
    public function __construct() {
        parent::__construct();       
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
    }
        
    /**
    * Function get_data_byId
    * description : take row data from database
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_data_byId($id){
        $result = $this->db->get_where('globals',array('userID',$id));        
        return $result->row();
    }
    
    
    public function insert($filename){            
        $titlesite     =  filter_string($this->input->post("titlesite",true));
        $metadata   =  filter_string($this->input->post("metadata",true)); 
        $introtext    =  filter_string($this->input->post("intro",true));
        $copyright    = filter_string($this->input->post("copyright",true));
        $contactUs   = filter_string($this->input->post("contactUs",true));
        $email       = filter_string($this->input->post("email",true));                 
        $array_data  = array('copyright' => $copyright,
                           'contactUs'=> create_serialize_data($contactUs,$this->lang),
                           'email' => $email,
                           'postdate'=>time(),     
                           'metadata' => create_serialize_data($metadata,$this->lang),
                           'titlesite' => create_serialize_data($titlesite,$this->lang),
                           'introtext' => create_serialize_data($introtext,$this->lang),
                           'logo' => $filename,
                           'userID'=>$this->sessionID);            
        $this->db->insert('globals', $array_data);     
        $postID=$this->db->insert_id(); 
	
         /* initial bodypost value entries */
        #heading
        $heading = $this->input->post('heading[]');
        for($i=0;$i<count($heading);$i++){
           if(!empty($heading[$i])){
               $array_data1=array('content '=>  create_serialize_data(filter_string($heading[$i]), $this->lang),
                               'postID' => $postID,
                               'bodyType' => 'introtext' );
               $this->db->insert('bodypost', $array_data1); 
           }
        }
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
     /**
    * Function get_postbody
    * description : take row data from database    
    * @param Integer $id primarykey   
    * @return array 
    */
    public function get_postbody($id){
        $result = $this->db->get_where('bodypost',array('postID'=>$id));        
        return $result->result_array();
    }
    
    public function update_map(){
        $latitude     =  $this->input->post("latitude",true);
        $longitude    =  $this->input->post("longitude",true);
        $array_data   = array("latitude"=>$latitude,
                              "longitude"=>$longitude);
        $this->db->where('userID', $this->sessionID);
        $this->db->update('globals', $array_data);    
        return ($this->db->affected_rows()==0)? false : true;
    }
    
    
    public function update($old,$filename){   
        $titlesite     =  $this->input->post("titlesite",true);
        $metadata   =  filter_string($this->input->post("metadata",true)); 
        $introtext    =  $this->input->post("intro",true);
        $copyright    = filter_string($this->input->post("copyright",true));
        $contactUs   = filter_string($this->input->post("contactUs",true));
        $email       = filter_string($this->input->post("email",true));    
        $oldpb       = $this->get_postbody($old->globalID);
        $heading     = $this->input->post('heading[]');
        if(!empty($oldpb)){
            foreach($oldpb as $row=>$val):                                                             
                       $this->db->where('bodyID',$val['bodyID']);
                       $this->db->where('postID',$val['postID']);
                       $this->db->delete('bodypost');                                   
            endforeach;
        }
        for($i=0;$i<count($heading);$i++){
           if(!empty($heading[$i])){
                $array_data1=array('content '=>  create_serialize_data($heading[$i], $this->lang),
                                'postID' => $old->globalID,
                                'bodyType' => 'introtext' );
                $this->db->insert('bodypost', $array_data1); 
           }                
        }
       
        $filepic = (empty($filename))? $old->logo : $filename;
       
        $array_data  = array('copyright' => $copyright,
                          'email' => $email,  
                          'contactUs'=> create_serialize_data($contactUs,$this->lang,$old->contactUs,$this->mytemplate->currentLang()),
                          'titlesite'=> create_serialize_data($titlesite,$this->lang,$old->titlesite,$this->mytemplate->currentLang()),
                          'introtext'=> create_serialize_data($introtext,$this->lang,$old->introtext,$this->mytemplate->currentLang()),
                          'metadata'=> create_serialize_data($metadata,$this->lang,$old->metadata,$this->mytemplate->currentLang()),
                          'logo' => $filepic
                        );         
        $this->db->where('userID', $this->sessionID);
        $this->db->update('globals', $array_data);                      
        return ($this->db->affected_rows()==0)? false : true;
    }
    
    
     /**
    * Function getLanguage
    * description : take array language data from database 
    * @return array 
    */
    
    public function getLanguage(){   
        $result = $this->db->get('language')->result_array();                        
        return $result;
    }
    
    public function check_old_logo(){
        
    }
            
}