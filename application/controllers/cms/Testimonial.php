<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {
    
    private $AWS;
    public $bucketname;
    public $directoryuser;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Testimonial_model');
        $this->AWS = new AmazonS3();
        $this->bucketname = 'roomsranger';
        $this->directoryuser = $this->session->userdata("userName");
    }
    
    public function index()
    {                     
        $data['module'] = 'Testimonial';
        $this->mytemplate->loadTemplate(2,'testimonial/index',$data);
    }
    
    
     public function filldata(){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'postTitle', 
                    1 => 'postHeading',
                    2 => 'postSubheading',
                    3 => 'dateEntry'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Testimonial_model->get_data($params);  
        $totalData = $this->Testimonial_model->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){      
                $code = encode_url($row["postID"]);
                $val_date = convert_date($row["dateEntry"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $nestedData[] = $row["postTitle"]."<br>Rating : ".$row["postSubheading"];              
                $nestedData[] = $row["postHeading"];              
                $nestedData[] =$val_date['date'].' '.$val_date['time'];                
                //add html for action
                $nestedData[] = '<a title="Update" href="'.site_url("cms/testimonial/post/update")."/".$code.'")"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                                 <a title="Delete" href="#" onclick="delete_testimonial('."'".$code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
        $data['module'] = ($mode=="add") ? 'Add Testimonial' : 'Edit Testimonial'; 
        $codeID = decode_url($id);
        $check = $this->Testimonial_model->get_data_byId($codeID);   
        $data['action'] = $mode;
        $data['id'] = (empty($check->postID))? '' : encode_url($check->postID);
        $data['postTitle'] = (empty($check->postTitle)) ? '' :  $check->postTitle; 
        $data['postDescription'] = (empty($check->postDescription)) ? '' :  show_data_serialize($check->postDescription,$this->mytemplate->currentLang()); 
        $data['postHeading'] = (empty($check->postHeading)) ? '' :  $check->postHeading;
        $data['postSubheading'] = (empty($check->postSubheading)) ? '' :  $check->postSubheading;       
        if (empty($check->postImages)){
            $data['logo'] = '';
        }else{
            $img_logo = unserialize($check->postImages);            
            $thumblogo = $img_logo['raw_name'].'_thumb'.$img_logo['file_ext'];            
            $data['logo'] = 'https://s3-us-west-1.amazonaws.com/'.$this->bucketname.'/'.$this->directoryuser.'/'.$thumblogo;
        }                
        $this->mytemplate->loadTemplate(2,'testimonial/form_testimonial',$data);
    }
    
    
    public function pushdata(){         
        $this->form_validation->set_rules('postTitle', 'Guest say', 'required');
        $this->form_validation->set_rules('postSubheading', 'Star', 'required');
        $this->form_validation->set_rules('postDescription', 'Testimonial', 'required'); 
        if ($this->form_validation->run() == FALSE){             
            $str = validation_errors(); 
            $res = loadMessage(2,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;            
        }else{     
              $id = $this->input->post('id');
              $check = $this->Testimonial_model->get_data_byId(decode_url($id));                              
              if (isset($check->postImages)){
                  $logo_img = unserialize($check->postImages);
                  $logo_thumb = $logo_img['raw_name'].'_thumb'.$logo_img['file_ext'];                          
              } else{
                  $logo_img = '';
                  $logo_thumb = '';  
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
                  if (isset($check->postImages)){   
                        if ($this->AWS->checkFiles($this->bucketname, $logo_img['file_name'])) $this->AWS->removeFile($this->bucketname, $logo_img['file_name']);
                  }    
                                        
                  // send new logo to aws s3 cloud
                  $this->AWS->sendFile($this->bucketname,$bigimg_l,'avatar','public-read');    
                                          
                  $res["logourl"] = $this->AWS->sendFile($this->bucketname,$thumbimg_l, 'thumbnail logo','public-read');
                  $logodb = serialize($l_data); 
                  // remove files from temporary uploads 
                  unlink($l_data['full_path']);
                  unlink($l_data['thumb']);
              }else{
                  $logodb = "";  
              }
              
              $picdb= array("logo"=>$logodb);
              $return =($action=='add')? $this->Testimonial_model->insert($picdb) : $this->Testimonial_model->update(decode_url($id),$picdb); 
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
         $check_ = $this->Testimonial_model->get_data_byId(decode_url($id));         
         
            if ($check_->postImages !=''){                    
                  $logo_img   = unserialize($check_->postImages);                  
                  $logo_thumb = $logo_img['raw_name'].'_thumb'.$logo_img['file_ext'];
                  // check logo files on aws s3
                  if ($this->AWS->checkFiles($this->bucketname, $logo_thumb)) $this->AWS->removeFile($this->bucketname, $logo_thumb);  // delete thumb logo      
                  if ($this->AWS->checkFiles($this->bucketname, $logo_img['file_name'])) $this->AWS->removeFile($this->bucketname, $logo_img['file_name']);  // delete large logo                                            
            }      
           
                         
            $return = $this->Testimonial_model->delete_data(decode_url($id));
            $id = ($return)? 1 : 2;
            $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed'); 
               
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);       
    }
    
    
            
}

