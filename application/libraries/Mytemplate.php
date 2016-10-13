<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Mytemplate
 *
 * @author wahyu widodo
 */

class Mytemplate {
    
    var $template_data = array();
    var $data;
    var $bucketname;
    var $directoryuser;
    
    public function __construct() {
        $this->CI = & get_instance();     
        $this->CI->lang->load('myform', $this->currentLang());
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->CI->session->userdata("userName");
    }
    
        
    public function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }
    
    /**
     * Function loadTemplate
     * Description Using load themes frontend
     * @param int $mode 1 to frontend , 2 to backend
     * @param string $module_name module where your publish
     * @param array $data array data value
     */
    
    public function loadTemplate($mode=1,$view = '' , $view_data = array(), $return = FALSE){   
        $this->cekAuth();
        $publish_view = ($mode==1)? '/' : 'cms/';                    
        $this->set('contents', $this->CI->load->view($publish_view.$view, $view_data, TRUE));	
        $this->CI->load->model('Users_model');
        $dataprofile = $this->CI->Users_model->get_data_byId($this->mySessionID());
        if(empty($dataprofile->profile_pic)){
            $pic = '../assets/img/no-profile.gif';
        }else{
            $s3_img = unserialize($dataprofile->profile_pic);
            $thumb = $s3_img['raw_name'].'_thumb'.$s3_img['file_ext'];
            $pic = 'https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumb;
        }        
        $this->set('username',$dataprofile->userName);
        $this->set('avatar',$pic);
        return $this->CI->load->view($publish_view.'adminpages', $this->template_data, $return);
    }
    
     /**
     * Function cekAuth
     * Description check authentication pages     
     */
    
    public function cekAuth(){
        $name = $this->CI->session->userdata('userName');
        if(trim($name) == "" ){            
            $msg = ' <div class="alert alert-danger alert-block fade in alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p><strong>You do not have access this pages.</strong></p>
                            <p></p>
                      </div>';
            header('Content-Type: application/json');
            echo json_encode($msg);             
            redirect(site_url("cms/login"));
            exit;
        }
    }

     /**
     * Function mySessionID
     * Description check authentication pages     
     */
    
    public function mySessionID(){
        $userID = $this->CI->session->userdata('userID');
        return empty($userID)? 1 : $userID;
    }
    
    /**
     * Function ComboSource
     * @param string $name The name of combobox component
     * @param string $pilih Option selected condition
     * @return string $tmp the result combobox component
     */

    public function ComboSource($name,$pilih=''){
       $data = $this->CI->themes->get_array_db($name); 
       $tmp='<select name="'.$name.'" class="form-control selecter" >';
       $tmp.='<option selected="selected" value="">All Source</option>';       
       foreach($data as $row=>$key):       
           $selected=($pilih==$key->sourceID)? 'selected="selected"' : '';
           $tmp.='<option value="'.$key->sourceID.'" '.$selected.' >'.$key->sourceName.'</option>';
       endforeach;                      
       $tmp.='</select>';
       return $tmp;    
    }

    /**
     * Function ComboCategories
     * @param string $name The name of combobox component
     * @param string $pilih Option selected condition
     * @return string $tmp the result combobox component
     */

    public function ComboCategories($name,$pilih=''){
       $data = $this->CI->themes->get_array_db($name); 
       $tmp='<select name="'.$name.'" class="form-control selecter" >';
       $tmp.='<option selected="selected" value="">All Source</option>';       
       foreach($data as $row=>$key):       
           $selected=($pilih==$key->categoryID)? 'selected="selected"' : '';
           $tmp.='<option value="'.$key->categoryID.'" '.$selected.' >'.$key->categoryName.'</option>';
       endforeach;                      
       $tmp.='</select>';
       return $tmp;    
    }
    
     /**
     * Function arrayLanguage
     * Description store multiple language
     * @return array multiple language
     */
    
    public function arrayLanguage(){                
        return array("en"=>"English","es"=>"Espanol","zh"=>"Chinese");
    }
    
     /**
     * Function changeLanguage
     * Description combobox component for switch active language
     * @return array multiple language
     */
    
    public function changeLanguage(){        
        $activelang = $this->CI->session->userdata('lang');
        $tmp='<select name="lang" id="lang">';        
        foreach($this->arrayLanguage() as $row=>$key):       
           $selected=($activelang==$row)? 'selected="selected"' : '';
           $tmp.='<option value="'.$row.'" '.$selected.' >'.$key.'</option>';
        endforeach;                      
        $tmp.='</select>';
        return $tmp;                             
    }
    
     /**
     * Function currentLang
     * Description Detect active current language
     * @return string Code language     
     */
    
    public function currentLang(){
        $codelang = $this->CI->session->userdata("lang");
        return empty($codelang)? "en" : $codelang;
    }
    
     /**
     * Function upload_file
     * Description upload files on local server
     * @return string Code language     
     */
    
    public function upload_file($path,$file_name)
    {       
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|PNG|JPG|JPEG|PNG';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['encrypt_name'] = TRUE;
        $this->CI->load->library('upload', $config);     
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'], 0755, TRUE);
        }
        if ($this->CI->upload->do_upload($file_name))        
        {
            $upload_data = $this->CI->upload->data();              
            $data['upload_data'] = $upload_data; 
            $source_img = $upload_data['full_path'];    
            $new_img = $upload_data['file_path'] . $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];  
            $data['source_image'] = $new_img;
            $this->create_thumb_image($upload_data, $source_img, $new_img, 250, 200);  
            $this->CI->image_lib->clear();
            $upload_data['thumb']= $new_img;                    
            return $upload_data;          
        }else{                       
            return $this->CI->upload->display_errors();
        }
    }
        
    /**
     * Function create_thumb_image 
     * Description Create thumbnail for gallery images
     * @param array $upload_data 
     * @param string $source_img Description
     * @param string $new_img
     * @param int $width
     * @param int $height
     * @return boolean result true if process done
     */
    
    public function create_thumb_image($upload_data, $source_img, $new_img, $width, $height)
    {
        $config_['image_library'] = 'gd2';
        $config_['source_image'] = $source_img;
        $config_['create_thumb'] = FALSE;
        $config_['maintain_ratio'] = FALSE;
        $config_['new_image'] = $new_img;
        $config_['quality'] = '100%';
        $config_['width'] = $width;
        $config_['height'] = $height;            
        $dim = (intval($upload_data['image_width']) / intval($upload_data['image_height'])) - ($config_['width'] / $config_['height'] );
        $config_['master_dim'] = ($dim > 0)? 'height' : 'width';
        $this->CI->load->library('image_lib',$config_);
        $this->CI->image_lib->initialize($config_);
        
        if (!$this->CI->image_lib->resize()){
            return $this->CI->image_lib->display_errors('<p>','</p>');
        }else{            
            return TRUE;
        }
        
    } 
    
    /**
    * Function crop_image
     * Description Create cropping image
     * @param array $filename name file from input type
     * @return boolean result true when cropping process done
     */
    
    public function crop_image($filename){
        if($filename){
            $this->CI->input->post('x');
            $this->CI->input->post('y');
            $this->CI->input->post('w');
            $this->CI->input->post('h');
            $source = $filename;
            
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_img;
            $config['new_image'] = $source_img;
            $config['quality'] = '100%';
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['x_axis'] = $x_axis;
            $config['y_axis'] = $y_axis;
            
            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($config);
            
            if(! $this->CI->image_lib->crop()){
                return $this->CI->image_lib->display_errors();
            }else{
                return TRUE;
            }
        }
    }
            
    
    
}
