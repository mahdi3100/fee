<?php



namespace Candidat\Fee\Service;

class InfoTransaction{

protected $date;
protected $id;
protected $typeTran;
protected $operationTran;
protected $amount;
protected $cur;

/** 
*@param oneTransaction 
**/
public function __construct(Array $oneTransaction){
   
    $this->setDate($oneTransaction[0]);
    $this->setId($oneTransaction[1]);
    $this->setTypeTran($oneTransaction[2]);
    $this->setOperationTran($oneTransaction[3]);
    $this->setCur($oneTransaction[5]); 
    $this->setAmount($oneTransaction[4]);
      

}

private function setDate(String $date): void
{
    

       $getParsedDate = date_parse($date);

       if($getParsedDate["error_count"]!==0){
        throw new \Exception("Date is not valid");
       }
       $this->date = $date;
}
private function setId(String $id): void
{
      
       if(gettype((int) $id)!== "integer"){
        throw new \Exception("Id is not valid");
       }
       $this->id = (int) $id;
}
private function setTypeTran(String $type): void
{
      
       if($type != "private" AND $type != "business"){
        throw new \Exception("type of transaction is not valid");
       }
       $this->typeTran = $type;
}
private function setOperationTran(String $operation): void
{
      
       if($operation != "withdraw" AND $operation != "deposit"){
        throw new \Exception("operation of transaction is not valid");
       }
       $this->operationTran = $operation;
}
private function setCur(String $cur): void
{

       $cur = strtoupper($cur);
       $this->cur = $cur;
}
private function setAmount($amount): void
{
      
       if(gettype((float) $amount) !== "double"){
        throw new \Exception("Amount of transaction is not valid");
       }
       // echo "amount is {$amount}";
       $this->amount = $amount;
       
       
}



}

/**
 * Child class of InfoTransaction
 */
class CalculeTransaction extends InfoTransaction{

/**
 * startCalcul is the main class of  CalculeTransaction
 */       
public function startCalcul(): void
{
 
   //got $operationTran from parent class which got it from reading CSV per line
   
   //deposit
   if($this->operationTran == "deposit"){

      $this->FeeDeposite();
      
    }else
    //Withdraw
    {
        
        $this->FeeWithdraw();
    }
}

//Calculate fee deposite
private function FeeDeposite()
{
$fee = $this->amount*0.03/100;
$fee = ceil($fee*100)/100;
$this->showFee($fee);
}

//Calculate fee Withdraw
private function FeeWithdraw()
{

    //Private Account 
   if($this->typeTran == "private"){

       //convert to EURO Currency 
       if($this->cur != "EUR"){

              $this->amount = Currencies::convertToEUR((float)$this->amount ,  $this->cur);
              
        }
    //class to treat Rules of private clients 
    $getFee = ClientPrivateRule::ClientWithdraw($this->id , $this->amount , $this->date);
 
    //convert fee to Main Currency
      if($this->cur != "EUR"){
         $getFee = Currencies::convertToMainCurr($getFee , $this->cur);
       }

    //ceil up the value
    $getFee = ceil(round($getFee,2)*10)/10;

    $this->showFee($getFee);
   }
   //Businss Account 
   else{  
    $fee = $this->amount*0.5/100;
    $fee = ceil(round($fee,2)*10)/10;
    $this->showFee($fee);
   }

}
/**
 *@param fee
 */
public function showFee(float $fee):void
{
//show fee in format 0.00      
echo number_format($fee,2)."\n";
}



} 

