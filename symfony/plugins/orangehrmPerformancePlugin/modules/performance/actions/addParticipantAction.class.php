<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2010 OrangeHRM Inc., http://www.orangehrm.com
 *
 * Please refer the file license/LICENSE.TXT for the license which includes terms and conditions on using this software.
 *
 * */
class addParticipantAction extends basePeformanceAction {




 public function execute($request) {
     
             $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
           
             $optionsForForm = array();
     $form=new ParticipantsForm(array(), $optionsForForm, true);
              $this->setForm($form);
              $form->getValidator($form->getCSRFFieldName())->setOption('required', false);
              $session=$request->getParameter("session");
               $this->session=  OhrmTrainingSessionTable::getSession($session);
               if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
             //die(print_r($postArray));
                //unset($postArray['_csrf_token']);
                $_SESSION['participants'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
        foreach ($postArray["participants"]["employee"] as $value) {
            
        
                    $trainingcourses=new OhrmTrainingParticipants();
                   $trainingcourses->setEmployee($value);
                  $trainingcourses->setApproved($this->form->getValue('approved'));
                     $trainingcourses->setTrainingSession($session);
                $trainingcourses->setApprovedBy($this->form->getValue('approved_by'));
                $trainingcourses->setRecommendation($this->form->getValue('recommendation'));
                   //$trainingcourses->setStatus($this->form->getValue('status'));
                   
             $trainingcourses->save();
        }
                       $this->getUser()->setFlash('success', __('Successfully added participant'));
                        $this->redirect('performance/participants?id='.$session);
                  
                }
 else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
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
    
  
}
