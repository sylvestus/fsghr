<?php

class payrollActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
            
        
    }
    
       public function executeConfiguration(sfWebRequest $request) {
            
           $configuration=PayrollConfigTable::getConfiguration();
         $this->configuration= $configuration;
    }
    
    public function executeUpdateConfiguration(sfWebRequest $request) {
        $post=$request->getPostParameters();

        //$configuration=new PayrollConfig();
        $configuration=PayrollConfigTable::getConfiguration();
        $configuration->setPersonalRelief($post['personal_relief']);
        $configuration->setInsuranceRelief($post['insurancerelief']);
  $configuration->setSpouseRelief($post['spouse_relief']);
  $configuration->setQualifyingRelief($post['qualifying_relief']);
  $configuration->setOtherRelief($post['other_relief']); 
   $configuration->setHourlyRate($post['hourly_rate']);
  $configuration->setDailyRate($post['daily_rate']); 
  if(!$configuration->save()){
      echo json_encode("Payroll Configuration Successfully Saved ");
      
  }
  else{
       echo json_encode("Error in saving,please check fields");
  }
  exit();
    }
  
       

    
   public function executeAddIncomeTaxSlab(sfWebRequest $request) {
 
             $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             
              $this->setForm(new IncomeTaxSlabForm(array(), $optionsForForm, true));
         
               if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addIncomeTaxSlabPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
        $incometax=new IncometaxSlab();
                    $minfigure = $this->form->getValue('minfigure');
                    $maxfigure = $this->form->getValue('maxfigure');
                    $percentage = $this->form->getValue('percentage');
             $incometax->setMinfigure($minfigure);
             $incometax->setMaxfigure($maxfigure);
             $incometax->setPercentage($percentage);
              $result =$incometax->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved tax slab'));
                        $this->redirect('payroll/addIncomeTaxSlab');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
   }   
    //update Paye
     public function executeUpdateIncomeTaxSlab(sfWebRequest $request) {
      if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                   $this->setForm(new IncomeTaxSlabForm(array(), $optionsForForm, true));
              $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
 $id=$request->getParameter('id');
                    $minfigure = $this->form->getValue('minfigure');
                    $maxfigure = $this->form->getValue('maxfigure');
                    $percentage = $this->form->getValue('percentage');
                     $incometaxdao=new IncomeTaxSlabDao();
      $incometax=$incometaxdao->getIncomeTaxSlabById($id);
             $incometax->setMinfigure($minfigure);
             $incometax->setMaxfigure($maxfigure);
             $incometax->setPercentage($percentage);
              $result =$incometax->save();
                    
                       $this->getUser()->setFlash('success', __('Successfully saved tax slab'));
                        $this->redirect('payroll/listIncomeTaxSlab');
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
              }
 else {
       $id=$request->getParameter('id');
       $incometaxdao=new IncomeTaxSlabDao();
      $incometax=$incometaxdao->getIncomeTaxSlabById($id);
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             
              $this->setForm(new IncomeTaxSlabForm(array('minfigure'=>$incometax->getMinFigure(),'maxfigure'=>$incometax->getMaxFigure(),'percentage'=>$incometax->getPercentage()), $optionsForForm, true));
 }
 }


   
   //list
   public function executeListIncomeTaxSlab(sfWebRequest $request){
       $this->pager = new sfDoctrinePager('IncomeTaxSlab', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('IncomeTaxSlab')->createQuery('a'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }
//delete tax slab
   public function executeDeleteIncomeTaxSlab(sfWebRequest $request){
       $id=$request->getParameter('id');
    
     $deletequery=Doctrine::getTable('IncomeTaxSlab')
  ->createQuery()
  ->delete()
  ->where(" `tb_id`=$id")
  ->execute();
     
     $this->getUser()->setFlash('success', __('Successfully deleted Tax slab'));
     $this->redirect('payroll/listIncomeTaxSlab');
   }
   
   /******************NHIF********************/
   public function executeNhif( sfWebRequest $request) {
    $this->pager = new sfDoctrinePager('NhifRates', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('NhifRates')->createQuery('a'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
   }
   //form create
   public function executeAddNhifRatesSlab(sfWebRequest $request) {
 
             $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             
              $this->setForm(new NhifRatesForm(array(), $optionsForForm, true));
         
               if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addNhifRatesPost'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
        $nhif=new NhifRatesDao();
                    $minfigure = $this->form->getValue('minfigure');
                    $maxfigure = $this->form->getValue('maxfigure');
                    $amount = $this->form->getValue('amount');
           $result=$nhif->addNhifRates(array("minfigure"=>$minfigure,"maxfigure"=>$maxfigure,"amount"=>$amount));
              if($result)      {             
                       $this->getUser()->setFlash('success', __('Successfully saved rates'));
                        $this->redirect('payroll/nhif');
              }
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
   } 
   
   //update NHif 
    public function executeUpdateNhifRatesSlab(sfWebRequest $request) {
        $post=$request->getPostParameters();
        if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                   $this->setForm(new NhifRatesForm(array(), $optionsForForm, true));
              $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
           $id=$request->getParameter('id');
 $nhifdao=new NhifRatesDao();
      $nhif=$nhifdao->getNhifRatesById($id);
    
        
          $minfigure = $this->form->getValue('minfigure');
                    $maxfigure = $this->form->getValue('maxfigure');
                    $amount = $this->form->getValue('amount');

                $nhif->setMinfigure($minfigure);
                $nhif->setMaxfigure($maxfigure);
                $nhif->setAmount($amount);
             
        
       
  if(!$nhif->save()){
           $this->getUser()->setFlash('success', __('Nhif configuration Successfully Saved '));
      
           $this->redirect('payroll/nhif');
  }  else{
         $this->getUser()->setFlash('error', __('Nhif Configuration details not saved '));
      
           $this->redirect('payroll/nhif');
  }
    }
    
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
              }
 else {
       $id=$request->getParameter('id');
       $nhifdao=new NhifRatesDao();
      $nhif=$nhifdao->getNhifRatesById($id);
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
             
              $this->setForm(new NhifRatesForm(array('minfigure'=>$nhif->getMinFigure(),'maxfigure'=>$nhif->getMaxFigure(),'amount'=>$nhif->getAmount()), $optionsForForm, true));
 }
    }
  
   
   
   //delete nhif
    public function executeDeleteNhifRatesSlab(sfWebRequest $request){
       $id=$request->getParameter('id');
  $nhif=new NhifRatesDao();
  if($nhif->deleteNhifRates($id)){
     
     $this->getUser()->setFlash('success', __('Successfully deleted Rate'));
  }
     $this->redirect('payroll/nhif');
   }
   
   //Nssf
    public function executeNssf(sfWebRequest $request) {
        
           $configuration=  NssfTable::getConfiguration();
         $this->configuration= $configuration;
    
   
}
  public function executeUpdateNssf(sfWebRequest $request) {
        $post=$request->getPostParameters();

        //$configuration=new PayrollConfig();
        $nssf= new NssfRatesDao();
        
        $configuration=$nssf->getNssfRatesById(1);
         if($request->isMethod('post')) {
        $configuration->setEmployeeContribution($post['employee_contribution']);
        $configuration->setEmployerContribution($post['employer_contribution']);
          $configuration->setMaxEmployeeNssf($post['max_employee_nssf']);
           $configuration->setMaxEmployerNssf($post['max_employer_nssf']);
           $configuration->setNssfLowerEarning($post['nssf_lower_earning']);
            $configuration->setNssfUpperEarning($post['nssf_upper_earning']);
            $configuration->setEmployerNssfUpperEarning($post['employer_nssf_upper_earning']);
 
  if(!$configuration->save()){
           $this->getUser()->setFlash('success', __('Nssf Configuration Successfully Saved '));
      
           $this->redirect('payroll/nssf');
  }
  else{
         $this->getUser()->setFlash('error', __('Nssf Configuration details not saved '));
      
           $this->redirect('payroll/nssf');
  }
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
      
        return $this->getUser()->getAttribute('emplist.page', 1, 'pim_module');
    } 


   
  
    
    
}
