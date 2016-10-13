<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(
		realpath("../libs") .
		PATH_SEPARATOR . get_include_path()
);

require_once "libs/GPG.php";

class Alignet_call {
    
    public $wsdl;
    public $purchase_url;
        
    public function __construct() {   
        $this->CI = & get_instance(); 
        $this->CI->load->helper('inflector');                
        $this->wsdl         = "https://test2.alignetsac.com/WALLETWS/services/WalletCommerce?wsdl";//"https://integracion.alignetsac.com/WALLETWS/services/WalletCommerce?wsdl";
        $this->purchase_url = "https://test2.alignetsac.com/VPOS2/faces/pages/startPayme.xhtml"; //"https://integracion.alignetsac.com/VPOS2/faces/pages/startPayme.xhtml";                                      
    }
    
    /**
    * Function purchaseVerification
    * Desc : Validation Transction Parameters 
    * @param array $valTransc array(acquirerId,idCommerce,purchaseOperationNumber,purchaseAmount,purchaseCurrencyCode,claveSecreta)
    * @return array @response
    */
    
    public function purchaseVerification($valTransc){
        $acquirerId = $valTransc["acquirerId"];
        $idCommerce = $valTransc["idCommerce"];
        $purchaseOperationNumber = $valTransc["purchaseOperationNumber"];
        $purchaseAmount = number_format($valTransc["purchaseAmount"], 2, '.', '');
        $purchaseCurrencyCode = $valTransc["purchaseCurrencyCode"];            
        $claveSecreta = $valTransc["claveSecreta"];                        
        $response = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveSecreta, 'sha512');
        return $response;
    }
    
    /**
    * Function sendPurchase
    * @param array $cardInput 
    * @param array $valTransc    
    * @return array
    */
    
    public function sendPurchase($cardInput,$valTransc){         
        $this->purchaseVerification($valTransc);
        // Card Input Parameters                        
        $idEntCommerce = $cardInput["idEntCommerce"];
        $codCardHolderCommerce = $cardInput["codCardHolderCommerce"];
        $names = $cardInput["names"];
        $lastNames = $cardInput["lastNames"];
        $mail = $cardInput["mail"];         
        $reserved1 = '';
        $reserved2 = '';
        $reserved3 = '';                                             
        $registerVerification = openssl_digest($idEntCommerce . $codCardHolderCommerce . $mail . $valTransc["claveSecreta"], 'sha512');
              
        $client = new SoapClient($this->wsdl);       
        $params = array(
                    'idEntCommerce'=>$idEntCommerce,
                    'codCardHolderCommerce'=>$codCardHolderCommerce,
                    'names'=>$names,
                    'lastNames'=>$lastNames,
                    'mail'=>$mail,
                    'reserved1'=>$reserved1,
                    'reserved2'=>$reserved2,
                    'reserved3'=>$reserved3,
                    'registerVerification'=>$registerVerification
                   );
        $response = $client->RegisterCardHolder($params); 
        $result["ansCode"] = $response->ansCode;
        $result["ansDescription"] = $response->ansDescription;
        $result["codAsoCardHolderWallet"] = $response->codAsoCardHolderWallet;
        $result["date"] = $response->date;
        $result["hour"] = $response->hour;
        return $result;
    }
    
     /**
    * Function sendShipping
    * @param array $valTransc 
    * @param array $valShipping    
    * @param array $purchaseVer
    * @return array
    */
    
    public function sendShipping($valTransc,$valShipping){        
        $arrayParams    = array("acquirerId"=> $valTransc["acquirerId"],
                                "idCommerce" => $valTransc["idCommerce"],
                                "purchaseOperationNumber" => $valTransc["purchaseOperationNumber"],
                                "purchaseAmount" => $valTransc["purchaseAmount"],
                                "purchaseCurrencyCode" => $valTransc["purchaseCurrencyCode"],
                                "language" => $valShipping["language"],
                                "shippingFirstName" => $valShipping["shippingFirstName"],
                                "shippingLastName" => $valShipping["shippingLastName"],
                                "shippingEmail" => $valShipping["shippingEmail"],
                                "shippingAddress" => $valShipping["shippingAddress"],
                                "shippingZIP" => $valShipping["shippingZIP"],
                                "shippingCity" => $valShipping["shippingCity"],
                                "shippingState" => $valShipping["shippingState"],
                                "shippingCountry" => $valShipping["shippingCountry"],
                                "userCommerce" => $valShipping["userCommerce"],
                                "userCodePayme" => $valShipping["userCodePayme"],
                                "descriptionProducts" => $valShipping["descriptionProducts"],
                                "programmingLanguage" => $valShipping["programmingLanguage"],
                                "MCC" => $valShipping["MCC"],
                                "commerceAssociated" => $valShipping["commerceAssociated"],
                                "reserved1" => $valShipping["reserved1"],
                                "purchaseVerification" => $this->purchaseVerification($valTransc) 
                                );                                  
          $ch=curl_init();
          curl_setopt($ch, CURLOPT_URL, $this->purchase_url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayParams);
          $response=curl_exec($ch);
          curl_close($ch);        
          return $response;                                  
    }
    
    public function get_publickey_comercio(){        
        $publickey_comerco = "-----BEGIN PGP PUBLIC KEY BLOCK-----                
                mQENBFbOPwYBCACuIcYNgMfSizP3PbUQe2lQ1Fq2rUrZya6be+dwUO7kNM4uFjKL
                CMK2HsG6oEzb97xm2jyKEOz4sLH7eSDu+Yzm0FZO5+TrZA+0UY7XXp3cpbDwsk8Z
                RB1zWSFNXZGbotvr18GcJ0i0UMIqo9YQoIDeLW5rHaQ6sV3vIsKNvjxN8Pb4x/tS
                P6FF6mK0tTBSXgL2OIwYRR0SECyjAs/r0iZvfpVzammBYPqWdAgr8yK6H+s58aOy
                YDHgCi9C6FyXcC/FKTBY2kzk6TXgvR/ADj/m3nDMIWNJYMs4sCLapaw9D1MwQSS/
                6ROoY6zA6okAYM6bXDc4m9sYvDzZeO+cTCWNABEBAAG0C3dhbGxldHJvb20yiQEc
                BBABAgAGBQJWzj8GAAoJECA/LmWIaxysc9QH/36LLC2zrLcBxHC7RohovNA1KzX9
                uBP0Qn6hC7gHcMVbJq+5cAF8e2sQKo2OvS6mk/UoLyhtcDcJIcKLgvM9jpHv7wKB
                YiP5D4TIn/LWZHHM18sOeWfCzzS2M9PGIety4snImaPoTXlQrZ3AXtswoewSjzKU
                bh/E62NiUQCy3/aY3rLKtHwPsEZgSP5Icy+wSnk/cGY3quaT3XjnxlNI6tt7Zicf
                nXid4+JPYCiUe9wTYMSnefzFISCIqFa3WmpFDs4hKZdiCuWvQMUNABKAdpwVuROj
                ABrDqcPMLtSKaXnArpeBXSgC0Cx2YfYnkTC8iUGhICw4+wb810k9RgJcxvw=
                =77Fz
                -----END PGP PUBLIC KEY BLOCK-----";
        return $publickey_comerco;        
    }
    
    public function get_publickey_alignet(){
        $publickey_alignet = "-----BEGIN PGP PUBLIC KEY BLOCK-----               
                mQENBFbOPwcBCAC8e36aWCnvwfvOjQ0QH8hHq7A/nn277ouiz5KPzb5zjBLtZTvA
                uNGu4qgKD7KNuuV7YVhB7tXljQ5CkkBZdW3Lwk1BmrBt4geMrlmlTWJRUEyykIZG
                PkJVKmYLFyGJVBjYd4wj9lIf7vdt3q9u/Eks6rq20WZzy0gPPWZUDTMClZgzJPsm
                Xcm7zb21V50tisTNQMIdC24ZQRGa+3BgaOFH/AOBSwNpjHw+pgPdCqqM/9KDgYcK
                +Dpsm9QRIqTBfpHlxRxowTbg5mCflE/kYafP0H0r9pmYxMmjmcbJjQVbxLwbKPJ2
                3Vw2Agklqo3SPgt//Vy3pBAjvr3B4GB785O1ABEBAAG0DndhbGxldHJvb20yQUxH
                iQEcBBABAgAGBQJWzj8HAAoJELRx8fkarj5bBNoH/R5VNwjq0q05RHrRfLEL7IN1
                FpZx6EhJiBVpk1bDpdGGBaPWri3tS/4iM4+oULWeMOW8MS4cwd1dqhP1wAEgLAOz
                XxTqtGB1z9FWmxNDeQ4Z+p1JsEymim5amtIpSSaN7nO4dH5UBgKgCJ2Pgv1Up0/a
                opzKpVtA9kubdqoByqeFxl2aQvFPJqUA/N1CpSYRuidREhewyBGNPWW4BJhxVEfT
                BTPsbElwycnCaJo0j74Ke3m2bhG/7XYsM+lYULA70iBrIU9mdnwSvSmRftBAKOnj
                O6ASUVVeS8AS8B5t5qlJHtL7ykpLPjRNWX5ykZ75E2AHXcbsP784EYkyWudorwQ=
                =GqPq
                -----END PGP PUBLIC KEY BLOCK-----";
        return $publickey_alignet;
    }
    
    public function get_publickey_wallet(){
        return '-----BEGIN PGP PUBLIC KEY BLOCK-----
                [*]                
                mQENBFbOOaUBCADBZ7MlI2oz6/V+NV784Q99FRTYo3dHOh5HFBbMUyjbEzS/pena
                FNyj2kma74OAG5IP/Q/1r/IcqXopKKEAO72gkStS057aKljwFKtBp6GamTR7NVW5
                lQxFMr9AQE+OqxUu12aJ/8YOgwTpl80liitQk0T0/dnYHKIn5z+8fh82rTsrruUa
                xyH7nFe/G9cLc602BVJUUQrhh4O5mKVkhcw2Dvr/bvTVCMrmvGHuIgehsREZgPOh
                u8X+GQlFyPD7WsfPvBHX0M5wx3aMIAxyn7yXaVKDeSC6a5dhDIzUn1Pmz9uzJ4DX
                dSWbXhgiffT+c3ccDKnHiuPVJPNyfr837Lb/ABEBAAG0DnJvb21yYW5nZXIyQUxH
                iQEcBBABAgAGBQJWzjmlAAoJEGHVusuWqw/c7jEH/iaNCahIcXyT+cAwzqc6MCIl
                johtd2rgsA0mSyKO2xIvUDgFB+ceN7+xqh0hEVwMCLzzrOPgX+JZ4qoSbmOopmzB
                SRX9PklplUc9Fs5BSNwyJqhgfbCtrDGKrwGEHI+o2w3x17z6QEuIR/mFVnBAE6+R
                5GFHoCgGd0DyxY2G0M0PCZzzsS7idPi1swFgWiuA3o/NSypuSVpf4qWFRtnyI+vx
                aObs5VmYnTg+KojIttq2WuEcwmUGqHKFx6KYSlK8ozKza5F+au4cnnfy4lzJ+0CS
                mI3ao6NxD8RtizHKEYruyd49T4PgSL6OAHFl+d2RAAIf3OTPIfMw9CYEfvL0EdA=
                =zm0a[*]
                -----END PGP PUBLIC KEY BLOCK-----';
    }
    
    
    public function get_secreta(){
        $public_key_ascii = $this->get_publickey_wallet();
        $plain_text_string = "roomranger2";
        $gpg = new GPG();
		$the_key = new GPG_Public_Key($public_key_ascii);        
		$encrypted = $gpg->encrypt($the_key,$plain_text_string);
        return $encrypted;
    }
    

      
}
