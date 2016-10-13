<?php
/**
 * Description of Post_model
 *
 * @author wahyu
 */
class Post_model extends CI_model{
    
    private $sessionID;
    private $lang;
    private $current_lang;
    private $table;
    private $date;    
    public $AWS;
    public $bucket_name; 


    public function __construct() {
        parent::__construct();
        $this->sessionID = $this->mytemplate->mySessionID();        
        $this->lang = $config['bahasaPengantar'] = $this->mytemplate->arrayLanguage();
        $this->current_lang = $this->mytemplate->currentLang();
        $this->table = 'post';
        $this->date = new DateTime();                      
        $this->AWS = new AmazonS3(); 
        $this->bucket_name = 'roomsranger';
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
    
     /**
    * Function check_one_bysessionID
    * description : take one post article by session ID
    * @param String $tablenm table name
    * @param Integer $id primarykey   
    * @return array 
    */
    public function check_one_bysessionID(){
        $result = $this->db->get_where($this->table,array('userID'=>$this->sessionID));        
        return $result->row();
    }
    
    public function check_one_UserID($id){
        $result = $this->db->get_where($this->table,array('userID'=>$id));        
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
       $where  = " WHERE p.postModule='".$params['type']."' ";
       $where .= !empty($params['search'])? " AND p.postTitle LIKE '%".$params['search']."%' OR p.postDescription LIKE '%".$params['search']."%'" : "";        
       $result = $this->db->query("SELECT * FROM post AS p JOIN users AS s ON p.userID=s.userID  ".$where."  ORDER BY p.".$params['order']." ".$params['sorting']." LIMIT ".$params['start'].",".$params['finish'])->result_array();      
       return $result;        
    }
    
     public function get_count(){
        $result =  $this->db->count_all_results($this->table);
        return $result;
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
    
    public function insert(){    
        /* initial main value entries */
        $title        = filter_string($this->input->post("title_name",true));
        $shortdesc   = $this->input->post("shortdesc",true);
        $mainheading = filter_string($this->input->post("mainheading",true));
        $subheading  = filter_string($this->input->post("subheading",true));
        $module     = filter_string($this->input->post("entrytype",true));
        $slug       = filter_string($this->input->post("slug",true));
        $postdate   = $this->input->post("postdate",true);
        $timepicker1   = filter_string($this->input->post("timepicker1",true));
        $expirationdate   = $this->input->post("expirationdate",true);
        $timepicker2   = filter_string($this->input->post("timepicker2",true));
        $enabled      = filter_string($this->input->post("enabled",true));  
       
       
        $array_data  = array('postTitle' => create_serialize_data($title,$this->lang),
                         'postDescription'=> create_serialize_data($shortdesc,$this->lang),
                         'postHeading'=> create_serialize_data($mainheading,$this->lang),
                         'postSubheading'=> create_serialize_data($subheading,$this->lang),
                         'dateEntry'=> convert_format_totimestamp($postdate,$timepicker1),
                         'dateExpiration'=>convert_format_totimestamp($expirationdate,$timepicker2),
                         'postModule' => $module,
                         'postSlug' => create_serialize_data($slug,$this->lang),  
                         'publish' => ($enabled=='on')? 1 : 0,
                         'userID'=>$this->sessionID);            
        $this->db->insert('post', $array_data);   
        $postID=$this->db->insert_id(); 
	
         /* initial bodypost value entries */
        #heading
        $heading = $this->input->post('heading[]');
        for($i=0;$i<count($heading);$i++){
           if(!empty($heading[$i])){
               $array_data1=array('content '=>  create_serialize_data(filter_string($heading[$i]), $this->lang),
                               'postID' => $postID,
                               'bodyType' => 'heading' );
               $this->db->insert('bodypost', $array_data1); 
           }
        }
        
        #thetext
        $thetext = $this->input->post('thetext[]');
        $position_text = $this->input->post('position_text[]');
        for($x=0;$x<count($thetext);$x++){
           if(!empty($thetext[$x])){
               $array_data1=array('content '=>  create_serialize_data(filter_string($thetext[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_text[$x],
                               'bodyType' => 'text' );
               $this->db->insert('bodypost', $array_data1); 
           }
        }
        
        #pullquote
        $pullquote = $this->input->post('pullquote[]');
        $position_pq = $this->input->post('position_pq[]');
        for($x=0;$x<count($pullquote);$x++){
           if(!empty($pullquote[$x])){
               $array_data2=array('content '=>  create_serialize_data(filter_string($pullquote[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_pq[$x],
                               'bodyType' => 'pullquote' );
               $this->db->insert('bodypost', $array_data2); 
           }
        }
        
        #quote
        $quote = $this->input->post('quote[]');
        $position_q = $this->input->post('position_q[]');
        for($x=0;$x<count($quote);$x++){
           if(!empty($quote[$x])){
               $array_data3=array('content '=>  create_serialize_data(filter_string($quote[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_q[$x],
                               'bodyType' => 'quote' );
               $this->db->insert('bodypost', $array_data3); 
           }
        }
        
        #images
        $image = $this->input->post('image[]');
        $caption_img = $this->input->post('caption_img[]');
        $position_img = $this->input->post('position_img[]');
        for($x=0;$x<count($image);$x++){
           if(!empty($image[$x])){
               $array_data4=array('content '=> $image[$x],
                               'caption' => create_serialize_data(filter_string($caption_img[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_img[$x],
                               'bodyType' => 'images' );
               $this->db->insert('bodypost', $array_data4); 
           }
        }
        
        /* end initial bodypost */
        
        return ($this->db->affected_rows()==1)? true : false;
    }
        
    
    public function update($id){        
        $title        = filter_string($this->input->post("title_name",true));
        $shortdesc   = filter_string($this->input->post("shortdesc",true));
        $mainheading = filter_string($this->input->post("mainheading",true));
        $subheading  = filter_string($this->input->post("subheading",true));
        $module     = filter_string($this->input->post("entrytype",true));
        $slug       = filter_string($this->input->post("slug",true));        
        $expirationdate   = $this->input->post("expirationdate",true);
        $timepicker2   = filter_string($this->input->post("timepicker2",true));
        $enabled      = filter_string($this->input->post("enabled",true));  
        
        $oldp = $this->get_data_byId($id);
        $oldpb = $this->get_postbody($id);        
       
        $array_data  = array('postTitle' => create_serialize_data($title,$this->lang,$oldp->postTitle,$this->current_lang),
                         'postDescription'=> create_serialize_data($shortdesc,$this->lang,$oldp->postDescription,$this->current_lang),
                         'postHeading'=> create_serialize_data($mainheading,$this->lang,$oldp->postHeading,$this->current_lang),
                         'postSubheading'=> create_serialize_data($subheading,$this->lang,$oldp->postSubheading,$this->current_lang),
                         'dateExpiration'=>convert_format_totimestamp($expirationdate,$timepicker2),
                         'postModule' => $module,
                         'postSlug' => create_serialize_data($slug,$this->lang,$oldp->postSlug,$this->current_lang),
                         'publish' => ($enabled=='on')? 1 : 0,
                         'userID'=>$this->sessionID);                    
        $this->db->where('postID', $oldp->postID);
        $this->db->update('post', $array_data); 
        
         /* update bodypost values  */
        
        foreach($oldpb as $row=>$val):
            $heading = $this->input->post('heading[]');
            for($i=0;$i<count($heading);$i++){
               if(!empty($heading[$i])){
                   $array_data1=array('content '=>  create_serialize_data(filter_string($heading[$i]),$this->lang,$oldpb->content,$this->current_lang),                                 
                                   'bodyType' => 'heading' );
                   $this->db->where('postID', $va['postID']);
                   $this->db->update('postbody', $array_data1); 
               }
            } 
        endforeach;
        $heading = $this->input->post('heading[]');
        for($i=0;$i<count($heading);$i++){
           if(!empty($heading[$i])){
               $array_data1=array('content '=>  create_serialize_data(filter_string($heading[$i]),$this->lang,$oldpb->content,$this->current_lang),
                               'postID' => $postID,
                               'bodyType' => 'heading' );
               $this->db->insert('bodypost', $array_data1); 
           }  
        }
        
        #thetext
        $thetext = $this->input->post('thetext[]');
        $position_text = $this->input->post('position_text[]');
        for($x=0;$x<count($thetext);$x++){
           if(!empty($thetext[$x])){
               $array_data1=array('content '=>  create_serialize_data(filter_string($thetext[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_text[$x],
                               'bodyType' => 'text' );
               $this->db->insert('bodypost', $array_data1); 
           }
        }
        
        #pullquote
        $pullquote = $this->input->post('pullquote[]');
        $position_pq = $this->input->post('position_pq[]');
        for($x=0;$x<count($pullquote);$x++){
           if(!empty($pullquote[$x])){
               $array_data2=array('content '=>  create_serialize_data(filter_string($pullquote[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_pq[$x],
                               'bodyType' => 'pullquote' );
               $this->db->insert('bodypost', $array_data2); 
           }
        }
        
        #quote
        $quote = $this->input->post('quote[]');
        $position_q = $this->input->post('position_q[]');
        for($x=0;$x<count($quote);$x++){
           if(!empty($quote[$x])){
               $array_data3=array('content '=>  create_serialize_data(filter_string($quote[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_q[$x],
                               'bodyType' => 'quote' );
               $this->db->insert('bodypost', $array_data3); 
           }
        }
        
        #images
        $image = $this->input->post('image[]');
        $caption_img = $this->input->post('caption_img[]');
        $position_img = $this->input->post('position_img[]');
        for($x=0;$x<count($image);$x++){
           if(!empty($image[$x])){
               $array_data4=array('content '=> $image[$x],
                               'caption' => create_serialize_data(filter_string($caption_img[$x]), $this->lang),
                               'postID' => $postID,
                               'position' => $position_img[$x],
                               'bodyType' => 'images' );
               $this->db->insert('bodypost', $array_data4); 
           }
        }
        
        /* end initial bodypost */  
                     
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function insert_onepages($filename){
        $title         = filter_string($this->input->post("title_name",true));
        $shortdesc    = $this->input->post("shortdesc",true); 
        $position_img  = filter_string($this->input->post("position_img",true));                
        $oldpost      = $this->check_one_bysessionID();
        if(empty($oldpost)){
              $array_data  = array('postTitle' => create_serialize_data($title,$this->lang),
                         'postDescription'=> create_serialize_data($shortdesc,$this->lang),                      
                         'dateEntry'=> $this->date->format('U = Y-m-d H:i:s'),  
                         'dateExpiration'=>$this->date->format('U = Y-m-d H:i:s'),  
                         'postModule' => 'articles',
                         'postImages' => $filename,                         
                         'publish' => 1,
                         'postAlign' => $position_img,
                         'userID'=>$this->sessionID);            
               $this->db->insert('post', $array_data);               
        }else{  
            if(empty($filename)){
                $filepic = $oldpost->postImages;
            }else{
                $filepic = $filename;
                $s3_img = unserialize($oldpost->postImages);
                $thumb = $s3_img['raw_name'].'_thumb'.$s3_img['file_ext'];
                if ($this->AWS->checkFiles($this->bucket_name,$thumb)) 
                    $this->AWS->removeFile($this->bucket_name,$thumb); // removing thumbnail images
                if ($this->AWS->checkFiles($this->bucket_name,$s3_img['file_name']))
                    $this->AWS->removeFile($this->bucket_name,$s3_img['file_name']); // removing big images                                            
            }
            $array_data1  = array('postTitle' => create_serialize_data($title,$this->lang,$oldpost->postTitle,$this->current_lang),
                                'postDescription'=> create_serialize_data($shortdesc,$this->lang,$oldpost->postDescription,$this->current_lang),
                                'postImages' => $filepic,                                                  
                                'postAlign' => $position_img);   
             $this->db->where('userID', $this->sessionID);
             $this->db->update('post', $array_data1);             
        }        
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function insert_page($module){
        $title          = filter_string($this->input->post("postTitle",true));
        $description    = $this->input->post("postDescription",true);        
        $array_data  = array('postTitle' => create_serialize_data($title,$this->lang),
                         'postDescription'=> create_serialize_data($description,$this->lang),                      
                         'dateEntry'=> $this->date->format('U = Y-m-d H:i:s'),  
                         'dateExpiration'=>$this->date->format('U = Y-m-d H:i:s'),  
                         'postModule' => $module,                                                  
                         'publish' => 1,                         
                         'userID'=>$this->sessionID);            
        $this->db->insert('post', $array_data); 
        return ($this->db->affected_rows()!=1)? false : true;  
    }
    
    public function update_page($module,$old){        
        $title          = filter_string($this->input->post("postTitle",true));
        $description    = $this->input->post("postDescription",true);
        $array_data  = array('postTitle' => create_serialize_data($title,$this->lang,$oldpost["postTitle"],$this->current_lang),
                             'postDescription'=> create_serialize_data($description,$this->lang,$oldpost["postDescription"],$this->current_lang),                                               
                             'postModule' => $module,                                                                                                    
                             'userID'=>$this->sessionID);            
        $this->db->insert('post', $array_data); 
        return ($this->db->affected_rows()!=1)? false : true;  
    }
    
    public function delete_data($id){               
        $this->db->where('postID', $id);
        $this->db->update('post',array('act_delete'=>1));
        return ($this->db->affected_rows()!=1)? false : true;
    }
    
    public function get_pages_by_module($module){
        $result = $this->db->get_where($this->table,array('userID'=>$this->sessionID,'postModule'=>$module));        
        return $result->row();
    }
    
    public function get_frontend_pages($module,$username){
        $result = $this->db->query("SELECT * FROM post AS p JOIN users AS u ON p.userID=u.userID WHERE p.postModule='".$module."' AND u.userName='".$username."'");                 
        return $result->row();
    }
    
     public function get_frontend_images($module,$username){        
        $result = $this->db->query("SELECT * FROM images AS i JOIN users AS u ON i.userID=u.userID WHERE i.typeassets='".$module."' AND u.userName='".$username."'");                 
        return $result->result_array();
    }
    
}
