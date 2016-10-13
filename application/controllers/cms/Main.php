<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    
    public $bucketname;
    public $directoryuser;

    public function __construct() {
        parent::__construct(); 
        
        $this->load->library("myfly");       
        $this->AWS = new Myfly();  
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");   
        $this->load->model("Blocks_model");
        $this->load->model("Globals_model");
        $this->load->model("Post_model");
        $this->sessionID = $this->mytemplate->mySessionID();
        $this->check = $this->Globals_model->get_data_byId($this->sessionID);    
    }

    public function index()
    {       
         $data['module'] = $this->lang->line('dashboard');         
         /* begin : show block */
         $array_blocks = $this->Blocks_model->get_array_db();
         $myblock = $this->Blocks_model->get_myblock($this->sessionID); 
         $datablock='<ul id="userSettings" class="nav nav-pills nav-stacked">';
         $i=0;         
         foreach($myblock as $row=>$key):   
              $blockType = show_data_serialize($key['blockType'],$this->mytemplate->currentLang());
              $blockTypefortab = show_data_serialize($key['blockType'],'en');
              $tabid = '#'.strtolower(str_replace(" ","",$blockTypefortab));
              $is_active = ($i==0)? 'class="active"' : '';                
              if($key['blockID']==4){ 
                    $datablock .=  '<li><a href="'.site_url('cms/hotel').'">'.$blockType.'</a></li>';              
              }elseif($key['blockID']==3){
                    $datablock .=  '<li><a href="'.site_url('cms/rooms').'">'.$blockType.'</a></li>';
              }
              else{
                    $datablock .=  '<li '.$is_active.'><a href="'.$tabid.'" data-toggle="tab">'.$blockType.'</a></li>';  
              }
              $i++;
         endforeach; 
         $datablock.='<li>'.anchor(site_url('cms/pages/section/about'),'About').'</li>';        
         $datablock.='<li>'.anchor(site_url('cms/pages/services'),'Services').'</li>';
         $datablock.='<li>'.anchor(site_url('cms/pages/section/facilities'),'Facilities').'</li>';
         $datablock.='<li>'.anchor(site_url('cms/pages/section/location'),'Location').'</li>';
         $datablock.='</ul><br />';
         $data['myblock'] = $datablock;
         $data['checkblock'] = $myblock;
         /* end : show block */
         
         /* begin : show menu */
         $menu = '<ul class="dropdown-menu" role="menu">';        
         $classadd=array("add-article","add-imagegallery","add-roomlist","add-hotelammenities");
         foreach($array_blocks as $row=>$key):                                     
            $menu.='<li><a href="#" onclick="addblock('."'".encode_url($key['blockID'])."'".')">'.show_data_serialize($key['blockType'],$this->mytemplate->currentLang()).'</a></li>';            
         endforeach;                    
         $menu .= '</ul>';
         $data['menu']=$menu;
         /* end : show menu */
         
         /* begin : show global */
         $data['email'] = (empty($this->check->email)) ? '' :  $this->check->email;  
         $data['contactUs'] = (empty($this->check->contactUs)) ? '' :  show_data_serialize($this->check->contactUs,$this->mytemplate->currentLang());
         $data['metadata'] = (empty($this->check->metadata)) ? '' :  show_data_serialize($this->check->metadata,$this->mytemplate->currentLang());
         $data['titlesite'] = (empty($this->check->titlesite)) ? '' :  show_data_serialize($this->check->titlesite,$this->mytemplate->currentLang());         
         $data['introtext'] = (empty($this->check->introtext)) ? '' :  show_data_serialize($this->check->introtext,$this->mytemplate->currentLang());         
         $data['copyright'] = (empty($this->check->copyright)) ? '' :  $this->check->copyright;
         $data['latitude'] = (empty($this->check->latitude)) ? '' :  $this->check->latitude;
         $data['longitude'] = (empty($this->check->longitude)) ? '' :  $this->check->longitude;
         if (empty($this->check->logo)) {
            $data['logo'] = '';
         }else{
            $data_logo = @unserialize($this->check->logo);
            $img_logo = $data_logo['raw_name'].'_thumb'.$data_logo['file_ext']; 
            $data['logo'] = '<img id="previewlogo" class="img-responsive latest_thumb" src="https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$img_logo.'">'; 
         }  
         $data['themes'] = (empty($this->check->themes_color)) ? '' :  $this->check->themes_color;
         
         // Display postbody                  
        $postbody = empty($this->check)? '' : $this->Post_model->get_postbody($this->check->globalID);        
         if(!empty($postbody)){
            $tmp =''; 
            foreach($postbody as $row=>$key):
                if ($key['bodyType']=="introtext"){               
                    $tmp.= view_heading(false,show_data_serialize($key["content"],$this->mytemplate->currentLang()));
                }                
            endforeach;
            $data['content_postbody']= $tmp;
        }else{
            $data['content_postbody']='';
        }
         
         
         /* end : show global */
         
         /* begin : show article */
         $article = $this->Post_model->check_one_bysessionID();                  
         $data['title_post'] = empty($article->postTitle)? '' : show_data_serialize($article->postTitle,$this->mytemplate->currentLang()); 
         $data['content_post'] = empty($article->postDescription)? '' : show_data_serialize($article->postDescription,$this->mytemplate->currentLang());          
         if (empty($article->postImages)) {
            $data['picture'] = '';
         }else{
            $upload_data = unserialize($article->postImages);
            $img_article = $upload_data['raw_name'].'_thumb'.$upload_data['file_ext']; 
            $data['picture'] = '<img id="previewold" class="img-responsive latest_thumb" src="https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$img_article.'">'; 
         } 
         $data['aligment'] = empty($article->postAlign)? '' : $article->postAlign;
         /* end : show article */
         
         $this->mytemplate->loadTemplate(2,'dashboard/index',$data);      
    }
    
    public function language(){
        $var_lang = $this->input->post('lang',true);
        $this->session->set_userdata("lang",$var_lang);        
    }
    
    public function addblock($id){                  
         $return = $this->Blocks_model->pushdata(decode_url($id));
         $code =  ($return)? 1 : 2;
         $str = ($return)? "Add block successfully" : "Add block failed"; 
         $res = loadMessage($code,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);              
    }    
    
    public function removeblock($id){                
         $return = $this->Blocks_model->deleteblock(decode_url($id));
         $code =  ($return)? 1 : 2;
         $str = ($return)? "Delete block successfully" : "Delete block failed"; 
         $res = loadMessage($code,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);              
    }
    
    
    
        
   
                 
}
