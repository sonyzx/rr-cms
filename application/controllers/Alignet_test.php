<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alignet_test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library("Alignet_call");
    }
    
    public function index(){
        $alignet = new Alignet_call(); 
        $cscr = $alignet->get_secreta();                            
        echo "Example Web Service Wallet<br />";         
        $valTransc = array("acquirerId" => "144",
                           "idCommerce" => "7834",
                           "purchaseOperationNumber"=> "90032",
                           "purchaseAmount" => "10000",
                           "purchaseCurrencyCode" => "604",
                           "claveSecreta" => $cscr ); 
        $alignet->purchaseVerification($valTransc);
        $cardInput = array("idEntCommerce"=> "7834",
                            "codCardHolderCommerce" => "",
                            "names" => "Wahyu",
                            "lastNames" => "Widodo",
                            "mail" => "wahyusoft@yahoo.com", 
                            "claveSecreta" => $cscr); 
        $result = $alignet->sendPurchase($cardInput,$valTransc);
        echo "<pre>";print_r($result);die();        
    }
    
    public function vpost(){
        $alignet = new Alignet_call();          
        $data["purchaseUrl"] = $alignet->purchase_url;               
        $valTransc = array("acquirerId" => "180",
                           "idCommerce" => "134",
                           "purchaseOperationNumber"=> "90032",
                           "purchaseAmount" => "10000",
                           "purchaseCurrencyCode" => "604",
                           "claveSecreta" => "ZwRJfNjFwbCjASvqS$4768374498" ); 
        $data["purchaseVerification"] = $alignet->purchaseVerification($valTransc);        
        $data["acquirerId"] = $valTransc["acquirerId"];
        $data["idCommerce"] = $valTransc["idCommerce"];
        $data["purchaseOperationNumber"] = $valTransc["purchaseOperationNumber"];
        $data["purchaseAmount"] = $valTransc["purchaseAmount"];
        $data["purchaseCurrencyCode"] = $valTransc["purchaseCurrencyCode"];        
        $this->load->view("vpost",$data);         
    }
         
}


?>