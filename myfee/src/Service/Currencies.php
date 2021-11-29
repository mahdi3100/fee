<?php

/*
This code is using API of http://api.exchangeratesapi.io/v1/ 
*/

namespace Candidat\Fee\Service;



class Currencies{

    //Save Rate Array
    private static $CurrenciesBaseEUR;

    //my API KEY
    protected const APIKEYEXCHANGE = "4bad8344adaef5fb586188475ede6d48";
    public function __construct()
    {   
          //more addition init
    }
    public function getLastest(){

        $endpoint = 'latest';
       
        $ch = curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.self::APIKEYEXCHANGE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
     
        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);
        //Decode JSON response:
        $conversionResult = json_decode($json, true);
    
        //Check if success connection
        if((bool)$conversionResult["success"] !== True){
        
            throw new \Exception("conversion failed to connect to exchange server , please retry");
        }
        
        //echo "GoT Convertion From exchangeratesapi server ! \n";

        
        self::$CurrenciesBaseEUR =  $conversionResult["rates"];//for test without connection["USD"=>1.22,"JPY"=>115];
       
    }

    //Convertion to EUR
    public static function convertToEUR(float $amount,String $currency):float
    {
        
        //check currency if exist in the rates array 
        if(!array_key_exists($currency,self::$CurrenciesBaseEUR)){
            throw new \Exception("{$currency} does not exsit in Array CurrenciesBaseEUR ");
        }
        
        $toEUR = $amount / self::$CurrenciesBaseEUR[$currency];
        return round($toEUR,2);
    }
    //Convertion from EUR to Main currency
    public static function convertToMainCurr(float $amount,String $currency):float
    {
        $toMainCur = $amount * self::$CurrenciesBaseEUR[$currency];
        return round($toMainCur,2);
    }
}
