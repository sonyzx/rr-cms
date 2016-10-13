<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rooms extends CI_Controller {
    
    private $AWS;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Rooms_model');
        $this->load->model('Hotel_model');
        $this->AWS = new AmazonS3();
    }
    
    public function index()
    {                     
        $data['module'] = $this->lang->line('roomlist');
        $this->mytemplate->loadTemplate(2,'rooms/index',$data);
    }
    
    
    public function filldata(){  
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'r.roomname', 
                    1 => 'h.hotelname',
                    2 => 'r.hourly_rate'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Rooms_model->get_data_rooms($params);  
        $totalData = $this->Rooms_model->get_count_rooms();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){      
                $code = encode_url($row["roomtypeid"]);
                $val_date = convert_date($row["date_created"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array(); 
                $nestedData[] = $row["roomname"];              
                $nestedData[] = $row["hotelname"];              
                $nestedData[] = $row["hourly_rate"];                                
                $nestedData[] = $row["userName"].', '. $val_date['date'].' '.$val_date['time'];
                $nestedData[] = '<a title="Update" href="'.site_url("cms/rooms/post/update")."/".$code.'")"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_rooms('."'".$code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
        $data['module'] = ($mode=="add") ? $this->lang->line('addroomlist') : $this->lang->line('editroomlist');  
        $codeID = decode_url($id);        
        $check = $this->Rooms_model->get_data_byId($codeID);               
        $data['action'] = $mode;
        $data['id'] = (empty($check->roomtypeid))? '' : encode_url($check->roomtypeid);
        $data['hotelid'] = (empty($check->hotelid)) ? '' :  $check->hotelid;
        $data['roomname'] = (empty($check->roomname)) ? '' :  $check->roomname;
        $data['main_description'] = (empty($check->main_description)) ? '' :  show_data_serialize($check->main_description,$this->mytemplate->currentLang());
        $data['short_description'] = (empty($check->short_description)) ? '' :  show_data_serialize($check->short_description,$this->mytemplate->currentLang());
        $data['active'] = (empty($check->active)) ? '' :  $check->active;
        $data['colour'] = (empty($check->colour)) ? '' :  $check->colour;
        $data['mon'] = (empty($check->mon)) ? '' :  $check->mon;
        $data['tue'] = (empty($check->tue)) ? '' :  $check->tue;
        $data['wed'] = (empty($check->wed)) ? '' :  $check->wed;
        $data['thu'] = (empty($check->thu)) ? '' :  $check->thu;
        $data['fri'] = (empty($check->fri)) ? '' :  $check->fri;
        $data['sat'] = (empty($check->sat)) ? '' :  $check->sat;
        $data['sun'] = (empty($check->sun)) ? '' :  $check->sun;
        $data['hourly_rate'] = (empty($check->hourly_rate)) ? '' :  $check->hourly_rate;
        $data['default_bed_id'] = (empty($check->default_bed_id)) ? '' :  $check->default_bed_id;
        $data['ma_room_type_id'] = (empty($check->ma_room_type_id)) ? '' :  $check->ma_room_type_id;
        $data['ma_mapped'] = (empty($check->ma_mapped)) ? '' :  $check->ma_mapped;
        $data['gender'] = (empty($check->gender)) ? '' :  $check->gender;
        $data['occupancy'] = (empty($check->occupancy)) ? '' :  $check->occupancy;
        $data['private_room'] = (empty($check->private_room)) ? '' :  $check->private_room;
        $data['image_url'] = (empty($check->image_url)) ? '' :  $check->image_url;
        $data['widget_footer'] = (empty($check->widget_footer)) ? '' :  $check->widget_footer;
        $data['widget_minimum_stay'] = (empty($check->widget_minimum_stay)) ? '' :  $check->widget_minimum_stay;
        $listhotel = $this->Hotel_model->get_array_db();
        if(isset($listhotel)){
            $opt = '';
            foreach($listhotel as $row => $key):        
                $selected = ($key->hotelid==$data['hotelid'])? 'selected="selected"'  : '';
                $opt .='<option value="'.$key->hotelid.'" '.$selected.' >'.$key->hotelname.'</option>';
            endforeach;
            $data['cmbhotel'] = $opt;
        }else{
            $data['cmbhotel'] = '';
        }

        // Display room_types_photos
        $theroomtypesphotos = (empty($check->hotelid))? '' : $this->Rooms_model->RoomTypesPhotos($codeID,$check->hotelid);                  
        if(!empty($theroomtypesphotos)){
            $tmp =''; 
            foreach($theroomtypesphotos as $row=>$key):                                  
                $tmp.= view_urlImages(false,$key["url"]);         
            endforeach;
            $data['room_types_photos']= $tmp;
        }else{
            $data['room_types_photos']='';
        }
        $this->mytemplate->loadTemplate(2,'rooms/form_rooms',$data);
    }  
    
    public function pushdata(){         
        $this->form_validation->set_rules('roomnames', 'Room name', 'required');
        $this->form_validation->set_rules('hotelid', 'Hotel', 'required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required');
        $this->form_validation->set_rules('main_description', 'Short Description', 'required');        
        $this->form_validation->set_rules('colours', 'Colours', 'required');
        $this->form_validation->set_rules('hourly_rate', 'Hourly rate', 'required');
        $this->form_validation->set_rules('mon', 'Monday', 'required');
        $this->form_validation->set_rules('tue', 'Tuesday', 'required');
        $this->form_validation->set_rules('wed', 'Wednesday', 'required');
        $this->form_validation->set_rules('thu', 'Thursday', 'required');
        $this->form_validation->set_rules('fri', 'Friday', 'required');        
        $this->form_validation->set_rules('sat', 'Saturday', 'required');        
        $this->form_validation->set_rules('sun', 'Sunday', 'required');
  
        if ($this->form_validation->run() == FALSE){             
            $str = validation_errors(); 
            $res = loadMessage(2,$str);  
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;            
        }else{     
              $action = $this->input->post('action');                          
              $return =($action=='add')? $this->Rooms_model->insert() : $this->Rooms_model->update(); 
              if ($return){
                   $id = 1;
                   $str = $this->lang->line('save_success');
              }else{
                   $id = 2;
                   $str = $this->lang->line('save_failed');
              }             
              $res = loadMessage($id,$str);  
              header('Content-Type: application/json');
              echo json_encode($res);
         }
    }
    
    public function delete($id){         
         $return = $this->Rooms_model->delete_data(decode_url($id));
         $id = ($return)? 1 : 2;
         $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed'); 
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);       
    }
    
}


