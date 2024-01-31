<?php

class loansActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        
        
    }
    
       public function executeLoanproducts(sfWebRequest $request) {
           $this->loanproducts=LoanProductsDao::getLoanProducts();
           
    }
    
    public function executeMembers(sfWebRequest $request){
    $employeedao=new EmployeeDao();
     $empNumber = $request->getParameter('empNumber');
        $isPaging = $request->getParameter('hdnAction') == 'search' ? 1 : $request->getParameter('pageNo', 1);

        $pageNumber = $isPaging;
     $noOfRecords = sfConfig::get('app_items_per_page');

        $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;

      

        $this->form = new EmployeeSearchForm($this->getFilters());
        if ($request->isMethod('post')) {
$post=$request->getPostParameters();

if($post["hdnAction"]=="reset"){ //if reset
    $this->form = new EmployeeSearchForm();
      $this->employees=EmployeeDao::getEmployees();
}
else{
$searchparams=$post["empsearch"];

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                
                if($this->form->getValue('isSubmitted')=='yes'){
                    $employeedao=new EmployeeDao();
                    if($searchparams["employee_name"]["empId"]){
                        $empNumber=$searchparams["employee_name"]["empId"];
                
            $this->employees=  array(EmployeeDao::getEmployeeByNumber($empNumber)) ;
       
                    } 
                    //search by department
                    elseif ($searchparams["sub_unit"] && !$searchparams["employee_name"]["empId"]) {
                        $dept=$searchparams["sub_unit"];
                        $empdao=new EmployeeDao();
                      $this->employees=$empdao->getEmployeesByDepartment($dept);
                }
                //search by location
                elseif ($searchparams["location"] && !$searchparams["employee_name"]["empId"]) {
                        $location=$searchparams["location"];
                        $empdao=new EmployeeDao();
                      $this->employees=$empdao->getEmployeesByBranch($location);
                }
                  
                    
                    
                }         
                
                $this->setFilters($this->form->getValues());
                
            } else {
                $this->setFilters(array());
            }

            $this->setPage(1);
        }
        }
        if ($request->isMethod('get')) {
            $sortParam = array("field"=>$request->getParameter('sortField'), 
                               "order"=>$request->getParameter('sortOrder'));
            $this->setSortParameter($sortParam);
            $this->setPage(1);
              $this->employees=EmployeeDao::getEmployees();
        }
        
  
 
        
    }
    
      public function executeAddLoanProduct(sfWebRequest $request) {
     
             $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanProductForm(array(), $optionsForForm, true));
         
               if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addLoanProductPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
                    $loanproduct=new OhrmLoanproducts();
                    $name= $this->form->getValue('name');
                    $shortname = $this->form->getValue('short_name');
                    $formula = $this->form->getValue('formula');
                    $interest_rate = $this->form->getValue('interest_rate');
                    $amortization = $this->form->getValue('amortization');
             $loanproduct->setName($name);
             $loanproduct->setShortName($shortname);
             $loanproduct->setFormula($formula);
             $loanproduct->setCreatedAt(date("Y-m-d H:i:s"));
             $loanproduct->setUpdatedAt(date("Y-m-d H:i:s"));
             $loanproduct->setMemberGroup(1);
             $loanproduct->setInterestRate($interest_rate);
             $loanproduct->setAmortization($amortization);
              $result =$loanproduct->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved loan product'));
                        $this->redirect('loans/loancharges');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
   }   
     public function executeAddLoanCharge(sfWebRequest $request) {
 
             $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanChargeForm(array(), $optionsForForm, true));
         
               if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addLoanProductPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
                    $loanproduct=new OhrmLoanCharges();
                    $name= $this->form->getValue('name');
                    $category = $this->form->getValue('category');
                    $calculationmethod = $this->form->getValue('calculation_method');
                    $percentageof= $this->form->getValue('percentage_of');
                    $amount = $this->form->getValue('amount');
                    $fee=$this->form->getValue('fee');
             $loanproduct->setName($name);
             $loanproduct->setCategory($category);
             $loanproduct->setCalculationMethod($calculationmethod);
             $loanproduct->setPercentageOf($percentageof);
             $loanproduct->setAmount($amount);
             $loanproduct->setFee($fee);
              $result =$loanproduct->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved loan charge'));
                        $this->redirect('loans/loancharges');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
   }
    
   //update Loan charge
     public function executeUpdateLoanCharge(sfWebRequest $request) {
 
          
         
               if($request->isMethod('post')) {
                      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanChargeForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addLoanProductPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
        $id=$request->getParameter('id');
                    $loanproductdao=new LoanChargesDao();
                   $loanproduct=$loanproductdao->getChargeById($id);
                    $name= $this->form->getValue('name');
                    $category = $this->form->getValue('category');
                    $calculationmethod = $this->form->getValue('calculation_method');
                    $percentageof= $this->form->getValue('percentage_of');
                    $amount = $this->form->getValue('amount');
                    $fee=$this->form->getValue('fee');
         
             $loanproduct->setName($name);
             $loanproduct->setCategory($category);
             $loanproduct->setCalculationMethod($calculationmethod);
             $loanproduct->setPercentageOf($percentageof);
             $loanproduct->setAmount($amount);
             $loanproduct->setFee($fee);
              $result =$loanproduct->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved loan charge'));
                        $this->redirect('loans/loancharges');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
             else {
       $id=$request->getParameter('id');
       $loanproductdao=new LoanChargesDao();
    $loanproduct=$loanproductdao->getChargeById($id);
  //die(print_r($loanproduct->getAmount()));
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             $loanchargesform=new LoanChargeForm();
             $loanchargesform->setDefault("amount", $loanproduct->getAmount());
              $this->setForm(new LoanChargeForm(array('name'=>$loanproduct->getName(),'category'=>$loanproduct->getCategory(),'calculation_method'=>$loanproduct->getCalculationMethod(),'percentage_of'=>$loanproduct->getPercentageOf(),'amount'=>$loanproduct->getAmount(),'fee'=>$loanproduct->getFee()), $optionsForForm, true));
 }
   }
   
   
    public function executeLoancharges(sfWebRequest $request) {
         $this->pager = new sfDoctrinePager('OhrmLoanCharges', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanCharges')->createQuery('a'));
        
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   // $this->charges=  LoanChargesDao::getLoanCharges();
    }
  
    //delete
       public function executeDeleteLoanCharge(sfWebRequest $request){
       $id=$request->getParameter('id');
    $loanchargesdao=  new LoanChargesDao();
   if( $loanchargesdao->deleteCharge($id)){
        $this->getUser()->setFlash('success', __('Successfully deleted charge item'));
   }
   else{
        $this->getUser()->setFlash('error', __('Could not delete charge'));
   }
 
    $this->redirect('loans/loancharges');
   }
    
   //apply loan
   public function executeApply(sfWebRequest $request){
              $memberid=$request->getParameter('id');
            
//              $paid=$this->checkUnpaidLoansMember($memberid);
//              if($paid==FALSE){
//                    $this->getUser()->setFlash('error', __('Member has existing unpaid loan'));
//                        $this->redirect('loans/members');
//              }
//         
               if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
            $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($memberid);
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanApplicationForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
            //    unset($postArray['_csrf_token']);
                $_SESSION['addLoanApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
  
                    $loanaccounts=new OhrmLoanaccounts();
                    $loanproduct= new LoanProductsDao();
                    $product=$loanproduct->getLoanProductById($this->form->getValue('loanproduct_id'));
                    $loanaccounts->setEmpNumber($this->form->getValue('member_id'));
                 $loanaccounts->setLoanproductId($this->form->getValue('loanproduct_id'));
                 $loanaccounts->setInterestRate($product->getInterestRate());
                  $loanaccounts->setApplicationDate(date("Y-m-d",  strtotime($this->form->getValue('application_date'))));
                     $loanaccounts->setReasonApplied($this->form->getValue('reason_applied'));
                    
                   $loanaccounts->setAmountApplied($this->form->getValue('amount_applied'));
                   $loanaccounts->setPeriod($this->form->getValue('repayment_duration')); //same as repayment duration
                   $loanaccounts->setCreatedAt(date("Y-m-d H:i:s"));
                   $loanaccounts->setUpdatedAt(date("Y-m-d H:i:s"));
                   $loanaccounts->setRepaymentDuration($this->form->getValue('repayment_duration'));
                   
        
              $result =$loanaccounts->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully applied for loan'));
                        $this->redirect('loans/newapplications');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$memberid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($memberid);
              $this->setForm(new LoanApplicationForm(array('member_id'=>$memberid,"application_date"=>date("Y-m-d")), $optionsForForm, true));
 }
   }
   
   
   //new applications
   public function executeNewapplications(sfWebRequest $request){
       LoanAccountsDao::getLoanAccounts();
        $this->pager = new sfDoctrinePager('OhrmLoanaccounts', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanaccounts')->createQuery('a')->where('a.is_new_application = ?',1)->orderBy('a.application_date ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }

   //approve applications
   public function executeApprove(sfWebRequest $request){
            $loanacctid=$request->getParameter('id');
            if(!is_int(intval($loanacctid))){
               $this->getUser()->setFlash('error', __('Invalid account details'));
                          $this->redirect('loans/newapplications');    
            }
            $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
            $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
               if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                    $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanApprovalForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
            //    unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
  
            $loanaccount->setIsNewApplication(0);
            $loanaccount->setIsApproved(1);
            $loanaccount->setPeriod($this->form->getValue('period'));
            $loanaccount->setDateApproved(date("Y-m-d",  strtotime($this->form->getValue('approval_date'))));
             $loanaccount->setAmountApproved($this->form->getValue('amount_approved'));
            $loanaccount->save();
            
       $this->getUser()->setFlash('success', __('Successfully approved loan'));
                        $this->redirect('loans/approvedapplications');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$loanacctid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
                $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
             $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
              $this->setForm(new LoanApprovalForm(array('amount_approved'=>$loanaccount->getAmountApplied(),"interest_rate"=>$loanaccount->getInterestRate(),'period'=>$loanaccount->getRepaymentDuration(),"approval_date"=>date("Y-m-d")), $optionsForForm, true));
 }
   }
    public function executeAmmend(sfWebRequest $request){
       $this->getUser()->setFlash('error', __('Cannot ammend applications for now,please contact your administrator'));
                          $this->redirect('loans/newapplications'); 
    }
   
    public function executeReject(sfWebRequest $request){
     $loanacctid=$request->getParameter('id');

            if(!is_int(intval($loanacctid))){
               $this->getUser()->setFlash('error', __('Invalid account details'));
                          $this->redirect('loans/newapplications');    
            }
            $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
            $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
               if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                    $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanRejectionForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
    unset($postArray['_csrf_token']);
                
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
  
            $loanaccount->setIsNewApplication(0);
            $loanaccount->setIsApproved(0);
            $loanaccount->setIsRejected(1);
            $loanaccount->setRejectionReason($this->form->getValue('reason_rejected'));
  $loanaccount->setUpdatedAt(date("Y-m-d H:i:s"));
            $loanaccount->save();
            
       $this->getUser()->setFlash('warning', __('Loan application has been rejected because '.$this->form->getValue('reason_rejected')));
                        $this->redirect('loans/rejectedapplications');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$loanacctid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
                $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
             $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
              $this->setForm(new LoanRejectionForm(array(), $optionsForForm, true));
    }
    }

   //approved applications
    public function executeApprovedapplications(sfWebRequest $request){
       LoanAccountsDao::getLoanAccounts();
        $this->pager = new sfDoctrinePager('OhrmLoanaccounts', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanaccounts')->createQuery('a')->where('a.is_approved = ?',1)->andWhere('a.is_disbursed = ?',0)->orderBy('a.application_date ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }

   
   //rejected
   public function executeRejectedapplications(sfWebRequest $request){
       LoanAccountsDao::getLoanAccounts();
        $this->pager = new sfDoctrinePager('OhrmLoanaccounts', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanaccounts')->createQuery('a')->where('a.is_rejected= ?',1)->andWhere('a.is_disbursed = ?',0)->orderBy('a.application_date ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }

   
   public function executeTopup($request) {
     $loanacctid=$_REQUEST['id'];
       $amount=$_REQUEST['amount'];
            $interest=$_REQUEST['interest'];
             
       $loanaccountdao=new LoanAccountsDao();
      $loanaccount=$loanaccountdao->getAccountById($loanacctid);
         $loantransactiondao=new LoanTransactionsDao();
            
             $loanbalance= $loantransactiondao->getLoanBalance($loanaccount["id"]);
            $earlieramount=$loanaccount->getAmountDisbursed();
           if($amount){
//               echo $amount ." ".$loanbalance;
//            if($amount < $loanbalance){
            $loanaccount->setIsNewApplication(0);
           
            $loanaccount->setIsDisbursed(1);
          $loanaccount->setAccountNumber($loanaccountdao->getLoanAccountNumber());
     
     $newamount=$amount;
     $increase=$newamount-$earlieramount;
     //get old monthly principle
     $mp=round($loanaccount->getAmountDisbursed()/$loanaccount->getRepaymentDuration());
     $newperiod=$amount/$mp;
     
         $loanaccount->setAmountDisbursed($amount); //eg=10000
              $loanaccount->setPeriod($newperiod);
              $loanaccount->setRepaymentDuration($newperiod);
                $loanaccount->setPaymentMode("CASH");
            $loanaccount->save();
           
            //delete loan repayment schedule and create a new one
            OhrmLoanrepaymentScheduleTable::deleteSchedule($loanacctid);
            
            $this->createSchedule($loanacctid);
  
            
                echo json_encode( array("message"=>"loan topped up successfully to ".$amount));
           exit();
               
            
        $loantransactiondao=new LoanTransactionsDao();
    
          $paymentparams=array("payment_mode"=>"CASH","cheque_date"=>"","chequeno"=>"","cheque_details"=>"");
                $loantransactiondao->disburseLoan($loanaccount, $increase,date("Y-m-d"),$paymentparams);
          //  }
//            else{
//                  echo json_encode( array("message"=>"Top up must be greater than loan balance"));
//           exit();
//             
//            }
            }
            else if($interest){
           $loanaccount->setInterestRate($interest);
            $loanaccount->save();
           
          echo json_encode( array("message"=>"interest rate updated"));
           exit();
           }
            
	exit();	        
   }
   
   //ewrse
      public function executeDisburse(sfWebRequest $request){
            $loanacctid=$request->getParameter('id');
            $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
            $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
               if($request->isMethod('post')) {
                            
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                    $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanDisbursementForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
                $loandisbursalparams=$postArray["loandisbursal"];
            //    unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
  
            $loanaccount->setIsNewApplication(0);
           
            $loanaccount->setIsDisbursed(1);
          $loanaccount->setAccountNumber($loanaccountdao->getLoanAccountNumber());
            $loanaccount->setDateDisbursed(date("Y-m-d",  strtotime($this->form->getValue('disbursal_date'))));
             $loanaccount->setAmountDisbursed($this->form->getValue('amount_disbursed'));
              $loanaccount->setRepaymentStartDate($this->form->getValue('repayment_start'));
                $loanaccount->setPaymentMode($this->form->getValue('payment_mode'));
            $loanaccount->save();
  
            $amount = $this->form->getValue('amount_disbursed');
            //get loan amount after calculating interest
         
            $loanamount = $amount +$loanaccountdao->getInterestAmount($loanaccount);
       
            $loantransactiondao=new LoanTransactionsDao();
    
          $paymentparams=array("payment_mode"=>$loandisbursalparams["payment_mode"],"cheque_date"=>$loandisbursalparams["cheque_date"],"chequeno"=>$loandisbursalparams["cheque_no"],"cheque_details"=>$loandisbursalparams["cheque_details"]);
                $loantransactiondao->disburseLoan($loanaccount, $loanamount,$this->form->getValue('disbursal_date'),$paymentparams);
                //create loan schedule
                $this->createSchedule($loanacctid); 
             
       $this->getUser()->setFlash('success', __('Successfully disbursed loan'));
                        $this->redirect('loans/disbursedapplications');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$loanacctid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
                $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
            $this->loanaccount=$loanaccount;
             $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
              $this->setForm(new LoanDisbursementForm(array('amount_disbursed'=>$loanaccount->getAmountApplied(),"repayment_start"=>date("28-m-Y"),"'disbursal_date"=>date("28-m-Y")), $optionsForForm, true));
 }
   }


//disbursed applications
    public function executeDisbursedapplications(sfWebRequest $request){
       LoanAccountsDao::getLoanAccounts();
        $this->pager = new sfDoctrinePager('OhrmLoanaccounts', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanaccounts')->createQuery('a')->where('a.is_disbursed= ?',1)->andWhere('(a.amount_disbursed)>1')->orderBy('a.date_disbursed DESC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }
   
   //loan transactions
    public function executeLoanTransactions(sfWebRequest $request){
        $startdate=$request->getParameter('startdate');
        $enddate=$request->getParameter('enddate');
     
        $this->pager = new sfDoctrinePager('OhrmLoantransactions', sfConfig::get('app_max_jobs_on_homepage'));
          if(isset($startdate) && isset($enddate)){
            
       $this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->where(" a.date BETWEEN '$startdate' AND '$enddate' ")->orderBy('a.date DESC'));    
       }  else{
           
           //$this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->where('DATE_FORMAT(a.date,"%Y")= ?',date("Y"))->orderBy('a.date DESC'));
           $this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->orderBy('a.date DESC'));
       }    
        
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }
   
   //loan deductions for month
   public function executeMonthlyLoanDeductions(sfWebRequest $request){
      
        $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $monthyear=$payrollmonth->getPayrollmonth();


     
        $this->pager = new sfDoctrinePager('OhrmLoantransactions', sfConfig::get('app_max_jobs_on_homepage'));
          if(isset($monthyear)){
            
       $this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->where(" DATE_FORMAT(a.date,'%m/%Y') like '%$monthyear%' AND a.type like '%credit%' AND description like '%loan repayment%' and issettlement=0 ")->orderBy('a.date DESC'));    
       }  else{
           
           //$this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->where('DATE_FORMAT(a.date,"%Y")= ?',date("Y"))->orderBy('a.date DESC'));
           $this->pager->setQuery(Doctrine::getTable('OhrmLoantransactions')->createQuery('a')->orderBy('a.date DESC'));
       }    
        
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }

//view loan
   
   public function executeViewloan(sfWebRequest $request){
        $loanacctid=$request->getParameter('id');
        $loanaccountdao=new LoanAccountsDao();
        $loantransactiondao=new LoanTransactionsDao();
        $this->loanaccount=$loanaccountdao->getAccountById($loanacctid);
        $this->interest=$loanaccountdao->getInterestAmount($this->loanaccount->getId());
        $this->loanbalance= $loantransactiondao->getLoanBalance($this->loanaccount->getId());
	//$this->principle_paid=$loa
        $this->principal_paid =OhrmLoanrepayments::getPrincipalPaid($this->loanaccount->getId());
        $this->interest_paid = OhrmLoanrepayments::getInterestPaid($this->loanaccount->getId());
	 $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($this->loanaccount->getEmpNumber());	
       
   }
   
   //repay loan
 public function executeRepayloan(sfWebRequest $request)
	{
$loanacctid=$request->getParameter('id');

$loanaccountdao=new LoanAccountsDao();
		$loanaccount =  $loanaccountdao->getAccountById($loanacctid);
                              $this->loanaccount=$loanaccount;
                              $loanbalance=LoanTransactionsDao::getLoanBalance($loanacctid);
		$this->loanbalance = $loanbalance;

		$this->principal_due = LoanTransactionsDao::getPrincipalDue($loanacctid);

		$this->interest = LoanAccountsDao::getInterestAmount($loanacctid);

		$this->interest_due = LoanTransactionsDao::getInterestDue($loanacctid);
                  $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($loanaccount->getEmpNumber());
                //post
 if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                    $loanaccountdao=new LoanAccountsDao();
            $loanaccount=$loanaccountdao->getAccountById($loanacctid);
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanRepaymentForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
       
            //    unset($postArray['_csrf_token']);
                $loanrepayment=$postArray["loanrepayment"];
                if($loanrepayment["amount"] >$loanbalance){
                       $this->getUser()->setFlash('error', __('Cannot overpay loan balance of KES '.$loanbalance));
     $this->redirect('loans/viewloan?id='.$loanacctid);
                }
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $amount=$this->form->getValue('amount');
    OhrmLoanrepayments::repayLoan($loanaccount->getId(),$amount,$this->form->getValue('repayment_date'),1);
     $earlierrepaid = $loanaccount->getAmountRepaid();
                        $allrepaidtillnow=$amount+$earlierrepaid;
                         $loanaccount->setAmountRepaid($allrepaidtillnow);
                         
                        $loanaccount->save();
    
    $this->getUser()->setFlash('success', __('Successfully made repayment of KES '.$amount));
     $this->redirect('loans/viewloan?id='.$loanacctid);     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

           
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$loanacctid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new LoanRepaymentForm(array("repayment_date"=>date("Y-m-d")),$optionsForForm, true));
 }
		
	}

//accounting
        public function executeAccounting($request) {
       $this->getUser()->setFlash('error', __('Accounting function not currently available'));
            $this->redirect('loans/newapplications'); 
        }

        /***********************reports*****************************************/
        //
        public function executeDisbursedLoansReport($request) {
  LoanAccountsDao::getLoanAccounts();
        $this->pager = new sfDoctrinePager('OhrmLoanaccounts', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmLoanaccounts')->createQuery('a')->where('a.is_disbursed= ?',1)->orderBy('a.date_disbursed DESC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
     $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
     $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
   
         $this->month=$month;
        }

        public function executeUpdateLoanProduct($request) {
           $id=$request->getParameter("id");
           $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new LoanProductForm(array(), $optionsForForm, true));
         
               if($request->isMethod('post')) {
                    
               
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addLoanProductPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
              $loanproductdao= new LoanProductsDao();
       $loanproduct=$loanproductdao->getLoanProductById($id);
                    $name= $this->form->getValue('name');
                    $shortname = $this->form->getValue('short_name');
                    $formula = $this->form->getValue('formula');
                    $interest_rate = $this->form->getValue('interest_rate');
                    $amortization = $this->form->getValue('amortization');
             $loanproduct->setName($name);
             $loanproduct->setShortName($shortname);
             $loanproduct->setFormula($formula);
             $loanproduct->setCreatedAt(date("Y-m-d H:i:s"));
             $loanproduct->setUpdatedAt(date("Y-m-d H:i:s"));
             $loanproduct->setMemberGroup(1);
             $loanproduct->setInterestRate($interest_rate);
             $loanproduct->setAmortization($amortization);
              $result =$loanproduct->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved loan product'));
                        $this->redirect('loans/loanproducts');
    }
    else{
        
        $this->getUser()->setFlash('error', __('Form is invalid'));
        $loanproductdao= new LoanProductsDao();
       $loanproduct=$loanproductdao->getLoanProductById($id);

      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
      $this->loanproduct=$loanproduct;
                        $this->redirect('loans/updateLoanProduct?id='.$id); 
    }
                }
                else{
                      $id=$request->getParameter('id');
                   
       $loanproductdao= new LoanProductsDao();
       $loanproduct=$loanproductdao->getLoanProductById($id);

      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
      $this->loanproduct=$loanproduct;
                }
        }

//application form
  public function executeApplicationForm($request){
      
      $loanacctid=$request->getParameter('ln');
      $emp=$request->getParameter('emp');
      
      $loanaccountdao=new LoanAccountsDao();
      $this->loanaccount=$loanaccountdao->getAccountById($loanacctid);
      $empdao=new EmployeeDao();
      
      $this->employee=$empdao->getEmployee($emp);
      
  }
  
   public function executeSettleLoan($request) {
       
           $id=$request->getParameter('id');
             
           $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
         
               if($request->getParameter('loanrepayment')) {
                    $periods=$request->getParameter('periods');
                     $loanacct=$request->getParameter('loanacct');
               $repaymentmonths=  explode(",", $periods);
               $payment=0;
               foreach ($repaymentmonths as $months) {
                   if($months !="on"){
                   $date=  DateTime::createFromFormat("m-Y",$months);
                   $yearmonth=$date->format("Y")."-".$date->format("m");
                 
                 $loanacctdao=new LoanAccountsDao();
                 $loanaccountdetail=$loanacctdao->getAccountById($loanacct);
                   $paymentid=OhrmLoanrepaymentScheduleTable::getMonthPrinciple($loanacct, $yearmonth);
                   $schedule= OhrmLoanrepaymentScheduleTable::getMonthlySchedule($paymentid);
                       $loantransactiondao=new LoanTransactionsDao();
                         $loanbalance= $loantransactiondao->getLoanBalance($loanacct);
                         $bal=$loanbalance-$payment;
               $payment=round($schedule->getMp()+($bal*($loanaccountdetail->getInterestRate()/100)));
              $loantransactiondao->repayLoan($loanacct,$schedule->getMp(), date("Y-m-d", strtotime($yearmonth)),1);
                   
                   }
               }
               
          
               
                    
                       $this->getUser()->setFlash('success', __('Successfully repaid loan for '.$yearmonth));
                        $this->redirect('loans/settleLoan?id='.$loanacct);
    }
 
                else{
          
                 $loanaccountdao=new LoanAccountsDao();
        $loantransactiondao=new LoanTransactionsDao();
        $this->loanaccount=$loanaccountdao->getAccountById($id);
        $this->interest=$loanaccountdao->getInterestAmount($this->loanaccount->getId());
        $this->loanbalance= $loantransactiondao->getLoanBalance($this->loanaccount->getId());
	//$this->principle_paid=$loa
        $this->principal_paid =OhrmLoanrepayments::getPrincipalPaid($this->loanaccount->getId());
        $this->interest_paid = OhrmLoanrepayments::getInterestPaid($this->loanaccount->getId());
	 $memberdao=new EmployeeDao();
             $this->member= $memberdao->getEmployee($this->loanaccount->getEmpNumber());	  
       $this->loanschedules= OhrmLoanrepaymentScheduleTable::getLoanSchedule($id);
            $this->id=$id;
  
                }
        }



  


        /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }
    
     /**
     * Get ConfigService
     * @return ConfigService
     */
    public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
        }
        return $this->configService;
    }

  protected function setSortParameter($sort) {
        $this->getUser()->setAttribute('emplist.sort', $sort, 'pim_module');
    }

    /**
     * Get the current sort feild&order from the user session.
     * @return array ('field' , 'order')
     */
    protected function getSortParameter() {
        return $this->getUser()->getAttribute('emplist.sort', null, 'pim_module');
    }
    
    /**
     *
     * @param array $filters
     * @return unknown_type
     */
    protected function setFilters(array $filters) {
        return $this->getUser()->setAttribute('emplist.filters', $filters, 'pim_module');
    }

    /**
     *
     * @return unknown_type
     */
    protected function getFilters() {
        return $this->getUser()->getAttribute('emplist.filters', null, 'pim_module');
    }

    protected function _getFilterValue($filters, $parameter, $default = null) {
        $value = $default;
        if (isset($filters[$parameter])) {
            $value = $filters[$parameter];
        }

        return $value;
    }

      protected function setPage($page) {
        $this->getUser()->setAttribute('emplist.page', $page, 'pim_module');
    }

    /**
     * Get the current page number from the user session.
     * @return int Page number
     */
    protected function getPage() {
        OhrmLoantransactions::STATE_CLEAN;
        return $this->getUser()->getAttribute('emplist.page', 1, 'pim_module');
    } 

    
     public function checkUnpaidLoansMember($empno){
              $loanaccountsformember=  LoanAccountsDao::getEmpLoanAccounts($empno);
          
              foreach ($loanaccountsformember as $loanaccount) {
                 
                  $repaid=OhrmLoanrepayments::getPrincipalPaid($loanaccount->getId());
        
                            $loandisbursed=$loanaccount->getAmountDisbursed();
                          
                  if($loandisbursed-round($repaid)>10){
                     return FALSE;
                  }
              }
           
              return TRUE;
        }
        
    
        
        public function createSchedule($loanacct){
$loanacctdao=new LoanAccountsDao();
$loanacct=$loanacctdao->getAccountById($loanacct);
$amountdisbursed=$loanacct->getAmountDisbursed();
$mp=round($loanacct->getAmountDisbursed()/$loanacct->getRepaymentDuration());
$period=ceil($loanacct->getRepaymentDuration());

$paid=0;
for($i=0;$i<$period;$i++){
    $date=$loanacct->getRepaymentStartDate();
    $loanrepaymentsch=new OhrmLoanrepaymentSchedule();
$loanrepaymentsch->setLoanacct($loanacct);

$paid=$paid+$mp;
//is period even?

if($this->isDecimal($loanacct->getRepaymentDuration())){

    if($i!=($period-1)){  //if not the last month
        $loanrepaymentsch->setMp($mp);
   $loanrepaymentsch->setPaid($paid);
    $loanrepaymentsch->setBalance($amountdisbursed-$paid);

if($i==0){  //if its the first month
$loanrepaymentsch->setDate($date);
}
else{ //other months
 
  $lastmonth=OhrmLoanrepaymentScheduleTable::getLastMonth($loanacct);
    if(date("m",  strtotime($lastmonth))=="1"){ //if january
    $newdate=date("Y-m-d",(strtotime("+28 days",  strtotime($lastmonth))));
    }
    else{
         $days=  $this->getDaysInMonth(date("m",  strtotime($lastmonth)));
     $newdate=date("Y-m-d",(strtotime("+".$days." days",  strtotime($lastmonth))));  
     
    }
    $loanrepaymentsch->setDate($newdate);
}
    }
    //if it is the last month
    else{
        $loanrepaymentsch->setMp($amountdisbursed%$mp);
       $lastmonth=OhrmLoanrepaymentScheduleTable::getLastMonth($loanacct);
    if(date("m",  strtotime($lastmonth))=="1"){ //if january
    $newdate=date("Y-m-d",(strtotime("+28 days",  strtotime($lastmonth))));
    }
    else{
         $days=  $this->getDaysInMonth(date("m",  strtotime($lastmonth)));
     $newdate=date("Y-m-d",(strtotime("+".$days." days",  strtotime($lastmonth))));  
     
    }
    $loanrepaymentsch->setDate($newdate);
        $loanrepaymentsch->setPaid($amountdisbursed);
        $loanrepaymentsch->setBalance($amountdisbursed-$amountdisbursed);
    }
    
    $loanrepaymentsch->save();
}
//even repayment period


else{
    $loanrepaymentsch->setMp($mp);
   $loanrepaymentsch->setPaid($paid);
    $loanrepaymentsch->setBalance($amountdisbursed-$paid);

if($i==0){  //if its the first month
$loanrepaymentsch->setDate($date);
}
else{ //other months
 
$lastmonth=OhrmLoanrepaymentScheduleTable::getLastMonth($loanacct);
    if(date("m",  strtotime($lastmonth))=="1"){ //if january
    $newdate=date("Y-m-d",(strtotime("+28 days",  strtotime($lastmonth))));
    }
    else{
         $days=  $this->getDaysInMonth(date("m",  strtotime($lastmonth)));
     $newdate=date("Y-m-d",(strtotime("+".$days." days",  strtotime($lastmonth))));  
     
    }
    $loanrepaymentsch->setDate($newdate);
    
}  
    
    $loanrepaymentsch->save();  
}

}



            
        }
        
        function isDecimal($value) 
{
     return ((float) $value !== floor($value));
}
   
  
function getDaysInMonth($month){
    switch ($month) {
         case 1:

$days=31;
            break;
         case 2:

$days=28;
            break;
        case 3:

$days=31;
            break;
             case 4:

$days=30;
            break;
             case 5:

$days=31;
            break;
             case 6:

$days=30;
            break;
             case 7:

$days=31;
            break;
               case 8:

$days=31;
            break;
               case 9:

$days=30;
            break;
               case 10:

$days=31;
            break;
               case 11:

$days=30;
            break;
            case 12:

$days=31;
            break;

       
    }
    
    return $days;
}
    
    
}
