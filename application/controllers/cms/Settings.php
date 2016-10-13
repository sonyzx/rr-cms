<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\S3\S3Client;

class Settings extends CI_Controller {

    private $AWS;
    
    public function __construct() {
        parent::__construct();    
        $this->load->model("Blocks_model");
        $this->load->model("Buckets_model");
        $this->AWS = new AmazonS3();  
    }

    public function index()
    {        
         $aws = $this->Blocks_model->getawsconfig();         
         $data['module'] = $this->lang->line('settingconfig');
         $data['key']   = $aws['key'];
         $data['secret'] = $aws['secret'];
         $data['region'] = $aws['region'];
         $array_blocks = $this->Blocks_model->showblock();         
         $opt = '';
         foreach($array_blocks as $row):
             $opt .= '<option value="'.$row['blockID'].'">'. show_data_serialize($row['blockType'],'en').'</option>';
         endforeach;
         $data['theblocks'] = $opt;
         $this->mytemplate->loadTemplate(2,'dashboard/setting',$data);              
    }
    
    /* BLOCK */ 
    
    public function datablock(){
        $requestData= $_REQUEST;
        $columns = array(            
                    0 => 'blockID', 
                    1 => 'blockType', 
                    2 => 'datecreate'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Blocks_model->get_data($params);  
        $totalData = $this->Blocks_model->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){    
                $val_date = convert_date($row["datecreate"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array();             
                $nestedData[] = $row['blockID'];
                $nestedData[] = show_data_serialize($row["blockType"],$this->mytemplate->currentLang());
                $nestedData[] = $val_date['date'].' '.$val_date['time'];;
                //add html for action
                $blockID = encode_url($row["blockID"]);
                $nestedData[] = '<a title="Update" href="#" onclick="update_block('."'".$blockID."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
                               <a title="Delete" href="#" onclick="delete_block('."'".$blockID."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
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
    
     public function addblock(){
         $this->form_validation->set_rules('blocktype', 'Block Type', 'required');
         if ($this->form_validation->run() == FALSE){   
             $str = validation_errors();
             $res = loadMessage(2,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{              
             $return = $this->Blocks_model->add();
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
    
    public function deleteblock($id){
         $return = $this->Blocks_model->delete(decode_url($id));
         $id = ($return)? 1 : 2;
         $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed'); 
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);
   }
   
    public function update_block($id){
       $row = $this->Blocks_model->get_data_byId(decode_url($id));   
       $data['id'] = encode_url($row->blockID);
       $data['blockType'] = show_data_serialize($row->blockType,$this->mytemplate->currentLang());
       echo json_encode($data);
   }
   
   public function push_update(){
       $return =$this->Blocks_model->update_block(); 
       $id = ($return)? 1 : 2;
       $str = ($return)? $this->lang->line('save_success') : $this->lang->line('save_failed'); 
       $res = loadMessage($id,$str);  
       header('Content-Type: application/json');
       echo json_encode($res);    
   }
  
   /* END BLOCK */ 
   
   /* BUCKET */
   
   public function databucket(){
        $requestData= $_REQUEST;
        $columns = array(             
                    0 => 'b.bucketName', 
                    1 => 'k.blockType',
                    2 => 'b.datecreate'
            );
        $params = array('search'=>!empty($requestData['search']['value'])?  $requestData['search']['value']: '',
                       'order' => $columns[$requestData['order'][0]['column']],
                       'sorting' => $requestData['order'][0]['dir'],
                       'start' => $requestData['start'],
                       'finish' => $requestData['length']
                      );
        
        $result = $this->Buckets_model->get_data($params);  
        $totalData = $this->Buckets_model->get_count();
        $data = array();
        $totalFiltered=0;        
        foreach($result as $row){    
                $val_date = convert_date($row["datecreate"]);
                $totalFiltered=$totalFiltered+1;                
                $nestedData=array();             
                $nestedData[] = $row['bucketName'];
                $nestedData[] = show_data_serialize($row["blockType"],$this->mytemplate->currentLang());
                $nestedData[] = $val_date['date'].' '.$val_date['time'];;
                //add html for action
                $bucketID = encode_url($row["bucketID"]);
                $nestedData[] = '<a title="Delete" href="#" onclick="delete_bucket('."'".$bucketID."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                
                               // '<a title="Update" href="#" onclick="update_bucket('."'".$bucketID."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
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
    
    public function addbucket(){
         $this->form_validation->set_rules('bucketname', 'Bucket Name', 'required');
         $this->form_validation->set_rules('blocktype', 'Block Type', 'required');
         if ($this->form_validation->run() == FALSE){   
             $str = validation_errors();
             $res = loadMessage(2,$str);  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{         
             $bucketname = $this->input->post('bucketname',true);
             $this->AWS->addBucket(filter_string($bucketname));
             $return = $this->Buckets_model->add();
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
    
   public function deletebucket($id){          
         $return = $this->Buckets_model->delete(decode_url($id));
         $id = ($return)? 1 : 2;
         $str = ($return)? $this->lang->line('delete_success') : $this->lang->line('delete_failed'); 
         $res = loadMessage($id,$str);  
         header('Content-Type: application/json');
         echo json_encode($res);
   }
    
   public function update_bucket($id){
       $row = $this->Buckets_model->get_data_byId(decode_url($id));   
       $data['id'] = encode_url($row->bucketID);
       $data['bucketName'] = $row->bucketName;
       $data['blockID'] = $row->blockID;
       echo json_encode($data);
   }
   
   public function push_updatebucket(){
       $return =$this->Buckets_model->update_bucket(); 
       $id = ($return)? 1 : 2;
       $str = ($return)? $this->lang->line('save_success') : $this->lang->line('save_failed'); 
       $res = loadMessage($id,$str);  
       header('Content-Type: application/json');
       echo json_encode($res);    
   }
   
   /* END BUCKET */
   
  
   
    public function setConnection()
    {
         $this->form_validation->set_rules('key', 'Key', 'required');
         $this->form_validation->set_rules('secret', 'Secret', 'required');
         $this->form_validation->set_rules('region', 'Region', 'required');
         if ($this->form_validation->run() == FALSE){      
             $res = loadMessage(2,  validation_errors());  
             header('Content-Type: application/json');
             echo json_encode($res);
             exit;
         }else{                         
             try {
                 $key   = $this->input->post('key',true);
                 $secret = $this->input->post('secret',true);
                 $S3 = S3Client::factory([
                    'key' => $key, 
                    'secret' => $secret 
                  ]);                 
                 $this->Blocks_model->awsconnect();                 
                 $buckets = $S3->listBuckets();                 
                 $message = array("ID"=>1,"STR"=>"AWS S3 Conection Success");
             }
             catch(Exception $e){
                 $message["ID"] = 2;
                 $message["STR"] = $e->getMessage();
             } 
              $res = loadMessage($message["ID"],$message["STR"]);  
              header('Content-Type: application/json');
              echo json_encode($res);
         }
    }   
    
    
    public function listBucket(){          
        try {
            $S3 = S3Client::factory([
                'key' => $this->session->userdata("key"), 
                'secret' => $this->session->userdata("secret") 
            ]);
            $result = $S3->listBuckets(array());                        
            $x=1;
            foreach ($result['Buckets'] as $bucket) {
                $x++;
                $css =($x%2==0)? "odd gradeX" : "even gradeC"; 
                $delete = site_url('cms/awsconfig/deletebucket/');
                echo '<tr class="'.$css.'">
                        <td>'.$bucket['Name'].'</td>
                        <td class="center"><a href="'.$delete.'" data-id="'.$bucket['Name'].'" class="btndelete" title="delete"><i class="glyphicon glyphicon-remove" class="btndelete" title="delete"></i></a></td>
                      </tr>';                  
            }               
         }
             catch(Exception $e){
                 $message["ID"] = 2;
                 $message["STR"] = $e->getMessage();
                 $res = loadMessage($message["ID"],$message["STR"]);  
                header('Content-Type: application/json');
                echo json_encode($res);
         }     
    }
    
   
   
    
    
    
    
        
   
                 
}
