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
 *
 */

class viewLicensesAction extends sfAction {
    
    private $licenseService;
    
    public function getLicenseService() {
        
        if (!($this->licenseService instanceof LicenseService)) {
            $this->licenseService = new LicenseService();
        }        
        
        return $this->licenseService;
    }

    public function setLicenseService($licenseService) {
        $this->licenseService = $licenseService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $this->form = new LicenseForm();
        $this->records = $this->getLicenseService()->getLicenseList();
        
		if ($this->getUser()->hasFlash('templateMessage')) {
            $this->templateMessage = $this->getUser()->getFlash('templateMessage');
        }        
        
        if ($request->isMethod('post')) {
            
			$this->form->bind($request->getParameter($this->form->getName()));
            
			if ($this->form->isValid()) {

                $this->_checkDuplicateEntry();
                
				$templateMessage = $this->form->save();
				$this->getUser()->setFlash($templateMessage['messageType'], $templateMessage['message']);                
                $this->redirect('admin/viewLicenses');
                
            }
            
        }
       $this->listForm = new DefaultListForm(); 
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
    }

    protected function _checkDuplicateEntry() {

        $id = $this->form->getValue('id');
        $object = $this->getLicenseService()->getLicenseByName($this->form->getValue('name'));
        
        if ($object instanceof License) {
            
            if (!empty($id) && $id == $object->getId()) {
                return false;
            }
            
            $this->getUser()->setFlash('warning', __('Name Already Exists'));
            $this->redirect('admin/viewLicenses');            
            
        }
        
        return false;

    }    
    
}
