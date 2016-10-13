<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v2\AwsS3Adapter; 
use League\Flysystem\Filesystem;       
/**
 * Description of Myflysytem
 *
 * @author wahyu widodo
 */

class Myfly {
    
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
    * Function s3_upload
    * @param array $data private : TRUE/FALSE, local_filepath, bucket, replace url
    * @return array $response s3_url, local_filepath, private
    * 
    */
    
    public function s3_upload($data){        
        $acl = ($data["private"])? "private" : "ACL_PUBLIC_READ";
        $array_conf = array("ACL"=>$acl,                            
                            "SourceFile"=>$data["local_filepath"]);
        $adapter    = new AwsS3Adapter($this->S3,$data["bucket"],null,$array_conf);
        $filesystem = new Filesystem($adapter);                                                    
        $stream = fopen($data["local_filepath"],'r+');
        if ($data["replace"]!="") $filesystem->delete($data["replace"]);
        $filesystem->writeStream($data["folder_path"].'/'.$data["file_name"],$stream);        
        $info = $adapter->readStream($data["folder_path"].'/'.$data["file_name"]);          
        $response=array("s3_url"=>"https://s3-us-west-1.amazonaws.com/".$data["bucket"]."/".$info["path"],
                        "local_filepath"=>$data["local_filepath"],
                        "private"=>$acl);        
        return $response;         
    }       
    
    public function checkFiles($data){  
        try {
            $adapter    = new AwsS3Adapter($this->S3,$data["bucket"],null);
            $filesystem = new Filesystem($adapter); 
            $sizefile   = $filesystem->getSize($data['path']);                                 
        } catch (Exception $e) {
            $sizefile = 0;
        }    
        return ($sizefile>0)?true : false;
    }  
    
    /**
     * Function s3_delete
     * @param array $data contain bucket name and s3_url
     * @return boolean 
     */
    
    public function s3_delete($data){
        $adapter    = new AwsS3Adapter($this->S3,$data["bucket"]);
        $filesystem = new Filesystem($adapter);
        $response = $filesystem->delete($data["s3_url"]);
        return $response;          
    }
    
    /**
	* Function el_crypto_hmacSHA1
    * description : Calculate the HMAC SHA1 hash of a string.
	* @param string $key The key to hash against
	* @param string $data The data to hash
	* @param int $blocksize Optional blocksize
	* @return string HMAC SHA1
	*/
    
    public function el_crypto_hmacSHA1($key, $data, $blocksize = 64) {
        if (strlen($key) > $blocksize) $key = pack('H*', sha1($key));
        $key = str_pad($key, $blocksize, chr(0x00));
    	$ipad = str_repeat(chr(0x36), $blocksize);
    	$opad = str_repeat(chr(0x5c), $blocksize);
    	$hmac = pack( 'H*', sha1(($key ^ $opad) . pack( 'H*', sha1(($key ^ $ipad) . $data))));
   		return base64_encode($hmac);
   	}
    
     /**
    * Function getSignedUrl
    * Description signed URLs to your protected Amazon S3 files.
    * @param data $data This array contain awsAccessKey Your Amazon S3 access key, secretKey Your Amazon S3 secret key,bucket The bucket (mybucket.s3.amazonaws.com), and objectPath The target file path
    * @param int $expires In minutes
    * @param array $customParams Key value pairs of custom parameters
    * @return string Temporary signed Amazon S3 URL
    * @see http://awsdocs.s3.amazonaws.com/S3/20060301/s3-dg-20060301.pdf
    */     
                      
     public function getSignedUrl($data, $expires = 5, $customParams = array()) {      
        # Calculate the expire time.
        $expires = time() + intval(floatval($expires) * 60);                 
        # Clean and url-encode the object path.
        $objectPath = str_replace(array('%2F', '%2B'), array('/', '+'), rawurlencode( ltrim($data["path"], '/') ) );         
        # Create the object path for use in the signature.
        $objectPathForSignature = '/'. $data["bucket"] .'/'. $objectPath;        
        # Create the S3 friendly string to sign.
        $stringToSign = implode("\n", $pieces = array('GET', null, null, $expires, $objectPathForSignature));
        
        # Create the URL frindly string to use.        
        $url = 'https://s3-us-west-1.amazonaws.com/'.$data["bucket"]."/".$objectPath;    
        # Custom parameters.
        $appendCharacter = '?'; // Default append character.
        
        # Loop through the custom query paramaters (if any) and append them to the string-to-sign, and to the URL strings.
        if(!empty( $customParams )){
                foreach ($customParams as $paramKey => $paramValue) {
                        $stringToSign .= $appendCharacter . $paramKey . '=' . $paramValue;
                        $url .= $appendCharacter . $paramKey . '=' . str_replace(array('%2F', '%2B'), array('/', '+'), rawurlencode( ltrim($paramValue, '/') ) );
                        $appendCharacter = '&';
                }
        }        
        # Hash the string-to-sign to create the signature.
        $signature = $this->el_crypto_hmacSHA1($data["secretKey"], $stringToSign);
        
        # Append generated AWS parameters to the URL.
        $queries = http_build_query($pieces = array(
            'AWSAccessKeyId' => $data["awsAccessKey"],
            'Expires' => $expires,
            'Signature' => $signature,
        ));
        $url .= $appendCharacter .$queries;        
        # Return the URL.
        return $url;        
    }

      
}
