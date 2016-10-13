<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends CI_Controller {
    
    private $AWS;
    public $bucketname;
    public $directoryuser;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Hotel_model');
        $this->AWS = new AmazonS3();
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");
    }
    
    public function index()
    {                     
        $data['module'] = $this->lang->line('hotel');
        $this->mytemplate->loadTemplate(2,'hotels/index',$data);
    }
    
    
     public function filldata(){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'hotelname', 
                    1 => 'street',
                    2 => 'date_created'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Hotel_model->get_data($params);  
        $totalData = $this->Hotel_model->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){      
                $code = encode_url($row["hotelid"]);
                $val_date = convert_date($row["date_created"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $nestedData[] = $row["hotelname"];              
                $nestedData[] = $row["street"];              
                $nestedData[] = $row["userName"].", ".$val_date['date'].' '.$val_date['time'];                
                //add html for action
                $nestedData[] = '<a title="Update" href="'.site_url("cms/hotel/post/update")."/".$code.'")"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_hotel('."'".$code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
                $data[] = $nestedData;
        }
        
         $json_data = array(
                    "draw"         => intval( $requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                    "recordsTotal"   => intval( $totalData ),  // total number of records
                    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                    "data"          => $data   // total data array
                    );
        echo json_encode($json_data);  
    }
    
    
    public function post($mode,$id=''){                          
        $data['module'] = ($mode=="add") ? $this->lang->line('addhotel') : $this->lang->line('edithotel'); 
        $codeID = decode_url($id);
        $check = $this->Hotel_model->get_data_byId($codeID);   
        $data['action'] = $mode;
        $data['id'] = (empty($check->hotelid))? '' : encode_url($check->hotelid);
        $data['slug'] = (empty($check->slug)) ? '' :  $check->slug;
        $data['hotelname'] = (empty($check->hotelname)) ? '' :  $check->hotelname;
        $data['business_name'] = (empty($check->business_name)) ? '' :  $check->business_name;
        $data['business_number'] = (empty($check->business_number)) ? '' :  $check->business_number;
        $data['street'] = (empty($check->street)) ? '' :  $check->street;
        $data['street2'] = (empty($check->street2)) ? '' :  $check->street2;
        $data['state'] = (empty($check->state)) ? '' :  $check->state;
        $data['postcode'] = (empty($check->postcode)) ? '' :  $check->postcode;
        $data['country'] = (empty($check->country)) ? '' :  $check->country;
        
        $data['shortdesc'] = (empty($check->short_description)) ? '' :  show_data_serialize($check->short_description,$this->mytemplate->currentLang());
        $data['main_description'] = (empty($check->main_description)) ? '' :  show_data_serialize($check->main_description,$this->mytemplate->currentLang());
        $data['stars'] = (empty($check->stars)) ? '' :  $check->stars;
        $data['phone1'] = (empty($check->phone1)) ? '' :  $check->phone1;
        $data['phone2'] = (empty($check->phone2)) ? '' :  $check->phone2;
        $data['email1'] = (empty($check->email1)) ? '' :  $check->email1;
        $data['email2'] = (empty($check->email2)) ? '' :  $check->email2;
        $data['fax'] = (empty($check->fax)) ? '' :  $check->fax;
        $data['total_rooms_active'] = (empty($check->total_rooms_active)) ? '' :  $check->total_rooms_active;
        if (empty($check->logo)){
            $data['logo'] = '';
        }else{
            $img_logo = unserialize($check->logo);            
            $thumblogo = $img_logo['raw_name'].'_thumb'.$img_logo['file_ext'];            
            $data['logo'] = 'https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumblogo;
        }
        if (empty($check->feature_image)){
            $data['feature_image'] = '';
        }else{
            $img_feature  = unserialize($check->feature_image);
            $thumbfeature = $img_feature['raw_name'].'_thumb'.$img_feature['file_ext'];
            $data['feature_image'] = 'https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumbfeature; 
        }                
        $data['longitude'] = (empty($check->longitude)) ? '' :  $check->longitude;
        $data['latitude'] = (empty($check->latitude)) ? '' :  $check->latitude;
        $data['rooms_total'] = (empty($check->rooms_total)) ? '' :  $check->rooms_total;
        $data['timezone'] = (empty($check->timezone)) ? '' :  $check->timezone;
        $data['roomratestructure'] = (empty($check->roomratestructure)) ? '' :  $check->roomratestructure;
        $data['deposit'] = (empty($check->deposit)) ? '' :  $check->deposit;
        $data['currency_id'] = (empty($check->currency_id)) ? '' :  $check->currency_id;
                        
        $this->mytemplate->loadTemplate(2,'hotels/form_hotel',$data);
    }
    
    
    public function pushdata(){         
        $this->form_validation->set_rules('hotel_name', 'Hotel name', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');
        $this->form_validation->set_rules('shortdesc', 'Short Description', 'required');
        $this->form_validation->set_rules('maindesc', 'Short Description', 'required');
        $this->form_validation->set_rules('ownerid', 'Owner', 'required');
        $this->form_validation->set_rules('businesname', 'Business Name', 'required');
        $this->form_validation->set_rules('businesnumber', 'Business Number', 'required');
        $this->form_validation->set_rules('street1', 'Street', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('postcode', 'Post Code', 'required|min_length[5]|max_length[6]');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('phone1', 'Phone number', 'required');
        
        $this->form_validation->set_rules('email1', 'Email', 'required|valid_email');        
        $this->form_validation->set_rules('tra', 'Total Room Active', 'required');
        $this->form_validation->set_rules('roomtotal', 'Room Total', 'required');
        $this->form_validation->set_rules('timezone', 'Time Zone', 'required');
        $this->form_validation->set_rules('deposit', 'Deposit', 'required');
        $this->form_validation->set_rules('currency', 'Currency', 'required');
        
        
        if ($this->form_validation->run() == FALSE){             
            $str = validation_errors(); 
            $res = loadMessage(2,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;            
        }else{     
              $id = $this->input->post('id');
              $checkHotel = $this->Hotel_model->getHotel_byID(decode_url($id));  
              // define old thumbnail & logo 
              if ($checkHotel->logo !=''){
                  $logo_img = unserialize($checkHotel->logo);
                  $logo_thumb = $logo_img['raw_name'].'_thumb'.$logo_img['file_ext'];                          
              } else{
                  $logo_img = '';
                  $logo_thumb = '';  
              }    
              
              // define old feature images & thumbnail feature
              if ($checkHotel->feature_image != ''){              
                  $feature_img = unserialize($checkHotel->feature_image);
                  $f_thumb = $feature_img['raw_name'].'_thumb'.$feature_img['file_ext'];
              }else{
                  $feature_img = '';
                  $f_thumb = '';  
              }    
              
              
              $action = $this->input->post('action');  
              // uploading logo                
              if (filter_images($_FILES['logo'])) {
                  $l_data  = $this->mytemplate->upload_file('./uploads/','logo');              
                  $bigimg_l = array("name"=> $l_data['file_name'],
                                  "tmp_name" => $l_data['full_path'] );
                  $thumbimg_l = array("name"=> $l_data['raw_name'].'_thumb'.$l_data['file_ext'],
                                    "tmp_name" => $l_data['thumb'] );     
                  // delete big logo images on aws s3
                  if ($checkHotel->logo !=''){   
                        if ($this->AWS->checkFiles($this->bucketname, $logo_img['file_name'])) $this->AWS->removeFile($this->bucketname, $logo_img['file_name']);
                  }    
                  // delete thumbnail logo images on aws s3  
                  if ($checkHotel->feature_image != ''){  
                        if ($this->AWS->checkFiles($this->bucketname,$logo_thumb)) $this->AWS->removeFile($this->bucketname,$logo_thumb);
                  }                        
                  // send new logo to aws s3 cloud
                  $this->AWS->sendFile($this->bucketname,$bigimg_l,'big logo','public-read');    
                                          
                  $res["logourl"] = $this->AWS->sendFile($this->bucketname,$thumbimg_l, 'thumbnail logo','public-read');
                  $logodb = serialize($l_data); 
                  // remove files from temporary uploads 
                  unlink($l_data['full_path']);
                  unlink($l_data['thumb']);
              }else{
                  $logodb = "";  
              }
              // uploading feature images
              if (filter_images($_FILES['fimages'])) {                      
                  $f_data  = $this->mytemplate->upload_file('./uploads/','fimages');              
                  $bigimg_f = array("name"=> $f_data['file_name'],
                                  "tmp_name" => $f_data['full_path'] );
                  $thumbimg_f = array("name"=> $f_data['raw_name'].'_thumb'.$f_data['file_ext'],
                                    "tmp_name" => $f_data['thumb'] );     
                  
                   // delete big feature images on aws s3   
                  if ($this->AWS->checkFiles($this->bucketname, $feature_img['file_name'])) $this->AWS->removeFile($this->bucketname, $feature_img['file_name']);  
                    
                  // delete thumbnail feature images on aws s3   
                  if ($this->AWS->checkFiles($this->bucketname,$f_thumb)) $this->AWS->removeFile($this->bucketname,$f_thumb);
                  
                  // send new feature images to aws s3 cloud
                  $this->AWS->sendFile($this->bucketname,$bigimg_f,'big feature','public-read');
                  
                  $res["featureurl"] = $this->AWS->sendFile($this->bucketname,$thumbimg_f, 'thumbnail feature','public-read');
                  $featuredb = serialize($f_data);
                  // remove files from temporary uploads 
                  unlink($f_data['full_path']);
                  unlink($f_data['thumb']);
              }else{
                  $featuredb = "";  
              }
              $picdb= array("logo"=>$logodb,
                            "feature"=>$featuredb);
              $return =($action=='add')? $this->Hotel_model->insert($picdb) : $this->Hotel_model->update(decode_url($id),$picdb); 
              if ($return){
                   $id = 1;
                   $str = $this->lang->line('save_success');
              }else{
                   $id = 2;
                   $str = $this->lang->line('save_failed');
              }             
              $res["message"] = loadMessage($id,$str);  
              header('Content-Type: application/json');
              echo json_encode($res);
         }
    }
    
    public function delete($id){      
         // next put data from unserialize
         $check_dependency = $this->Hotel_model->check_dependency(decode_url($id));         
         if(empty($check_dependency)){
            $checkHotel = $this->Hotel_model->getHotel_byID(decode_url($id));  
            
            if ($checkHotel->logo !=''){                    
                  $logo_img   = unserialize($checkHotel->logo);                  
                  $logo_thumb = $logo_img['raw_name'].'_thumb'.$logo_img['file_ext'];
                  // check logo files on aws s3
                  if ($this->AWS->checkFiles($this->bucketname, $logo_thumb)) $this->AWS->removeFile($this->bucketname, $logo_thumb);  // delete thumb logo      
                  if ($this->AWS->checkFiles($this->bucketname, $logo_img['file_name'])) $this->AWS->removeFile($this->bucketname, $logo_img['file_name']);  // delete large logo                                            
            }      
            
            if ($checkHotel->feature_image !=''){
                  $feature_img   = unserialize($checkHotel->feature_image);
                  $feature_thumb = $feature_img['raw_name'].'_thumb'.$feature_img['file_ext'];
                  // check feature images file on aws s3
                  if ($this->AWS->checkFiles($this->bucketname, $feature_thumb)) $this->AWS->removeFile($this->bucketname, $feature_thumb); // delete thumb feature  
                  if ($this->AWS->checkFiles($this->bucketname, $feature_img['file_name'])) $this->AWS->removeFile($this->bucketname, $feature_img['file_name']);  // delete large feature                                   
            }
                         
            $return = $this->Hotel_model->delete_data(decode_url($id));
            $id = ($return)? 1 : 2;
            $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed'); 
         }else{
            $id = 2;
            $str = 'This data can not delete because used another tables';
         }
        
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);       
    }
    
    
            
}

