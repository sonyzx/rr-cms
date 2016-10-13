<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $bucket_name;
    public $aws_url; 
    
    public function __construct() {
        parent::__construct();         
        $this->load->model("Blocks_model");       
        $this->load->model("Post_model");
        $this->load->model("Globals_model");
        $this->load->model("Users_model");
        $this->load->model("Assets_model");
        $this->load->model("Hotel_model");
        $this->load->model("Rooms_model");
        $this->load->model("Testimonial_model");    
        $this->bucket_name = 'roomsranger';
        $this->aws_url = "https://s3-us-west-1.amazonaws.com/".$this->bucket_name."/";
    }

    public function index(){        
        $this->mysite("admin");
    }
    
    public function mysite($username)
    {        
         $session_user = $this->Users_model->check_username($username);        
         if(!isset($session_user)) {
            redirect(site_url());
            exit;
         }
         
         /* SECTION ABOUT */
         $row_about = $this->Post_model->get_frontend_pages("about",$username);         
         $data['title_about'] = empty($row_about->postTitle)? '' : show_data_serialize($row_about->postTitle,$this->mytemplate->currentLang()); 
         $data['content_about'] = empty($row_about->postDescription)? '' : show_data_serialize($row_about->postDescription,$this->mytemplate->currentLang());
         $about_images =$this->Post_model->get_frontend_images("about",$username);                  
         if(isset($about_images)){
             $tmpAbout  = '<ol class="carousel-indicators">';
             for($a=0;$a<count($about_images);$a++){ 
                $active_css1 = ($a==1)? 'class="active"' : '';
                $tmpAbout .= '<li data-target="#aboutCarousel" data-slide-to="'.$a.'" '.$active_css1.'></li>';                                     
             }         
             $tmpAbout .= '</ol>';
             $tmpAbout .= '<div class="carousel-inner" role="listbox">';
             $b=0;
             foreach($about_images as $row):
                $img_about = @unserialize($row['imagesFile']);                
                $thumb_about = $img_about['raw_name'].'_thumb'.$img_about['file_ext'];             
                $urlImgAbout = $this->aws_url.$session_user->userName."/".$thumb_about;
                $b++;
                $active_css2 = ($b==1)? 'active' : '';
                $tmpAbout .=  '<div class="item '.$active_css2.'">
                                   <img class="img-responsive" src="'.$urlImgAbout.'" alt=""/>
                               </div>';
             endforeach;                                                     
             $tmpAbout .=  '</div>'; 
         }
         $data['images_about'] = $tmpAbout;
         /* END ABOUT  */
         
          /* begin : roomlist */ 
         $theRoomType = $this->Rooms_model->get_array_db_byuserID($session_user->userID);
         $listroom = '';
         if(empty($theRoomType)){
             $data['menu_roomlist'] = $listroom;
              $data['listphoto'] = '';
         }else{             
             $listroom.='<li><a href="#" data-filter="*" class="current">All Categories</a></li>';        
             foreach($theRoomType as $rdata):                 
                 $listroom.='<li><a href="#" data-filter=".room'.$rdata->roomtypeid.'"> '.$rdata->roomname.'</a></li>';
             endforeach;                          
             $data['menu_roomlist'] = $listroom;
             $listtypes_photo = $this->Rooms_model->get_types_photo(); 
             $listphoto = '';
             foreach($listtypes_photo as $rtype): 
                  $rowroom = $this->Rooms_model->get_data_byId($rtype->roomtypeid);   
                  $r_name  = isset($rowroom->roomname)? $rowroom->roomname : '';   
                  $r_desc  = isset($rowroom->short_description)? show_data_serialize($rowroom->short_description,$this->mytemplate->currentLang()) : '';                                                                        
                  $listphoto .= !empty($r_name)? '<div class="col-xs-6 col-sm-4 col-md-3 room-wrapper">
                                        <a class="room">
                                            <div class="img">
                                                <img class="img-responsive roomthumb" src="'.$rtype->url.'" alt=""/>
                                            </div>
                                            <div class="content">
                                                <h3>'.$r_name.'<br /></h3>
                                                <p>'.substr($r_desc,0,100).'...</p>                                            
                                            </div>
                                            <button class="btn btn-block">Check Availability</button>
                                        </a>
                                    </div>' : '';                                         
             endforeach;
             $data['listphoto'] = $listphoto;                          
         }
         /* end : roomlist */ 
         
         /* SECTION SERVICE */
         $data_service = $this->Post_model->get_frontend_images("services",$username);
         if(isset($data_service)){
            $tmpService = ' <ol class="carousel-indicators">';
            for($c=0;$c < count($tmpService);$c++){
                $active_css3 = ($c==1)? 'class="active"' : '';
                $tmpService .= '<li data-target="#servicesCarousel" data-slide-to="'.$c.'" '.$active_css3.'></li>';
            }
            $tmpService .= '</ol>';
            $tmpService .= '<div class="carousel-inner" role="listbox">';
            $ab=0;
            foreach($data_service as $row2){
                $ab++;
                $img_service = @unserialize($row2['imagesFile']);                
                $thumb_service = $img_service['raw_name'].'_thumb'.$img_service['file_ext'];             
                $urlImgService = $this->aws_url.$session_user->userName."/".$thumb_service;
                $active_css4 = ($ab==1)? "active" : "";
                $tmpService .=  '<div class="item '.$active_css4.'">
                                    <div class="col-sm-6">
                                        <img class="img-responsive" src="'.$urlImgService.'" alt=""/>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3>'.show_data_serialize($row2["imagesCaption"],$this->mytemplate->currentLang()).'</h3>
                                        <p>'.show_data_serialize($row2["imagesDescription"],$this->mytemplate->currentLang()).'</p>
                                    </div>
                                 </div>';                  
            }          
            $tmpService .= '</div>';                                                                               
         }
         $data['services_section'] = $tmpService; 
         /* END SECTION SERVICE */
         
         /* SECTION FACILITIES */
         $row_facilities = $this->Post_model->get_frontend_pages("facilities",$username);                   
         $data['content_facilities'] = empty($row_about->postDescription)? '' : show_data_serialize($row_about->postDescription,$this->mytemplate->currentLang());
         $data_facilities = $this->Post_model->get_frontend_images("facilities",$username);
         if (isset($data_facilities)){
            $tmpFacilities = '<ol class="carousel-indicators">';
            for($d=0; $d < count($data_facilities); $d++){                
                $active_css5 = ($d==1)? 'class="active"' : '';
                $tmpFacilities .= '<li data-target="#facilitiesCarousel" data-slide-to="'.$d.'" '.$active_css5.'></li>';                        
            }
            $tmpFacilities .= '</ol>';
            
            $tmpFacilities .= '<div class="carousel-inner" role="listbox">';
            $ac=0;
            foreach($data_facilities as $row3){
                $ac++;
                $img_facilites = @unserialize($row3['imagesFile']);                
                $thumb_facilities = $img_facilites['raw_name'].'_thumb'.$img_facilites['file_ext'];             
                $urlImgFacilities = $this->aws_url.$session_user->userName."/".$thumb_facilities;
                $active_css6 = ($ac==1)? "active" : "";
                $tmpFacilities .=  '<div class="item '.$active_css6.'">
                                        <img class="img-responsive" src="'.$urlImgFacilities.'" alt=""/>
                                    </div>';
            }    
           $tmpFacilities .= '</div>'; 
         }
         $data['facilities_section'] = $tmpFacilities;
         /* END SECTION FACILITIES */
         
         /* SECTION LOCATION */
         $row_location = $this->Post_model->get_frontend_pages("location",$username);                   
         $data['content_location'] = empty($row_about->postDescription)? '' : show_data_serialize($row_about->postDescription,$this->mytemplate->currentLang());
         $data_location = $this->Post_model->get_frontend_images("location",$username);
         if (isset($data_location)){
            $tmpLocation = '<ol class="carousel-indicators">';
            for($e=0; $e < count($data_location); $e++){                
                $active_css7 = ($e==1)? 'class="active"' : '';                
                $tmpLocation .= '<li data-target="#locationCarousel" data-slide-to="'.$e.'" '.$active_css7.'></li>';                        
            }
            $tmpLocation .= '</ol>';
            
            $tmpLocation .= '<div class="carousel-inner" role="listbox">';
            $ad=0;
            foreach($data_location as $row4){
                $ad++;
                $img_location = @unserialize($row4['imagesFile']);                
                $thumb_location = $img_location['raw_name'].'_thumb'.$img_location['file_ext'];             
                $urlImgLocation = $this->aws_url.$session_user->userName."/".$thumb_location;
                $active_css8 = ($ad==1)? "active" : "";
                $tmpLocation .=  '<div class="item '.$active_css8.'">
                                        <img class="img-responsive" src="'.$urlImgLocation.'" alt=""/>
                                  </div>';
            }    
           $tmpLocation .= '</div>'; 
         }
         $data['location_section'] = $tmpLocation;
         /* END SECTION LOCATION */
    
         /* begin : show global site */         
         $globalsite = $this->Globals_model->get_data_byId($session_user->userID);          
         $data['titlesite'] = empty($globalsite->titlesite)? '' : show_data_serialize($globalsite->titlesite,$this->mytemplate->currentLang());
         $data['introtext'] = empty($globalsite->introtext)? '' : show_data_serialize($globalsite->introtext,$this->mytemplate->currentLang());         
         $data['metadata'] = empty($globalsite->metadata)? '' : show_data_serialize($globalsite->metadata,$this->mytemplate->currentLang());
         $data['copyright'] = empty($globalsite->copyright)? '' : $globalsite->copyright;
         if (empty($globalsite->logo)) {
            $data['logoimg'] = site_url("assets/images/logo.png");
            $data['opaqueimg'] = site_url("assets/images/corihuasi_black.gif");
         }else{
            $data_logo = @unserialize($globalsite->logo);
            $thumb_logo = $data_logo['raw_name'].'_thumb'.$data_logo['file_ext'];             
            $data['logoimg'] = $this->aws_url.$session_user->userName."/".$thumb_logo;
            $data['opaqueimg'] = $this->aws_url.$session_user->userName."/".$thumb_logo;
         }                             
         $data['latitude'] = empty($globalsite->latitude)? '' : $globalsite->latitude;
         $data['longitude'] = empty($globalsite->longitude)? '' : $globalsite->longitude;
         /* end : show global site */        
         
         /* begin : show block */
         $myblock  = $this->Blocks_model->get_myblock($session_user->userID);  
         $datablock ='<ul id="menu" class="menu"><li><a href="#intro">'.$this->lang->line('home').'</a></li>';  
         if(isset($myblock)){
            foreach($myblock as $row=>$key):              
                 $tabid =  '#'.strtolower(str_replace(" ","",show_data_serialize($key['blockType'],'en')));                    
                 $datablock .=  '<li><a href="'.$tabid.'" data-toggle="tab">'.show_data_serialize($key['blockType'],$this->mytemplate->currentLang()).'</a></li>';                            
            endforeach;   
         }   
         $datablock.='<li><a href="#contact">'.$this->lang->line('contact').'</a></li></ul>';
         $data['mainmenu'] = $datablock;         
         /* end show block */
         
         /* begin : show article */
         $article = $this->Post_model->check_one_UserID($session_user->userID);         
         $data['title_post'] = empty($article->postTitle)? 'Title Article' : show_data_serialize($article->postTitle,$this->mytemplate->currentLang()); 
         $data['content_post'] = empty($article->postDescription)? '' : show_data_serialize($article->postDescription,$this->mytemplate->currentLang());
         $date = empty($article->dateEntry)? '' : convert_date($article->dateEntry);         
         $data['mEntry'] = empty($article->dateEntry)? '' : $date['month'];         
         $data['dEntry'] = empty($article->dateEntry)? '' : $date['day'];          
         $data['yEntry'] = empty($article->dateEntry)? '' : $date['year'];
         $position = empty($article->postAlign)? '' : $article->postAlign;
         $users = empty($article->userID)? '' : $this->Users_model->get_data_byId($article->userID);
         $data['username'] = $session_user->userName;
         if (empty($article->postImages)) { 
             $data['picture'] = '';          
         }else{ 
             $_imgArticle = @unserialize($article->postImages);
             $path_imgarticle = $_imgArticle['raw_name'].'_thumb'.$_imgArticle['file_ext'];
             $data['picture'] = '<img src="'.$this->aws_url.$session_user->userName.'/'.$path_imgarticle.'" class="img-responsive" style="max-width:350px;float:'.$position.';padding:10px;" /></div>';
         }                  
         /* end : show article */         
         
           /* begin : show testimonial */
         $testimoni = $this->Testimonial_model->get_testimony($session_user->userID);
         $tmp ='';         
         foreach($testimoni as $row):
              if (!empty($row["postImages"])) {                 
                 $_imgAvatar = @unserialize($row["postImages"]);
                 $path_imgavatar = $_imgAvatar['raw_name'].'_thumb'.$_imgAvatar['file_ext'];
                 $url_guest = $this->aws_url.$session_user->userName.'/'.$path_imgavatar;
              }else{
                 $url_guest =  '../../assets/images/no_image.jpg';
              }   
              $val_date = convert_date($row["dateEntry"]);
              $tmp .= '<div class="row testimonial">
                        <div class="col-xs-2 text-center">
                            <img class="img-responsive img-circle" src="'.$url_guest.'" alt=""/>
                            <span>'.$row["postHeading"].'</span>
                        </div>
                        <div class="col-xs-10">
                            <div class="stars">';
                            for($x=0;$x<$row["postSubheading"];$x++){
                                $tmp .=  '<span class="star"></span>';
                            } 
                                
               $tmp .=      '</div>
                            <h3>'.$row["postTitle"].'</h3>
                            <p>'.show_data_serialize($row["postDescription"],$this->mytemplate->currentLang()).'</p>
                            <span class="date">'.$val_date['date'].'</span>
                        </div>
                    </div>';
                
         endforeach;
         $data['testimonial']=$tmp;
                      
         /* end : show testimonial */         
         
         
         /* begin : show gallery */
          $gallery = $this->Assets_model->get_array_by_userID($session_user->userID);          
          if(empty($gallery)){
              $data['listgallery'] = "";
          }else{
            $img ='<div class="row" style="margin-bottom: 5px;">';  
            $i=0;
            foreach($gallery as $picture):
                $i++;                
                if (empty($picture['imagesFile'])){
                    $path_images = '../../assets/images/no_image.jpg';                      
                }else{
                    $data_imgFiles = @unserialize($picture['imagesFile']);
                    $path_images_thumb = $data_imgFiles['raw_name'].'_thumb'.$data_imgFiles['file_ext'];
                    $path_images_big   = $data_imgFiles['file_name'];
                }
                $path_images_t = $this->aws_url.$session_user->userName."/".$path_images_thumb;
                $path_images_o = $this->aws_url.$session_user->userName."/".$path_images_big;
                $title_img = show_data_serialize($picture['imagesCaption'],$this->mytemplate->currentLang());
                $desc_img  = show_data_serialize($picture['imagesDescription'],$this->mytemplate->currentLang());                
                $img .= '<a href="'.$path_images_o.'" title="'.$title_img.'" data-toggle="lightbox" class="col-sm-4" data-gallery="gallery"><img src="'.$path_images_t.'" class="img-responsive" alt="'.$title_img.'""/></a>';
                $img .= ($i%3==0)? '</div><div class="row" style="margin-bottom: 5px;">' : '';                                       
            endforeach; 
                $img .= '</div>';
            $data['listgallery'] = $img;
          }    
          
         /* end : show gallery */         
         
         /* begin : show contact us */ 
         $profile = $this->Users_model->get_data_byId($session_user->userID);  
         $data['soc_fb'] = empty($profile->soc_fb) ? '' : $profile->soc_fb;
         $data['soc_in'] = empty($profile->soc_in) ? '' : $profile->soc_in;
         $data['soc_plus'] = empty($profile->soc_plus) ? '' : $profile->soc_plus;
         $data['soc_twit'] = empty($profile->soc_twit) ? '' : $profile->soc_twit; 
         $data['about'] = empty($profile->about) ? '' : show_data_serialize($profile->about,$this->mytemplate->currentLang());
         $data['address'] = empty($profile->address) ? '' : $profile->address;
         $data['email'] = empty($profile->email) ? '' : $profile->email;
         $data['phonenumber'] = empty($profile->phonenumber) ? '' : $profile->phonenumber;
         $data['city'] = empty($profile->city) ? '' : $profile->city;
         $data['state'] = empty($profile->state) ? '' : $profile->state;
         $data['zip'] = empty($profile->zip) ? '' : $profile->zip;
         /* end : show contact us */ 
         
         /* begin : show hotel */ 
         $theHotels = $this->Hotel_model->get_array_db_byuserID($session_user->userID);         
         $hotels ='';
         if(empty($theHotels)){
             $data['listhotel'] = $hotels;
         }else{             
            foreach($theHotels as $row):   
                if (empty($row->feature_image)){
                    $path_featureimg = '../../assets/images/no_image.jpg';                      
                }else{
                    $data_imgF = @unserialize($row->feature_image);
                    $path_featureimg = $this->aws_url.$session_user->userName."/".$data_imgF['raw_name'].'_thumb'.$data_imgF['file_ext'];
                }
                $sourceimg = $path_featureimg;                                             
                $hotels.= '<div class="col-sm-4 col-md-4 top bottom team-member">
                            <div class="thumbnail">                               
                                <img src="'.$sourceimg.'" class="img-responsive">
                                 <div class="caption">                                    
                                    <h4>$ '.$row->deposit.'</h4>
                                    <p>Night</p>
                                </div>    
                            </div>
                            <div class="team-member">
                               <h3>'.$row->hotelname.'</h3>                                                                
                               <p>'.show_data_serialize($row->short_description,$this->mytemplate->currentLang()).'</p>
                            </div>
                        </div>';
            endforeach;
            $data['listhotel'] = $hotels;
         }         
         /* end : show hotel */  
         
         $ses_language = $this->session->userdata("lang");
         $data['flags'] = isset($ses_language)? $ses_language : "en";         
         $this->load->view('home',$data);
    }
    
    public function language($var_lang){    
        $this->session->unset_userdata("lang");
        $this->session->set_userdata("lang",$var_lang);        
        redirect($this->input->server('HTTP_REFERER'));
    }
    
    public function contactus(){        
        $this->form_validation->set_rules('yourname', 'Your name', 'required');
        $this->form_validation->set_rules('youremail', 'Your email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() == FALSE){   
            $str = validation_errors(); 
            $res = loadMessage(2,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;    
        }else{
          $yourname = filter_string($this->input->post('yourname',true));
          $email = $this->input->post('youremail',true);
          $subject = filter_string($this->input->post('subject',true));
          $message = filter_string($this->input->post('message',true));  
          $message .= '<hr>';
          $message .= 'From : '.$email.'<br />'; 
          $message .= 'Name : '.$yourname.'<br />';           
          $result = $this->myemail->send_email_smtp('wahyusoft@yahoo.com', $subject, '',$message);                         
          $str = $this->lang->line('save_success');          
          $res = loadMessage($result['error_code'],$result['error_msg']);  
          header('Content-Type: application/json');
          echo json_encode($res);
        }     
                            
    }
                 
}
