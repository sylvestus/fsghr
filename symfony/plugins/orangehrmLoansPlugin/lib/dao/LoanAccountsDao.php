<?php

class LoanAccountsDao extends BaseDao {

     public static function getLoanAccounts() {
        try {
            return OhrmLoanaccountsTable::getInstance()->findAll();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getMonthFromDate($monthyear){
        $date=DateTime::createFromFormat("d/m/Y",trim("01/".$monthyear));
     //  print_r($date);
       // $dt = DateTime::createFromFormat('!m', $date->format("m"));
return array("month"=>$date->format('F'),"year"=>$date->format("Y"));
    }
    
    
    
    //get emp loan accounts
     public static function getEmpLoanAccounts($empno) {

        try {
            return Doctrine_Query::create()->from('OhrmLoanaccounts')->where ("`emp_number`=$empno")
                    ->andWhere("`is_matured`=0")
                    ->andWhere("`is_disbursed`=1")->execute();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    
    public function getAccountById($id) {
        try {
             return Doctrine_Query::create()->from('OhrmLoanaccounts')->where("`id`=$id")->fetchOne();
            //return  OhrmLoanaccountsTable::getInstance()->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public static function getInterestAmount($loanaccountid){
    
$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);

		$principal = $loanaccount->getAmountDisbursed();

		$rate = $loanaccount->getInterestRate()/100;

		$time = $loanaccount->getPeriod();
$loanproductdao=new LoanProductsDao();
$loanproduct=$loanproductdao->getLoanProductById($loanaccount->getLoanproductId());
		$formula = $loanproduct->getFormula();

		if($formula == 'SL'){

			$interest_amount = $principal * $rate * $time;

		}

                if($formula == 'RB'){

			
    		
    		
   			
    		$interest_amount = 0;
              if($time==0){
                  $principal_pay=0;
              }else{
    		$principal_pay = $principal/$time;
            $monthlyRate = (($loanaccount->getInterestRate())/100);  // interest rate in per month already
                $principal = $loanaccount->getAmountDisbursed() + $loanaccount->getTopUpAmount();
                              $monthlyPayment = ($monthlyRate /(1-(pow((1+$monthlyRate),-($time)))))* $principal ;
                //$total_principal = 0;

            for($i=1; $i<=$time; $i++) { 
               $interest_amount += $principal* $monthlyRate;

  

          
		}
                
              }
                }




		return $interest_amount;
	}

        public static function getTotalDue($loanaccount){

		$balance = Loantransaction::getLoanBalance($loanaccount);

		if($balance > 1 ){

			$principal = Loantransaction::getPrincipalDue($loanaccount);
			$interest = Loantransaction::getInterestDue($loanaccount);

			$total = $principal + $interest;

			return $total;
		}else {

			return 0;
		}

		
	}

        public static function updateRepaymentCounter($accountid,$direction="+"){
         
        $loanaccountsdao=new LoanAccountsDao();
            $account=$loanaccountsdao->getAccountById($accountid);
            $count=$account->getRepaymentCounter();
            if($count > 0 && $direction=="-"){
               
                $account->setRepaymentCounter($count-1);
            }
            else if($direction=="+"){
            $account->setRepaymentCounter($count+1);
            }
            else{
                //do nothing
            }
            $account->save();
            
            
        }
        
        public static function getInterestForMonth($loanaccountid,$monthyear){
           if($loanaccountid){
        $repaidloanbeformonth= LoanTransactionsDao::getRepaymentsBeforeMonth($loanaccountid, $monthyear);
       
          $loanaccountsdao=new LoanAccountsDao();
            $account=$loanaccountsdao->getAccountById($loanaccountid);
            $loan=$account->getAmountDisbursed()-$repaidloanbeformonth; //if loan has been settled on that month what happens

          $date=  DateTime::createFromFormat("m-Y",$monthyear);
          $repaydate=DateTime::createFromFormat("Y-m-d",$account->getRepaymentStartDate());
  $repaydates=$repaydate->format("m").$repaydate->format("Y");
    $dates=$date->format("m").$date->format("Y");
    //also take care of loans that have been settled directly
           if(OrganizationDao::isDateLesserOrEqualTo($repaydates, $dates)){
            $interest=round(($account->getInterestRate()/100)*$loan);

           }
           else{
               $interest=0;
           }
       if($interest){
        return (int)($interest);
       }
       else{
           return 0;
       }
           }
           else{
               return 0;
           }
        
            
        }
        

	public static function getDurationAmount($loanaccount){

		$interest = self::getInterestAmount($loanaccount);
		$principal = $loanaccount->getAmountDisbursed();

		$total =$principal + $interest;

		if($loanaccount->repayment_duration != null){

			$amount = $total/$loanaccount->repayment_duration;
		} else {

			$amount = $total/$loanaccount->period;

		}

		return $amount;

		
	}

        public function getLoanAccountNumber(){
            return "SHIL".rand(1000,100000);
        }

	public static function getLoanAmount($loanaccountid){
            $amount=0;
$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);

		$interest_amount = self::getInterestAmount($loanaccountid);
            
		$principal = $loanaccount->getAmountDisbursed();
		$topup = $loanaccount->getTopUpAmount();

                //$amount = $principal + $interest_amount + $topup;
		$amount = $principal + $topup;

        
		return $amount;
	}

//monthly principles
//	public static function getEMP($loanaccountid){
// 
//$loanaccountdao=  new LoanAccountsDao();
//$loanaccountt=  $loanaccountdao->getAccountById($loanaccountid);
//
//		$loanamount = LoanAccountsDao::getLoanAmount($loanaccountid);
//                
//                $loanproductdao= new LoanProductsDao();
//                $loanproduct=$loanproductdao->getLoanProductById($loanaccountt->getLoanproductId());
//
//		if($loanaccountt->getRepaymentDuration() > 0){
//			$period = $loanaccountt->getRepaymentDuration();
//                     
//		}
//		else {
//
//			$period = $loanaccountt->getPeriod();
//		}
//               $loanaccountnew=$loanaccountdao->getAccountById($loanaccountid);
//           
//   
//		if($loanproduct->getAmortization()== 'CP'){
//                  
//
//			if($loanproduct->getFormula() == 'RB'){
//
//				$principal = $loanaccountnew->getAmountDisbursed() + $loanaccountnew->getTopUpAmount();
//
//				$principal1 = $principal/$period;
//         
//				$interest = (LoanTransactionsDao::getLoanBalance($loanaccountid) * ($loanproduct->getRate()/100));
//
//				$mp = $principal1 + $interest;
//                              
//
//			}
//
//			if($loanproduct->getFormula() == 'SL'){
//                            
//				 $mp = $loanamount/$period;
//			}
//				
//	
//		}
//
//		else if($loanproduct->getAmortization() == 'EI'){
//
//			$mp = $loanamount / $loanaccountnew->getRepaymentDuration();
//			
//		}
//else if($loanproduct->getAmortization() == 'EP'){
//
//			$mp = $loanamount / $loanaccountnew->getRepaymentDuration();
//			
//		}
//		
//
//		return $mp;
//	}

        public static function getEmp($loanaccountid,$yearmonth){
        $loanaccountdao=  new LoanAccountsDao();
$loanaccountt=  $loanaccountdao->getAccountById($loanaccountid);  
$mp=OhrmLoanrepaymentScheduleTable::getMonthPrinciple($loanaccountt,$yearmonth);
if(is_object($mp)){
    return $mp->mp;
}
else{
    return 0;
}
        }
        
        
        
    public function deleteAccount($id) {
        try {
             $deletequery=  OhrmLoanaccountsTable::getInstance()
  ->createQuery()
  ->delete()
  ->where(" `id`=$id")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public static function getLoanBalance($loanaccount){
        $paymentss= Doctrine_Query::create()->select('sum(amount)')->from ('OhrmLoantransactions')->where ('loanaccount_id= ?',$loanaccount)->andWhere('type= ?','credit');
		$result=$paymentss->execute(array(),  Doctrine::HYDRATE_SCALAR);
$payments=$result[0]['OhrmLoanrepayments_sum'];	

		$loanamount = LoanAccountsDao::getLoanAmount($loanaccount);
		$balance = $loanamount - $payments;
		return $balance;
	}

    public function getChargeTreeObject() {
        try {
            return  OhrmLoanaccountsTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
