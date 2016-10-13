<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Aws\S3\S3Client;
      
/**
 * Description of AmazonS3
 *
 * @author wahyu widodo
 */

class AmazonS3 {
    
    private $S3;
        
    public function __construct() {      
        $this->CI = & get_instance();    
        $this->CI->load->model("Blocks_model");
        $this->CI->load->helper('myfunctions');
        $this->CI->load->library('encrypt');
        $aws = $this->CI->Blocks_model->getawsconfig();
        
        $this->S3 = S3Client::factory([             
                'key' => $aws['key'], 
                'secret' => $aws['secret']            
        ]);
                                      
    }
    
    
    /**
    * Function addBucket
    * @param String $bucketName Name of bucket
    */
   
    public function addBucket($bucketName){
        $result = $this->S3->createBucket(array(
	               'Bucket' => $bucketName,
                   'ACL'    => 'ACL_PUBLIC_READ'
        ));              
    }
    
    /**
    * Function removeBucket
    * @param String $bucketName The bucket name will be delete
    */
    
    public function removeBucket($bucketName){
        $result = $this->S3->deleteBucket(array(
	                'Bucket' => $bucketname,
                    'ACL'    => 'ACL_PUBLIC_READ'
	               ));              
    }
    
    /**
    * Function sendFile
    * @param String $bucketname bucket name
    * @param String $filename name a file 
    * @param String $message message
    * @param Boolean $isPrivate 
    * @return String Url AWS S3
    */
    
    public function sendFile($bucketname,$filename,$message,$isPrivate) {        
         $result = $this->S3->putObject(array(
        	    'Bucket' => $bucketname,
        	    'Key'    => $this->CI->session->userdata('userName').'/'.$filename['name'],       
        	    'SourceFile'   => $filename['tmp_name'],
                'ContentType'  => 'image/png',
                'StorageClass' => 'STANDARD',
                'ACL'    => $isPrivate
	           ));         
        return $result['ObjectURL'] . "\n";
    }
    
    /**
    * Function checkFiles
    * @param String $bucketname The name a bucket
    * @param String $filename The name a file
    * @return Boolean
    */
    
    public function checkFiles($bucketname,$filename){
        $filename = ($filename == '')? 'null' : $filename;
        $result = $this->S3->doesObjectExist($bucketname, $this->CI->session->userdata('userName').'/'.$filename);
        return $result;
    }
    
    /**
    * Function removeFile
    * @param String $bucketname The name a bucket
    * @param String $filename The name a file
    * @return Boolean 
    */    

    public function removeFile($bucketname,$filename){        
        $result = $this->S3->deleteObject(array(
                    'Bucket' => $bucketname,
                    'Key'    => $this->CI->session->userdata('userName').'/'.$filename
                   ));
        return TRUE;
    }
    
      /**
    * Function checkDir
    * @param String $bucketname The name a bucket
    * @param String $dir The name a directory
    * @return Boolean
    */
    
    public function checkDir($bucketname,$dir){
        $dir = ($dir == '')? 'null' : $dir;
        $result = $this->S3->doesObjectExist($bucketname, $dir.'/');
        return $result;
    }
    
    
    /**
    * Function createDir
    * @param String $bucketname
    */
    
    public function createDir($bucketname,$folder){ 
        $exist_folder = $this->checkDir($bucketname,$dir);
        if(!$exist_folder){
             $this->S3->putObject(array( 
                   'Bucket'       => $bucketname, // Defines name of Bucket
                   'Key'          => $folder.'/', //Defines Folder name
                   'Body'         => "",
                   'ACL'          => 'public-read' // Defines Permission to that folder
             ));   
        }               
    }
    
   
      
    
    
}
