<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
require_once 'lib/payU.php';


class Payu_call  {
       
    public function __construct($ID) {   
        PayU::$apiKey  = "6u39nqhq8ftd0hlvnjfs66eh8c";
        PayU::$apiLogin = "11959c415b33d0c";
        PayU::$merchantId = $ID;
        PayU::$language ="US";
        PayU::$isTest = TRUE;
        
        Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
        Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
        Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");            
    }
     
      /** 
       * function sendPurchase       
       * @param array $valTransc details information about billing
       
     */       
   public function sendPurchase($hotel_data,$cardInput,$valTransc){  
             // PaymentMethods::MASTERCARD || PaymentMethods::AMEX || "ARGENCARD" || "CABAL" || "NARANJA" || "CENCOSUD" || "SHOPPING"                   
             switch ($cardInput["cc_cardtype"]) {
                        case "Visa":
                            $paymet_method = PaymentMethods::VISA;
                            break;
                        case "MasterCard":
                            $paymet_method = PaymentMethods::MASTERCARD;
                            break;
                         case "American Express":
                            $paymet_method = PaymentMethods::AMEX;
                            break;
                         case "Discover":
                            $paymet_method = PaymentMethods::DISCOVER;
                            break;
                        default:
                             $paymet_method = PaymentMethods::VISA;
                            break;
            }
            $CI = & get_instance();   
            $CI->load->library('user_agent');
            $parameters = array(
                    //Enter the account’s identifier here
                    PayUParameters::ACCOUNT_ID => "509171",
                    // Enter the reference code here.
                    PayUParameters::REFERENCE_CODE => $cardInput['cardReference'],
                    // Enter the description here.
                    PayUParameters::DESCRIPTION => $valTransc['description'],

                    // -- Values --
                    // Enter the value here.       
                    PayUParameters::VALUE => $valTransc['amount'],
                    // Enter the currency here.
                    PayUParameters::CURRENCY => $valTransc['currency'],

                    // -- Payer --
                    ///Enter the payer's name here
                    PayUParameters::PAYER_NAME => $cardInput['firstName'],
                    //Enter the payer's email here
                    PayUParameters::PAYER_EMAIL => $cardInput['email'],
                    //Enter the payer's contact phone here.
                    PayUParameters::PAYER_CONTACT_PHONE => "7563126",
                    //Enter the payer's contact document here.
                    PayUParameters::PAYER_DNI => "5415668464654",
                    //Enter the payer's address here.
                    PayUParameters::PAYER_STREET => $cardInput['address1'],
                    PayUParameters::PAYER_STREET_2 =>$cardInput['address2'],
                    PayUParameters::PAYER_CITY => $cardInput['city'],
                    PayUParameters::PAYER_STATE => $cardInput['state'],
                    PayUParameters::PAYER_COUNTRY => $cardInput['country'],
                    PayUParameters::PAYER_POSTAL_CODE => $cardInput['postcode'],
                    PayUParameters::PAYER_PHONE => "7563126",

                    // -- Credit card data -- 
                    // Enter the number of the credit card here
                    PayUParameters::CREDIT_CARD_NUMBER => $cardInput['number'],
                    // Enter expiration date of the credit card here
                    PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $cardInput['expiryYear']."/".$cardInput['expiry_month'],
                    //Enter the security code of the credit card here
                    PayUParameters::CREDIT_CARD_SECURITY_CODE=> $cardInput['cvv'],
                    //Enter the name of the credit card here                   
                    PayUParameters::PAYMENT_METHOD => $paymet_method, 
                    // Enter the number of installments here.
                    PayUParameters::INSTALLMENTS_NUMBER => "1",
                    // Enter the name of the country here.
                    PayUParameters::COUNTRY => PayUCountries::$cardInput['country'],

                    // Device Session ID
                    PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
                    // Payer IP
                    PayUParameters::IP_ADDRESS => $valTransc['clientIp'],
                    // Cookie of the current session
                    PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                    // User agent of the current session       
                    PayUParameters::USER_AGENT=>$CI->agent->agent_string()
	);
	
            $response = PayUPayments::doAuthorizationAndCapture($parameters);
            $result = array();
            if ($response) {
                    $response->transactionResponse->orderId;
                    $response->transactionResponse->transactionId;
                    $response->transactionResponse->state;
                    if ($response->transactionResponse->state=="PENDING"){
                            $response->transactionResponse->pendingReason;	
                    }
                    $response->transactionResponse->paymentNetworkResponseCode;
                    $response->transactionResponse->paymentNetworkResponseErrorMessage;
                    $response->transactionResponse->trazabilityCode;
                    $response->transactionResponse->responseCode;
                    $response->transactionResponse->responseMessage;                       
                    $result["error_code"] = $response->transactionResponse->responseCode;
                    $result["transaction_id"] = $response->transactionResponse->orderId;
                    $result["gateway_order_id"] = '';
                    $result["gateway"] = $hotel_data["payment_gateway"];
                    $result["message"] = $response->transactionResponse->paymentNetworkResponseErrorMessage;
                    $result["amount"] = $valTransc['amount'];
                    $result["currency"] = $valTransc['currency'];
                    $result["full_response"] =  $response->transactionResponse->responseMessage;  
            }
            return $result;
    }
    
    
}
