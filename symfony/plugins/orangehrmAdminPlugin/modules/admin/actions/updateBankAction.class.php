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
class updateBankAction extends sfAction {

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
     
              $this->setForm(new BankForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
                $getArray=$request->getGetParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['addbank'] = $postArray;
       
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
    $name=$this->form->getValue('bank_name');
  
    $bank= Ohrm_BankTable::getBankById($id);
  
     $bank->setBankName($name);
     $bank->setBankCode($this->form->getValue('bank_code'));
   
     $bank->save();
    $this->getUser()->setFlash('success', __('Successfully updated bank: '.$name));
     $this->redirect('admin/banks');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {
$id=$request->getParameter('id');
  if(is_numeric($id)){
           $bank=  Ohrm_BankTable::getBankById($id);
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
      $this->id=$id;
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new BankForm(array("bank_name"=>$bank->getBankName(),"bank_code"=>$bank->getBankCode()),$optionsForForm, true));
 }
 else {
     $this->getUser()->setFlash('error', __('Could not get bank instance'));
   $this->redirect('admin/banks');    
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