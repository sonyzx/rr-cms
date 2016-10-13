<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookingwidget extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->library('Omnipay_call');
        $this->load->library('Openpayu_call');
    }

    public function index(){                           
           $cc_client_data["first_name"] = $this->input->post('bw_first_name-1');
           $cc_client_data["last_name"] = $this->input->post('bw_last_name-1');	
           $cc_card_data["phone"] = $this->input->post('bw_phone-1');
	$cc_card_data["email"] = $this->input->post('bw_email-1');	
            $cc_card_data["cc_cardtype"]	= $this->input->post('cc_cardtype');
            $cc_card_data["cc_number"]	= $this->input->post('cc_number');
            $cc_card_data["expiry_month"]	= $this->input->post('expiryMonth');
            $cc_card_data["expiry_year"]	= $this->input->post('expiryYear');
            $cc_card_data["token"]            = $this->input->post('token');
            $cc_card_data["cvv"]              = $this->input->post('cvv');          
            $cc_client_data["postcode"]	= $this->input->post('bw_postcode');
            $cc_client_data["country"]	= $this->input->post('bw_country');
            $bookingdata["booking_grand"] = $_GET["hotel_id"];
	$pay_result = $this->_make_payment($_GET["hotel_id"],121,$bookingdata,$cc_card_data,$cc_client_data,'USD','Description of payment');            
    }
    
    public function _make_payment($hotel_id,$booking_id,$bookingdata,$card_data,$client_data,$currency_code,$description){
          $this->load->model("Hotel_model");    
          $hotel_data = $this->Hotel_model->get_data_byId($hotel_id);
          if($hotel_data["payment_gateway"]=="2checkout"){
              $this->load->library('Two_checkout_call');
              $valTransc = array(
	            'amount' => number_format($bookingdata["booking_grand"], 2, '.', ''),
	            'booking_id' => $booking_id,
	            'description' => $description,
	            'currency' => $currency_code,
	            'clientIp' => $this->input->ip_address()
	         );
            $cardInput = array(
	           // 'firstName' => $client_data["first_name"]." ".$client_data["last_name"],
	            'cardReference' => $card_data["token"],
	            'name' => $client_data["full_name"],
	            'currency' => $currency_code,
	            'email' => $client_data["email"],
	            'address1' => $client_data["address1"],
	            'address2' => $client_data["address2"],
	            'city' => $client_data["city"],
	            'state' => $client_data["state"],
	            'postcode' => $client_data["postcode"],
	            'country' => $client_data["country"],

	        );
	        $purchaseProc = new Two_checkout_call();
	        $data = $purchaseProc->sendPurchase($hotel_data,$cardInput,$valTransc);
          }elseif($hotel_data["payment_gateway"]=='payu'){
                 $cardInput = array(
	            'firstName' => $client_data["first_name"]." ".$client_data["last_name"],                       
	            'cardReference' => $card_data["token"],
                       'number' => $card_data["cc_number"],
                       'cc_cardtype' => $card_data["cc_cardtype"],
	            'cvv' => $card_data["cvv"],
	            'expiryMonth' => $card_data["expiry_month"],
	            'expiryYear' => $card_data["expiry_year"], 	            
	            'currency' => $currency_code,
	            'email' => $client_data["email"],
	            'address1' => $client_data["address1"],
	            'address2' => $client_data["address2"],
	            'city' => $client_data["city"],
	            'state' => $client_data["state"],
	            'postcode' => $client_data["postcode"],
	            'country' => $client_data["country"],
	        );	                       	  	
                   $valTransc = array(
	            'amount' => number_format($bookingdata["booking_grand"], 2, '.', ''),
	            'booking_id' => $booking_id,
	            'description' => $description,
	            'currency' => $currency_code,
	            'clientIp' => $this->input->ip_address()
	         );
	     $purchaseProc = new Payu_call($booking_id);
	     $data = $purchaseProc->sendPurchase($hotel_data,$cardInput,$valTransc);                    
          }else{
              $cardInput = array(
	            'firstName' => $client_data["first_name"],
	            'lastName' => $client_data["last_name"],
	            'number' => $card_data["cc_number"],
	            'cvv' => $card_data["cvv"],
	            'expiryMonth' => $card_data["expiry_month"],
	            'expiryYear' => $card_data["expiry_year"],
	            'email' => $client_data["email"]
	        );
	        if($card_data["postcode"]!=""){
			 	$cardInput['billingPostcode'] = $card_data["postcode"];
			}
       	  	if($card_data["country"]!=""){
	        	$cardInput['billingCountry'] = $card_data["country"];
	        }
	       //  log_message('error', "Payment send sent is...".print_r($cardInput,true));

	        $valTransc = array(
	            'amount' => number_format($bookingdata["booking_grand"], 2, '.', ''),
	            'booking_id' => $booking_id,
	            'description' => $description,
	            'currency' => $currency_code,
	            'clientIp' => $this->input->ip_address(),
	            'returnUrl' => base_url()
	         );
	        $purchaseProc = new Omnipay_call();
	        $data = $purchaseProc->sendPurchase($hotel_data,$cardInput,$valTransc);
          }
          return $data;
    }
    
    
    
   
                 
}
