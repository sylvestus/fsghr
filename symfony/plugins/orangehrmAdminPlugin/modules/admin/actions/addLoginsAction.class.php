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
class addLoginsAction extends baseAdminAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }



    public function execute($request) {
        if($request->isMethod('post')) {
                        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
                  
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
     
              $this->setForm(new AllowedLoginsForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
              
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {

    $logins=new AllowedLogins();
    $logins->setUserId($postArray['allowedLogins']['employee_id']['empId']);
    $logins->setEmployeeId($postArray['allowedLogins']['employee_id']['empId']);
    $logins->setIpAddress($postArray['allowedLogins']['ip_address']);
    $logins->setMacAddress($postArray['allowedLogins']['mac_address']);
   $logins->setStatus($postArray['allowedLogins']['status']);
    $logins->save();
    $this->getUser()->setFlash('success', __('Successfully added user to whitelist'));
     $this->redirect('admin/allowedLogins');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

         
      $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
 
             $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
  
              $this->setForm(new AllowedLoginsForm(array(),$optionsForForm, true));
 }
        
    }
    
    
       public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
        }
        return $this->configService;
    }


}