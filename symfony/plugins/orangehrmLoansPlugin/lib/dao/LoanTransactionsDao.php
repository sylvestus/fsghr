<?php
class LoanTransactionsDao extends BaseDao {

    public function getTransactionById($id) {
      
        try {
            return Doctrine::getTable('OhrmLoantransactions')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }


public static function getLoanBalance($loanaccount){
$paymentss= Doctrine_Query::create()->select('sum(amount)')->from ('OhrmLoantransactions')->where ('loanaccount_id= ?',$loanaccount)->andWhere('type= ?','credit');
	$result=$paymentss->execute(array(),  Doctrine::HYDRATE_SCALAR);
  
$payments=$result[0]['OhrmLoantransactions_sum'];	

		$loanamount = LoanAccountsDao::getLoanAmount($loanaccount);
               		$balance = $loanamount - $payments;
              
		return $balance;
	}


	public static function getRemainingPeriod($loanaccountid){
$paid_periods=Doctrine_Query::create()->from('OhrmLoantransactions')->where ('loanaccount_id= ?',$loanaccountid)->andWhere('description= ?','loan_repayment')->count();
		//$paid_periods = DB::table('loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->where('description', '=', 'loan repayment')->count();
$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);
		$remaining_period = $loanaccount->getPeriod() - $paid_periods;

		return $remaining_period;
	}


	public static function getPrincipalDue($loanaccountid){
$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);

		$remaining_period = self::getRemainingPeriod($loanaccountid);

		$principal_paid = OhrmLoanrepayments::getPrincipalPaid($loanaccountid);

		$principal_balance = $loanaccount->getAmountDisbursed() - $principal_paid;
                $loanproductdao=new LoanProductsDao();
                $loanproduct=$loanproductdao->getLoanProductById($loanaccount->getLoanproductId());

		if($loanproduct->getFormula() == 'RB'){

			$principal_due = $principal_balance / $remaining_period;	

		}



		// get principal due on Straight Line
		if($loanproduct->getFormula() == 'SL'){


			$principal_due = $principal_balance / $remaining_period;


		}


		return $principal_due;

	}
public static function getPrincipalBalance($loanaccountid){
$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);

		$remaining_period = self::getRemainingPeriod($loanaccountid);

		$principal_paid = OhrmLoanrepayments::getPrincipalPaid($loanaccountid);

		$principal_balance = $loanaccount->getAmountDisbursed() - $principal_paid;
               

		

		return $principal_balance;

	}



	public static function getInterestDue($loanaccountid){

$loanaccountdao=  new LoanAccountsDao();
$loanaccount=$loanaccountdao->getAccountById($loanaccountid);
		$remaining_period = LoanTransactionsDao::getRemainingPeriod($loanaccountid);

		$principal_paid = OhrmLoanrepayments::getPrincipalPaid($loanaccountid);

		$principal_balance = $loanaccount->getAmountDisbursed() - $principal_paid;

$loanproductdao=new LoanProductsDao();
$loanproduct=$loanproductdao->getLoanProductById($loanaccount->getLoanproductId());
		if($loanproduct->getFormula()== 'RB'){

			$interest_due = ($principal_balance * ($loanaccount->getInterestRate()/100));	

		}



		// get principal due on Straight Line
		else if($loanproduct->getFormula()== 'SL'){

			$interest_amount = LoanAccountsDao::getInterestAmount($loanaccount);

			$interest_paid = OhrmLoanrepayments::getInterestPaid($loanaccount);

			$interest_balance = $interest_amount - $interest_paid;


			$interest_due = $interest_balance / $remaining_period;


		}


		return $interest_due;



	}


	public static function repayLoan($loanaccountid, $amount, $date,$issettlement=0){

		$transaction = new OhrmLoantransactions();
                $transaction->setLoanaccountId($loanaccountid);
		$transaction->setDate($date);
		$transaction->setDescription('loan repayment');
		$transaction->setAmount($amount);
		$transaction->setType('credit');
                $transaction->setPaymentMode("cash");
                $transaction->setIssettlement($issettlement);
                      $transaction->setCreatedAt(date("Y-m-d H:i:s"));
                $transaction->setUpdatedAt(date("Y-m-d H:i:s"));
		$transaction->save();


	}
        
        
        public static function repayLoanInterest($loanaccountid, $amount, $date,$issettlement=0){

		$transaction = new OhrmLoantransactions();
                $transaction->setLoanaccountId($loanaccountid);
		$transaction->setDate($date);
		$transaction->setDescription('loan repayment interest');
		$transaction->setAmount($amount);
		$transaction->setType('credit');
                $transaction->setPaymentMode("cash");
                $transaction->setIssettlement($issettlement);
                      $transaction->setCreatedAt(date("Y-m-d H:i:s"));
                $transaction->setUpdatedAt(date("Y-m-d H:i:s"));
		$transaction->save();


	}
        
        public function deleteLoanForMonth($repaydate){
             
            $q = Doctrine_Query::create()->delete('OhrmLoantransactions')
                                         ->where('date = ?', "$repaydate")
                                           ->andWhere('type = ?',"credit");
            $q->execute();
	}
        
        public static function  getRepaymentsBeforeMonth($loanaccount,$monthyear){
            $amount=0;
        $paymentss= Doctrine_Query::create()->select('*')->from ('OhrmLoantransactions')->where ('`loanaccount_id`='.$loanaccount)->andWhere('`type` = "credit"')
	->execute();
      $date=  DateTime::createFromFormat("m-Y",$monthyear);
      
foreach ($paymentss as $payment) {
  
     $repaydate=DateTime::createFromFormat("Y-m-d",$payment["date"]);  
 $repaydates=$repaydate->format("m").$repaydate->format("Y");
    $dates=$date->format("m").$date->format("Y");
        if(OrganizationDao::isDateGreater($dates, $repaydates) || ( OrganizationDao::isDateEqualTo($dates, $repaydates)  && $payment["issettlement"]==1)) //take care of loans that have been settled directly
            {
        $amount+=$payment['amount'];
    }
    
}
        

return $amount;
     }
     
     public static function  getRepaymentsForMonth($loanaccount,$monthyear){
      $amount=0;
        $paymentss= Doctrine_Query::create()->select('*')->from ('OhrmLoantransactions')->where ('loanaccount_id= ?',$loanaccount)->andWhere('`type` = "credit"')
	->execute();
 $date=  DateTime::createFromFormat("m-Y",$monthyear);
     
foreach ($paymentss as $payment) {

    $repaydate=DateTime::createFromFormat("Y-m-d",$payment["date"]);  
 
    $dates=$date->format("m").$date->format("Y");
     
    $repaydates=$repaydate->format("m").$repaydate->format("Y");
   
    if(OrganizationDao::isDateEqualTo($dates, $repaydates)){
        $amount+=$payment['amount'];
    }
    
}
  

return $amount;
     }



	public static function disburseLoan($loanaccount, $amount, $date,$paymentparams){
           
		$transaction = new OhrmLoantransactions();

		$transaction->setLoanaccountId($loanaccount->getId());
		$transaction->setDate($date);
		$transaction->setDescription('loan disbursement');
		$transaction-> setAmount($amount);
		$transaction->setType('debit');
                $transaction->setPaymentMode($paymentparams["payment_mode"]);
                if($paymentparams["payment_mode"]=="cheque"){
                    $transaction->setChequeDate($paymentparams["cheque_date"]);
                    $transaction->setChequeNo($paymentparams["chequeno"]);
                    $transaction->setChequeDetails($paymentparams["cheque_details"]);
                }
                $transaction->setCreatedAt(date("Y-m-d H:i:s"));
                $transaction->setUpdatedAt(date("Y-m-d H:i:s"));
		$transaction->save();
 
                                $loanposting=new LoanPostingDao();
                              
                               $account=$loanposting->getPostingAccount($loanaccount->getLoanproductId(),'disbursal');
		
		$data = array(
			'credit_account' =>$account['credit'] , 
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $loanaccount->getAmountDisbursed(),
			'initiated_by' => 'system',
			'description' => 'loan disbursement'

			);


//		$journal = new OhrmJournals();
//
//
//		$journal->journal_entry($data);


	}
}