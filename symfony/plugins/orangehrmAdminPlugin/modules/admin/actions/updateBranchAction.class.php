<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class updateBranchAction extends sfAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    protected function getUndeleteForm() {
        return new UndeleteCustomerForm(array(), array('fromAction' => 'addBank'), true);
    }

    public function execute($request) {
                 
        if($request->isMethod('post')) {
          $id=$request->getParameter('id');
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new BranchForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
                $getArray=$request->getGetParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['addbranch'] = $postArray;
       
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('branch_name');
  
    $bank= OhrmBankBranchTable::getBranchById($id);
  
     $bank->setBranchName($name);
     $bank->setBranchCode($this->form->getValue('branch_code'));
   $bank->setBankId($this->form->getValue('bank_id'));
     $bank->save();
    $this->getUser()->setFlash('success', __('Successfully updated branch: '.$name));
     $this->redirect('admin/bankbranches?id='.$bank->getBankId());     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {
$id=$request->getParameter('id');
  if(is_numeric($id)){
           $bank= OhrmBankBranchTable::getBranchById($id);
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new BranchForm(array("branch_name"=>$bank->getBranchName(),"branch_code"=>$bank->getBranchCode(),"bank_id"=>$bank->getBankId()),$optionsForForm, true));
 }
 else {
     $this->getUser()->setFlash('error', __('Could not get branch instance'));
   $this->redirect('admin/bankbranches');    
 }
 
 
  }
        
    }
    
    
       public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
        }
        return $this->configService;
    }


}