<?php



namespace Candidat\Fee\Service;

class ClientPrivateRule{

    //Array save all clients history of transations in AllClients
    public static $AllClients = [];

    /**
    * *
    *@param id
    *@param amount
    *@param date
    *@param lastDate
    * *
    **/
    public function __construct($id , $amount , $date , $lastDate)
    {
       
           array_push(self::$AllClients , array(
                 "id"=>$id ,
                 "StartDateWithdraw"=> $date, 
                 "LastDateWithdraw"=> $lastDate,
                 "LastAmount"=>$amount,
                 "nbWithdraw"=>1
           ));     

    }
    public static function ClientWithdraw($id,$amount , $date): float
    {
   
           
            //initialization 
            $getClientWithdraw=NULL;

            foreach(self::$AllClients as $key=>$existClient){
               
                if($existClient["id"] == $id){
                    //"&" is for reference to the Array  $AllClients
                    $getClientWithdraw = &self::$AllClients[$key];
                   
                }
            }

            
            if($getClientWithdraw===NULL){
                //Create new Client Transcation Rule
                new ClientPrivateRule($id,$amount , $date , $date);
               
                //check only if amout exeed 1000
                if( $amount  > 1000){
                    $fee = ($amount-1000)*0.3/100;
                    return $fee;
                }
                else return 0;
            }
            
            
            //Client Already Exist so have to update infos of transaction
           
            //update date to be the last day of withdraw
            $getClientWithdraw["LastDateWithdraw"] = $date;

            //Check date within 7 days to return True otherwise return False
            $dateValid = self::checkDateRule($getClientWithdraw);

            

            
            //update number of transaction by this client
            //add amount to previous one
          
            //$dateValid == True means between first withdraw to this time is within 7 days
            if($dateValid == True){
               $getClientWithdraw["LastAmount"] += $amount;
               $getClientWithdraw["nbWithdraw"] += 1;
             
            }else{
               //$dateValid == False means between first withdraw to this time is more 7 days so need to init data in Client history
               $getClientWithdraw["LastAmount"] = $amount;
               $getClientWithdraw["nbWithdraw"] =1;
               $getClientWithdraw["StartDateWithdraw"] = $date;
               $getClientWithdraw["LastDateWithdraw"] = $date;
            
               
            }

          
            
            
            
            
            
            /*3 conditions to not apply fee
             
             1)3 times withdraw means $getClientWithdraw["nbWithdraw"] < 4
             2) the date must be valiadte ; $dateValid === True
             3) amount exeed 1000 commission is calculated only for the exceeded amount
            */
            if($getClientWithdraw["LastAmount"] > 1000){
                 
                if(($getClientWithdraw["LastAmount"] - $amount) > 1000)
                  $fee = $amount*0.3/100;
                else{
                    $fee = ($getClientWithdraw["LastAmount"] - 1000)*0.3/100;
                }  
                return $fee;
            }

 
            
            //Client exeed number of free widthdraw in one week
            if($getClientWithdraw["nbWithdraw"] < 4 ){
                return 0;
            }
          
    

            //Client exeed offer in 1 week or nbWithdraw is more than 3 times
            $fee = $amount*0.3/100;
            return $fee;
            
    
        
    }

    //this function compare date beween first date of Withdraw and last one
    public static function checkDateRule($getClientWithdraw): bool
    {
        
        $date2=date_create($getClientWithdraw["LastDateWithdraw"]);
        $date1=date_create($getClientWithdraw["StartDateWithdraw"]);
        
        $diff=date_diff($date2,$date1);
       
        //get days between the first withdraw to this time 
        $days =  $diff->format("%a");
     
        //in case more that week passed from the first withdraw 
        if($days > 7){
             return False;
        }

        //in case less than 1 week
        return True;
          
    }
 
}
