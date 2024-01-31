<?php

class EarningsDeductionsActions extends sfActions {

    public function executeEarnings(sfWebRequest $request) {
      
              $this->pager = new sfDoctrinePager('OhrmEarnings', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmEarnings')->createQuery('a')->orderBy('a.name ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    }
    
    public function executeAddEarnings(sfWebRequest $request){
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EarningsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earnings=new OhrmEarnings();
    $earnings->setName($name);
    $earnings->setTaxable($this->form->getValue('taxable'));
    $earnings->setIsRecurring($this->form->getValue('is_recurring'));
      $earnings->setTaxPercentage($this->form->getValue('tax_percentage'));
    $earnings->setActive($this->form->getValue('active'));
    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully added earning: '.$name));
     $this->redirect('earningsdeductions/earnings');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new EarningsForm(array(),$optionsForForm, true));
 }

    }
    
    //update eraning
    public function executeUpdateEarning($request) {
        if($request->isMethod('post')) {
            $earningid=$request->getParameter('id');
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EarningsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['editEarning'] = $postArray;
           
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earningsdao=new EarningsDao();
    $earnings=$earningsdao->getEarningById($earningid);
        $earnings->setName($name);
    $earnings->setTaxable($this->form->getValue('taxable'));
     $earnings->setTaxPercentage($this->form->getValue('tax_percentage'));
    $earnings->setIsRecurring($this->form->getValue('is_recurring'));
    $earnings->setActive($this->form->getValue('active'));
    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully updated earning: '.$name));
     $this->redirect('earningsdeductions/earnings');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {
$earningid=$request->getParameter('id');
            $earningsdao=new EarningsDao();
    $earnings=$earningsdao->getEarningById($earningid);
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$earningid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new EarningsForm(array('name'=>$earnings->getName(),'taxable'=>$earnings->getTaxable(),'tax_percentage'=>$earnings->getTaxPercentage(),'is_recurring'=>$earnings->getIsRecurring(),'active'=>$earnings->getActive()),$optionsForForm, true));
 }
    }
    //delete earning
     public function executeDeleteearning(sfWebRequest $request){
       $id=$request->getParameter('id');
    $earningsdao=  new EarningsDao();
   if( $earningsdao->deleteEarning($id)){
        $this->getUser()->setFlash('success', __('Successfully deleted earning'));
   }
   else{
        $this->getUser()->setFlash('error', __('Could not delete earning'));
   }
   $this->redirect('earningsdeductions/earnings');     
   }

   //employee earnings
   
   public  function executeEmployeeearnings(sfWebRequest $request){
          $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
 $date=DateTime::createFromFormat("m/Y", $month);
 $this->year=$date->format("Y");
        $this->earnings=  EarningsDao::getEarnings();
      
       $this->pager = new sfDoctrinePager('HsHrEmployee', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('HsHrEmployee')->createQuery('a')->orderBy('a.emp_number ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    
   }


  public function executeAddEmployeeEarnings(sfWebRequest $request){
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeEarningsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeeearnings']['emp_number'];
    
        foreach ($empnumbers as $empnumber) {
            $employee=  EmployeeDao::getEmployeeByNumber($empnumber);
            $earning=$this->checkEmployeeEarning($this->form->getValue('earning_id'), $empnumber);
            if($earning){
              $this->getUser()->setFlash('error', __($employee->getEmpFirstname()." ".$employee->getEmpMiddleName().' already has earning,check and retry'));   
              $this->redirect('earningsdeductions/employeeearnings');  
            }
          $earnings=new OhrmEmployeeEarnings();
          $earnings->setEarningId($this->form->getValue('earning_id'));
          $earnings->setEmpNumber($empnumber);
          $earnings->setAmount($this->form->getValue('amount'));
          
          $earnings->setEarningsDate(date("Y-m-d",  strtotime($this->form->getValue('earnings_date'))));
           $earnings->setActive($this->form->getValue('active'));
             $earnings->save();
    }
  
 
    $this->getUser()->setFlash('success', __('Successfully added employee earnings'));
     $this->redirect('earningsdeductions/employeeearnings');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeEarningsForm(array("earnings_date"=>date("Y-m-d")),$optionsForForm, true));
 }

    }   
    
    
    public function checkEmployeeEarning($earning,$empno){
        $earnings=new EmployeeEarningsDao();
        $empearning=$earnings->getEmployeeEarning($empno, $earning);
      
        if(@$empearning["id"]){
                   return TRUE;    
        }
        else{
           
            return FALSE;
        }
    }
    
    public function executeUpdateEmployeesEarning($request) {
             $id=$request->getParameter('id');
           $empno=$request->getParameter('empno');
                
                 $earning=  EmployeeEarningsDao::getEmpNumberAndEarning($empno, $id);
                       
              if(!is_object($earning)){
                 $this->getUser()->setFlash('error', __('Employee doesnt have specified earning'));
     $this->redirect('earningsdeductions/employeeearnings');     
              }
                     $amount=$earning->getAmount();
                     $active=$earning->getActive();
                     $earningsdate=$earning->getEarningsDate();
          
                       if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeEarningsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeeearnings']['emp_number'];
    $id=$this->form->getValue('earning_id');

        foreach ($empnumbers as $empnumber) {
          $earningsid=EmployeeEarningsDao::getEmployeeEarning($empnumber,$id);
          $empearning=EmployeeEarningsDao::getEmployeeEarningById($earningsid);
          if(is_object($empearning)){
            $empearning->setAmount($this->form->getValue('amount'));
          $empearning->setEarningsDate(date("Y-m-d",  strtotime($this->form->getValue('earnings_date'))));
        $empearning->setActive($this->form->getValue('active'));
             $empearning->save();
          }
    }
  
  
 
    $this->getUser()->setFlash('success', __('Successfully updated employee earnings'));
     $this->redirect('earningsdeductions/employeeearnings');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeEarningsForm(array("emp_number"=>$empno,"amount"=>$amount,'earning_id'=>$id,"active"=>$active,"earnings_date"=>$earningsdate),$optionsForForm, true));
 }

    }
    
    /****************************deductions******************************/
      public function executeDeductions(sfWebRequest $request) {
      
              $this->pager = new sfDoctrinePager('OhrmSalaryDeductions', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmSalaryDeductions')->createQuery('a')->orderBy('a.name ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    }
      //add deduction
        public function executeAddDeduction(sfWebRequest $request){
        if($request->isMethod('post')) {
     $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new DeductionsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earnings=new OhrmSalaryDeductions();
    $earnings->setName($name);
    $earnings->setPercentage($this->form->getValue('percentage'));
    $earnings->setIsPercentage($this->form->getValue('is_percentage'));
     $earnings->setInsuranceRelief($this->form->getValue('insurance_relief'));
    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully added deduction: '.$name));
     $this->redirect('earningsdeductions/deductions');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new DeductionsForm(array(),$optionsForForm, true));
 }

    }
//update deduction
      public function executeUpdateDeduction($request) {
        
        if($request->isMethod('post')) {
            $earningid=$request->getParameter('id');
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new DeductionsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['editEarning'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earningsdao=new DeductionsDao();
    
    $earnings=$earningsdao->getDeductionById($earningid);
        $earnings->setName($name);
$earnings->setPercentage($this->form->getValue('percentage'));
    $earnings->setIsPercentage($this->form->getValue('is_percentage'));
     $earnings->setInsuranceRelief($this->form->getValue('insurance_relief'));

    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully updated deduction: '.$name));
     $this->redirect('earningsdeductions/deductions');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {
$earningid=$request->getParameter('id');

if(is_numeric($earningid)){
            $earningsdao=new DeductionsDao();
          
    $earnings=$earningsdao->getDeductionById($earningid);
     
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$earningid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new DeductionsForm(array('name'=>$earnings->getName(),'percentage'=>$earnings->getPercentage(),'is_percentage'=>$earnings->getIsPercentage(),'insurance_relief'=>$earnings->getInsuranceRelief()),$optionsForForm, true));
 }
                   
                   else{
                $this->getUser()->setFlash('error', __('Could not get deduction instance'));
     $this->redirect('earningsdeductions/deductions');   
                   }
    }
      }
      
      //delete deduction
     public function executeDeletededuction(sfWebRequest $request){
       $id=$request->getParameter('id');
       if(is_numeric($id)){
    $earningsdao=  new DeductionsDao();
   if( $earningsdao->deleteDeduction($id)){
        $this->getUser()->setFlash('success', __('Successfully deleted deduction'));
   }
   else{
        $this->getUser()->setFlash('error', __('Could not delete deduction'));
   }
   $this->redirect('earningsdeductions/deductions');     
       }
        else{
                $this->getUser()->setFlash('error', __('Could not get deduction instance'));
     $this->redirect('earningsdeductions/deductions');   
                   }
   }
   //employee deduction
      public  function executeEmployeedeductions(sfWebRequest $request){
        $this->deductions=  DeductionsDao::getDeductions();
      
       $this->pager = new sfDoctrinePager('HsHrEmployee', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('HsHrEmployee')->createQuery('a')->orderBy('a.emp_number ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    
   }
   //add employee deduction
     public function executeAddEmployeeDeduction(sfWebRequest $request){
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeDeductionsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeededuction']['emp_number'];
        foreach ($empnumbers as $empnumber) {
          $earnings=new OhrmEmpsalaryDeductions();
          $earnings->setDeduction($this->form->getValue('deduction'));
          $earnings->setEmpNumber($empnumber);
          $earnings->setAmount($this->form->getValue('amount'));
          $earnings->setDeductionDate(date("Y-m-d",  strtotime($this->form->getValue('deduction_date'))));
           $earnings->setIsRecurrent($this->form->getValue('is_recurrent'));
             $earnings->save();
    }
  
 
    $this->getUser()->setFlash('success', __('Successfully added employee deduction'));
     $this->redirect('earningsdeductions/employeedeductions');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeDeductionsForm(array('deduction_date'=>date("Y-m-d")),$optionsForForm, true));
 }

    }   
 //update employees deduction
      public function executeUpdateEmployeesDeduction($request) {
             $id=$request->getParameter('id');
            $empno=$request->getParameter('empno');
            
                 $earning= EmployeeDeductionsDao::getEmpNumberAndDeduction($empno, $id);
                 if(!is_object($earning)){
                      $this->getUser()->setFlash('error', __('Deduction not set for employee'));  
                         $this->redirect('earningsdeductions/employeedeductions');     
                 }
                                     $amount=$earning->getAmount();
                     $recurrent=$earning->getIsRecurrent();
                     $deductiondate=$earning->getDeductionDate();
             
                       if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeDeductionsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeededuction']['emp_number'];
    $id=$this->form->getValue('deduction');

        foreach ($empnumbers as $empnumber) {
          $earningsid=  EmployeeDeductionsDao::getEmployeeDeduction($empnumber,$id);
          $empearning=  EmployeeDeductionsDao::getEmployeeDeductionById($earningsid);
          if(is_object($empearning)){
            $empearning->setAmount($this->form->getValue('amount'));
          $empearning->setDeductionDate(date("Y-m-d",  strtotime($this->form->getValue('deduction_date'))));
          //die(print_r($this->form->getValue('deduction_date')));
        $empearning->setIsRecurrent($this->form->getValue('is_recurrent'));
             $empearning->save();
          }
    }
  
  
 
    $this->getUser()->setFlash('success', __('Successfully updated employee deduction'));
     $this->redirect('earningsdeductions/employeedeductions');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeDeductionsForm(array("emp_number"=>$empno,"amount"=>$amount,'deduction'=>$id,"is_recurrent"=>$recurrent,"deduction_date"=>$deductiondate),$optionsForForm, true));
 }

    }
  //delete emp deduction
      public function executeDeleteEmployeeDeduction(sfWebRequest $request){
       $id=$request->getParameter('id');
       
       if(is_numeric($id)){
    $deletequery=  OhrmEmpsalaryDeductionsTable::getInstance()
                    ->createQuery()
  ->delete()
  ->where(" `emp_number`=$id")
  ->execute();
   //which emp deduction to delete
    $this->getUser()->setFlash('success', __('All deductions have been deleted'));
   $this->redirect('earningsdeductions/employeedeductions');     
       }
        else{
                $this->getUser()->setFlash('error', __('Could not get deduction instance'));
     $this->redirect('earningsdeductions/employeedeductions');   
                   }
   }
    
   /*********************************Employee Benefits************************/
   public function executeBenefits(sfWebRequest $request) {
         $this->pager = new sfDoctrinePager('OhrmBenefits', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmBenefits')->createQuery('a')->orderBy('a.name ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }
   
   //add Benefit
   public function executeAddBenefit(sfWebRequest $request){
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new BenefitsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earnings=new OhrmBenefits();
    $earnings->setName($name);
    $earnings->setTaxable($this->form->getValue('taxable'));
    $earnings->setIsRecurring($this->form->getValue('is_recurring'));
    $earnings->setCalculationType($this->form->getValue('calculation_type'));
    $earnings->setMonthlyRate($this->form->getValue('monthly_rate'));
    $earnings->setAnnualRate($this->form->getValue('monthly_rate')*12);
    $earnings->setActive($this->form->getValue('active'));
    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully added benefit: '.$name));
     $this->redirect('earningsdeductions/benefits');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new BenefitsForm(array(),$optionsForForm, true));
 }

    }
   
   //update benefit
    public function executeUpdateBenefit($request) {
        if($request->isMethod('post')) {
            $earningid=$request->getParameter('id');
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new BenefitsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['editBenefit'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('name');
    $earningsdao=new BenefitsDao();
    $earnings=$earningsdao->getBenefitById($earningid);
        $earnings->setName($name);
    $earnings->setTaxable($this->form->getValue('taxable'));
    $earnings->setIsRecurring($this->form->getValue('is_recurring'));
    $earnings->setCalculationType($this->form->getValue('calculation_type'));
    $earnings->setMonthlyRate($this->form->getValue('monthly_rate'));
    $earnings->setAnnualRate($this->form->getValue('monthly_rate')*12);
    $earnings->setActive($this->form->getValue('active'));
    $earnings->save();
    $this->getUser()->setFlash('success', __('Successfully updated benefit: '.$name));
     $this->redirect('earningsdeductions/benefits');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {
$earningid=$request->getParameter('id');
if(is_numeric($earningid)){
            $earningsdao=new BenefitsDao();
    $earnings=$earningsdao->getBenefitById($earningid);
    
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$earningid;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new BenefitsForm(array('name'=>$earnings->getName(),'taxable'=>$earnings->getTaxable(),'is_recurring'=>$earnings->getIsRecurring(),'calculation_type'=>$earnings->getCalculationType(),'monthly_rate'=>$earnings->getMonthlyRate(),'active'=>$earnings->getActive()),$optionsForForm, true));
 }else{
       $this->getUser()->setFlash('error', __('Could not get a benefit instance '));
       $this->redirect('earningsdeductions/benefits');  
 }
                   }
    }
    //delete earning
     public function executeDeleteBenefit(sfWebRequest $request){
       $id=$request->getParameter('id');
//    $earningsdao=  new BenefitsDao();
//   if( $earningsdao->deleteBenefit($id)){
//        $this->getUser()->setFlash('success', __('Successfully deleted benefit'));
//   }
//   else{
//        $this->getUser()->setFlash('error', __('Could not delete benefit'));
//   }
       $this->getUser()->setFlash('error', __('feature temporarily disabled'));
   $this->redirect('earningsdeductions/benefits');     
   }

   
   //employee benefits
   
     public  function executeEmployeebenefits(sfWebRequest $request){
        $this->benefits= BenefitsDao::getBenefits();
      
       $this->pager = new sfDoctrinePager('HsHrEmployee', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('HsHrEmployee')->createQuery('a')->orderBy('a.emp_number ASC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    
   }
        public function executeAddEmployeeBenefit(sfWebRequest $request){
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeBenefitsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeebenefits']['emp_number'];
       foreach ($empnumbers as $empnumber) {
          $earnings=new OhrmEmployeeBenefits();
          $earnings->setBenefitId($this->form->getValue('benefit_id'));
          
          $earnings->setEmpNumber($empnumber);
         
          $yearlyamount=$this->form->getValue('yearly_amount');
          $earnings->setMonthlyAmount(round($yearlyamount/12,2));
           $earnings->setYearlyAmount($yearlyamount);
          $earnings->setBeginDate($this->form->getValue('begin_date'));
           $earnings->setActive($this->form->getValue('active'));
             $earnings->save();
    }
  
 
    $this->getUser()->setFlash('success', __('Successfully added employee benefit'));
     $this->redirect('earningsdeductions/employeebenefits');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeBenefitsForm(array('begin_date'=>date("Y-m-d")),$optionsForForm, true));
 }

    }   
 //update employees deduction
      public function executeUpdateEmployeesBenefits($request) {
             $id=$request->getParameter('id');
           
                 $employeeearnings= EmployeeBenefitsDao::getEmpNumberFromBenefit($id);
                 
                 $employeenumbers=array();
                 foreach ($employeeearnings as $earning) {
                     array_push($employeenumbers, $earning->getEmpNumber());
                     $yearlyamount=$earning->getYearlyAmount();
                     $active=$earning->getActive();
                     $begindate=$earning->getBeginDate();
                 }
                       if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new EmployeeBenefitsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $empnumbers=$postArray['employeebenefits']['emp_number'];
    $id=$this->form->getValue('benefit_id');

        foreach ($empnumbers as $empnumber) {
          $earningsid= EmployeeBenefitsDao::getEmployeeBenefit($empnumber,$id);
          $earnings= EmployeeBenefitsDao::getEmployeeBenefitById($earningsid);
          if(is_object($earnings)){
         $earnings->setBenefitId($this->form->getValue('benefit_id'));
          
          $earnings->setEmpNumber($empnumber);
         
          $yearlyamount=$this->form->getValue('yearly_amount');
          $earnings->setMonthlyAmount(round($yearlyamount/12,2));
           $earnings->setYearlyAmount($yearlyamount);
          $earnings->setBeginDate($this->form->getValue('begin_date'));
           $earnings->setActive($this->form->getValue('active'));
          }
    }
  
  
 
    $this->getUser()->setFlash('success', __('Successfully updated employee benefit'));
     $this->redirect('earningsdeductions/employeebenefits');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            
              $this->setForm(new EmployeeBenefitsForm(array("emp_number"=>$employeenumbers,"yearly_amount"=>$yearlyamount,'benefit_id'=>$id,"active"=>$active,"begin_date"=>$begindate),$optionsForForm, true));
 }

    }
  //delete emp deduction
      public function executeDeleteEmployeesDeduction(sfWebRequest $request){
       $id=$request->getParameter('id');
       if(is_numeric($earningid)){
    $earningsdao=  new EmployeeDeductionsDao();
   //which emp deduction to delete
   $this->redirect('earningsdeductions/employeedeductions');     
       }
        else{
                $this->getUser()->setFlash('error', __('Could not get deduction instance'));
     $this->redirect('earningsdeductions/employeedeductions');   
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

  
  



   
  
    
    
}
