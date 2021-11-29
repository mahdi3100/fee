<?php


namespace Candidat\Fee\Service;
use Candidat\Fee\Service as myclass;






class NewCSV{
    private $dataCSV;
    public function __construct(String $filePath)
    {
       

            $this->dataCSV = fopen($filePath,"r+");

            if(!$this->dataCSV){
                throw new \Exception("File could not be open");
            }
            //call it once to get conversion array
            $Exchange = new myclass\Currencies();
            //the function automic Converion  by api is restricted due to free Subscription Plans that why i used the free function "lastest"
            $Exchange->getLastest();
            
          
            

            

           

    }
    public function checkFormatCSV(): void
    {
        //this var used to indicate the error in which line in csv file
        $indexLines = 1;

        while ($readcsv = fgetcsv($this->dataCSV)) {
             //print_r($readcsv);


            //check if 1 line contains 5 columns
            if(count($readcsv) !=  6){
               
                throw new \Exception("Line Number ".$indexLines." does not respect format of csv service Transaction");
            }

       
             $indexLines++;

        }
    }

    //Read File CSV 
    public function FeeResault():void
    {
        
        //move cursor to the begining to read file
        rewind($this->dataCSV);

        while ($readcsv = fgetcsv($this->dataCSV)) {
         //print_r($readcsv);

            $newTransaction = new myclass\CalculeTransaction($readcsv);
            $newTransaction->startCalcul();

        }
        fclose($this->dataCSV);
      
    }
}






