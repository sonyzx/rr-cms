<?php

 /**
* Function create_serialize_data
* description : set multiple language
* @param String $data new data will be store
  * @param String $language old language
  * @param String $data_comparation Old data
  * @param String new language
* @return String serialize data 
*/
 
 function create_serialize_data($data,$language,$data_comparation='',$newlang=''){
     if ($data_comparation !=''){
         $dp = unserialize($data_comparation);
         $dp[$newlang] = $data;
     }else{
         foreach($language as $k=>$v):
             $dp[$k] = $data;
         endforeach;         
     }
     $data = serialize($dp); 
     return $data;
 }
 
 /**
* Function show_data_serialize
* description : publish data by language
* @param array $data serialize data
* @param String $language the language will be publish
* @return String data
*/
 
 function show_data_serialize($data='',$publiclanguage='en'){
     $row = (is_array($data)) ? $data : unserialize($data);
     $my_lang = $publiclanguage;
     if(!isset($row[$my_lang]))
         return $row['en'];
     return $row[$my_lang];
 }
 
 
  /**
     * Function loadMessage
     * Description Using to notification 
     * @param int $msgType 1 : success , 2 : error , 3 : warning, 4 : info
     * @param string $module_name module where your publish
     * @param array $data array data value
     */
    
    function loadMessage($msgType,$text_message){
        switch ($msgType) {
            case 1 :  $msgType = 'alert-success'; 
                      $msgTitle = 'Success!';
                      $msgIcon = 'fa-check';
                break;
            case 2 :  $msgType = 'alert-danger';                    
                      $msgTitle = 'Error!';  
                      $msgIcon = 'fa-times-circle';
                break;
            case 3 : $msgType = 'alert-warning';                    
                     $msgTitle = 'Warning!';
                     $msgIcon = 'fa-times';
                break;
            case 4 : $msgType = 'alert-info';                    
                     $msgTitle = 'Info!';
                     $msgIcon = 'fa-info-circle';
                break;           
        } 
        return ' <div class="alert '.$msgType.' alert-block fade in alert-dismissable">                    
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><div style="float:left;margin-right:10px;"><i class="fa '.$msgIcon.' icon"></i></div>  <strong>'.$msgTitle.'</strong></p>
                    <p>'.$text_message.'</p>
              </div>';        
    }
          
    /**
     * Function filter_images     
     * Description 
     * @param array $files file images
     * @return array result 
     */
    
    function filter_images($files){
            $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "JPEG", "GIF", "PNG");
            $ext = explode(".", $files["name"]);
            $extension = end($ext);
            $return = false;
            if($files["size"] > 13000000) {
                $return = false;
            } else {                                   
                if ((($files["type"] == "image/gif") || ($files["type"] == "image/jpeg") || ($files["type"] == "image/png") || ($files["type"] == "image/pjpeg")) && in_array($extension, $allowedExts)) {
                   $return = true;
                }else{
                    $return = false;
                }
            }    
            return $return;
    }
    
    /**
     * Function convert_date     
     * Description convert from timestamp to date format Y-m-d
     * @param integer $timestamp      
     * @return array date, time
     */
    
    function convert_date($timestamp){
        $date = new DateTime();
        date_timestamp_set($date, $timestamp);
        $list['day'] =  date_format($date, 'd');
        $list['month'] =  date_format($date, 'M');
        $list['year'] =  date_format($date, 'Y');
        $list['date'] =  date_format($date, 'm/d/Y');        
        $list['time'] =  date_format($date, 'H:i');        
        return $list;
    }
    
     /**
     * Function convert_date     
     * Description convert from timestamp to date format Y-m-d
     * @param integer $timestamp      
     * @return date 
     */
    
    function convert_format_totimestamp($date,$time=''){        
        $list = explode('/', $date); 
        $year   = $list[2];  $month= $list[0];  $day= $list[1];                
        $val_time = ($time!='')? str_replace(array("AM","PM"),"", $time) : '';        
        $the_date = $year.'-'.$month.'-'.$day.' '.$val_time;                   
        $result = new DateTime($the_date);       
        return $result->format("U");
    }
    
     /**
     * Function filter_string     
     * Description security xss for filter string
     * @param string $string      
     * @return string $string clean data
     */
    
    function filter_string($string){
        $CI = & get_instance();   
        return $CI->security->sanitize_filename($string);
    }
   
     /**
     * Function encode_url    
     * Description encrypt code on uri segment
     * @param string $string      
      * @param string $key public key
     * @return string $string string has encrypted
     */
    
   function encode_url($string, $key="", $url_safe=TRUE)
   {
        if($key==null || $key=="")
        {
            $key="tyz_mydefaulturlencryption";
        }
        $CI =& get_instance();
        $ret = $CI->encrypt->encode($string, $key);

        if ($url_safe)
        {
            $ret = strtr(
                    $ret,
                    array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    )
                );
        }

        return $ret;
    }
    
    
     /**
     * Function decode_url    
     * Description decrypt code on uri segment
     * @param string $string      
      * @param string $key public key
     * @return string $string string has dencrypted
     */
    
    function decode_url($string, $key="")
    {
        if($key==null || $key=="")
       {
           $key="tyz_mydefaulturlencryption";
       }
       $CI =& get_instance();
       $string = strtr(
                $string,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
        );
        return $CI->encrypt->decode($string, $key);
    }
   
    
    /*  */
    function currentUrl(){
        $lurl = base_url().substr(uri_string(),1);
        return $url;
    }
    /* DINAMIC INPUT */
    
   /**
    * Function view_heading
    * Description display dinamic input heading from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */ 
    
   function view_heading($hidden=true,$value=''){
       $hid = ($hidden)? "hide" : "";
       $tpl = '<div class="form-group '.$hid.'" id="opt-heading">    
                    <div class="portlet portlet-default">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Heading</h4>
                                    </div>
                                    <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>                                            
                                            <a href="#" class="removeheading"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet" class="panel-collapse collapse in">
                                        <div class="portlet-body">
                                            <div class="form-group">                                                     
                                                <textarea name="heading[]" class="form-control redactorwysg">'.$value.'</textarea>   
                                            </div>
                                        </div>
                                    </div>
                    </div>
             </div>';
       return $tpl;
    }
    
    /**
    * Function view_text
    * Description display dinamic input text from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */ 
    
    function view_text($hidden=true,$value=array('content'=>'','position'=>'')){       
       $hid = ($hidden)? "hide" : "";
       $content = isset($value['content']) ? $value['content'] : '';
       $left = (isset($value['position'])=="left") ? 'checked="checked"' : '';            
       $center = (isset($value['position'])=="center") ? 'checked="checked"' : '';
       $right = (isset($value['position'])=="right") ? 'checked="checked"' : '';
       $tpl = '<div class="form-group '.$hid.'" id="opt-thetext">                                                   
                             <div class="portlet portlet-purple">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Text</h4>
                                        </div>
                                        <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#redPortlet1"><i class="fa fa-chevron-down"></i></a>
                                            <span class="divider"></span>
                                            <a href="#" class="removethetext"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet1" class="panel-collapse collapse in">
                                        <div class="portlet-body">  
                                            <div class="form-group">
                                                  <textarea class="form-control" id="thetext" name="thetext[]" >'.$content.'</textarea>
                                            </div>
                                            <div class="form-group">
                                                  <label>Position</label><br>
                                                  <input type="radio" name="position_text[]" value="left" '.$left.'> <i class="glyphicon glyphicon-align-left" title="Left"></i>&nbsp;
                                                  <input type="radio" name="position_text[]" value="center" '.$center.'> <i class="glyphicon glyphicon-align-center" title="Center"></i>&nbsp;                              
                                                  <input type="radio" name="position_text[]" value="right" '.$right.'> <i class="glyphicon glyphicon-align-right" title="Right"></i>				  
                                             </div>
                                        </div>
                                    </div>
                            </div>
                    </div> ';
       return $tpl;
    }   
    
    /**
    * Function view_pullquote
    * Description display dinamic input pull quote from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */  
    
   function view_pullquote($hidden=true,$value=array('content'=>'','position'=>'')){ 
       $hid = ($hidden)? "hide" : "";
       $content = isset($value['content']) ? $value['content'] : '';
       $left = (isset($value['position'])=="left") ? 'checked="checked"' : '';            
       $center = (isset($value['position'])=="center") ? 'checked="checked"' : '';
       $right = (isset($value['position'])=="right") ? 'checked="checked"' : '';
       $tpl = '<div class="form-group '.$hid.'"" id="opt-pullquote">
                        <div class="form-group">                                                       
                            <div class="portlet portlet-purple">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Pull Quote</h4>
                                        </div>
                                        <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#redPortlet2"><i class="fa fa-chevron-down"></i></a>
                                            <span class="divider"></span>
                                            <a href="#" class="removepullquote"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet2" class="panel-collapse collapse in">
                                        <div class="portlet-body">                                            
                                            <div class="form-group">  
                                                <input class="form-control" type="text" name="pullquote[]" value="'.$content.'" /> 
                                            </div>
                                            <div class="form-group">  
                                                <label>Position</label><br>
                                                  <input type="radio" name="position_pq[]" value="left" '.$left.'> <i class="glyphicon glyphicon-align-left" title="Left"></i>&nbsp;
                                                  <input type="radio" name="position_pq[]" value="center" '.$center.'> <i class="glyphicon glyphicon-align-center" title="Center"></i>&nbsp;                              
                                                  <input type="radio" name="position_pq[]" value="right" '.$right.'> <i class="glyphicon glyphicon-align-right" title="Right"></i>				  
                                            </div>
                                        </div>
                                    </div>
                            </div>                            
                        </div>
                    </div>';
       return $tpl;
   }
   
     /**
    * Function view_images
    * Description display dinamic input images from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */  
   
   function view_images($hidden=true,$value=array('content'=>'','position'=>'','caption'=>'')){ 
       $hid = ($hidden)? "hide" : "";
       $content   = isset($value['content']) ? $value['content'] : '';
       $icaption  =  isset($value['caption']) ? $value['caption'] : '';
       $left = (isset($value['position'])=="left") ? 'checked="checked"' : '';            
       $center = (isset($value['position'])=="center") ? 'checked="checked"' : '';
       $right = (isset($value['position'])=="right") ? 'checked="checked"' : '';
       $full = (isset($value['position'])=="full") ? 'checked="checked"' : '';
       $tpl = '<div class="form-group '.$hid.'"" id="opt-image">
                            <div class="portlet portlet-purple">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Gallery</h4>
                                        </div>
                                        <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#redPortlet3"><i class="fa fa-chevron-down"></i></a>
                                            <span class="divider"></span>
                                            <a href="#" class="removeimage"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet3" class="panel-collapse collapse in">
                                        <div class="portlet-body">                                            
                                            <div class="form-group">  
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#uploadfile">+ Add an asset</button>
                                                <input class="form-control" type="hidden" name="image[]" value="'.$content.'" /> <br />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="caption_img[]" value="'.$icaption.'" >
                                            </div>
                                            <div class="form-group">  
                                                <label>Position</label><br>
                                                  <input type="radio" name="position_img[]" value="left" '.$left.'> <i class="glyphicon glyphicon-align-left" title="Left"></i>&nbsp;
                                                  <input type="radio" name="position_img[]" value="center" '.$center.'> <i class="glyphicon glyphicon-align-center" title="Center"></i>&nbsp;                              
                                                  <input type="radio" name="position_img[]" value="right" '.$right.'> <i class="glyphicon glyphicon-align-right" title="Right"></i>				  
                                                  <input type="radio" name="position_img[]" value="full" '.$full.'> <i class="glyphicon glyphicon-align-justify" title="Full"></i>                              
                                            </div>
                                        </div>
                                    </div>
                            </div>
                </div>';
       echo $tpl;
   }
   
    /**
    * Function view_quote
    * Description display dinamic input qoute from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */
   
   function view_quote($hidden=true,$value=array('content'=>'','position'=>'')){
       $hid = ($hidden)? "hide" : "";
       $content   = isset($value['content']) ? $value['content'] : '';             
       $center = (isset($value['position'])=="center") ? 'checked="checked"' : '';      
       $full = (isset($value['position'])=="full") ? 'checked="checked"' : '';
       $tpl = '<div class="form-group '.$hid.'"" id="opt-quote">                        
                        <div class="portlet portlet-purple">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Quote</h4>
                                        </div>
                                        <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#redPortlet4"><i class="fa fa-chevron-down"></i></a>
                                            <span class="divider"></span>
                                            <a href="#" class="removequote"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet4" class="panel-collapse collapse in">
                                        <div class="portlet-body">                                            
                                            <div class="form-group">                                                 
                                                <input class="form-control" type="text" name="quote[]" value="'.$content.'"  /> 
                                            </div>
                                            <div class="form-group">  
                                                <label>Position</label><br>                                                  
                                                  <input type="radio" name="position_q[]" value="center" '.$center.'> <i class="glyphicon glyphicon-align-center" title="Center"></i>&nbsp;                                                                                
                                                  <input type="radio" name="position_q[]" value="full" '.$full.' > <i class="glyphicon glyphicon-align-justify" title="Full"></i>                              
                                            </div>
                                        </div>
                                    </div>
                            </div>                        
                    </div>';
       return $tpl;
   }
   
    /**
    * Function view_urlImages
    * Description display dinamic input url images from entries
    * @param boolean $hidden set value true when hide this element
    * @param array $value The value from database
    * @return string element data
    */ 
    
   function view_urlImages($hidden=true,$value=''){
       $hid = ($hidden)? "hide" : "";
       $tpl = '<div class="form-group '.$hid.'" id="opt-heading">    
                    <div class="portlet portlet-default">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>Url Photo</h4>
                                        </div>
                                        <div class="portlet-widgets">                                   
                                            <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                            <span class="divider"></span>                                          
                                            <a href="#" class="removeheading"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="redPortlet" class="panel-collapse collapse in">
                                        <div class="portlet-body">
                                            <div class="row">';
                                            if(!empty($value)){
                                              $tpl .='<div class="col-sm-2"><img class="thumb-images rooms_thumb" src="'.$value.'" ></div>';
                                            }  
                                              $tpl.= '<div class="col-sm-10">
                                                    <input class="form-control" type="url" name="urlimages[]" value="'.$value.'" />
                                                </div>
                                            </div>                                               
                                        </div>
                                    </div>
                    </div>
             </div>';
       return $tpl;
    } 
   
