<?php
class LoanPostingDao extends BaseDao {

    public function getLoanPostingById($id) {
        
        try {
            return OhrmLoanpostingsTable::getInstance()->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

public function disbursal($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'disbursal';
		$posting->debit_account = array_get($data, 'portfolio_account');
		$posting->credit_account = array_get($data, 'cash_account');
		$posting->save();

	}



public function principal_repayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'principal_repayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'portfolio_account');
		$posting->save();

	}




public function interest_repayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'interest_repayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_interest');
		$posting->save();

	}



public function loan_write_off($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'loan_write_off';
		$posting->debit_account = array_get($data, 'loan_write_off');
		$posting->credit_account = array_get($data, 'portfolio_account');
		$posting->save();

	}



public function fee_payment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'fee_payment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_fees');
		$posting->save();

	}



public function penalty_payment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'penalty_payment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_penalty');
		$posting->save();

	}



public function loan_overpayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'loan_overpayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_overpayment');
		$posting->save();

	}



public function overpayment_refund($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'overpayment_refund';
		$posting->debit_account = array_get($data, 'loan_overpayment');
		$posting->credit_account = array_get($data, 'cash_account');
		$posting->save();

	}



public static function getPostingAccount($loanproduct, $transaction){
    
$postings=OhrmLoanpostingsTable::getInstance()->createQuery('a')->where('a.loanproduct_id= ?',$loanproduct)->andWhere('a.transaction= ?',$transaction)->execute();


		foreach ($postings as $posting) {
			
			$credit_account = $posting->getCreditAccount();
			$debit_account = $posting->getDebitAccount();
		}
		

		$accounts = array('debit'=>$debit_account, 'credit'=>$credit_account);

		return $accounts;
				
			
	}




}