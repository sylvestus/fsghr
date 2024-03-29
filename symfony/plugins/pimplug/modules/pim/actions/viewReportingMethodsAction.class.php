<?php
/**
 * SavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 SavannaHRM Inc., http://www.orangehrm.com
 *
 * SavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * SavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

class viewReportingMethodsAction extends sfAction {
    
    private $reportingMethodConfigurationService;
    
    public function getReportingMethodConfigurationService() {
        
        if (!($this->reportingMethodConfigurationService instanceof ReportingMethodConfigurationService)) {
            $this->reportingMethodConfigurationService = new ReportingMethodConfigurationService();
        }        
        
        return $this->reportingMethodConfigurationService;
    }

    public function setReportingMethodConfigurationService($reportingMethodConfigurationService) {
        $this->reportingMethodConfigurationService = $reportingMethodConfigurationService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $this->form = new ReportingMethodForm();
        $this->records = $this->getReportingMethodConfigurationService()->getReportingMethodList();
        
        if ($request->isMethod('post')) {
            
			$this->form->bind($request->getParameter($this->form->getName()));
            
			if ($this->form->isValid()) {

                $this->_checkDuplicateEntry();
                
				$templateMessage = $this->form->save();
				$this->getUser()->setFlash($templateMessage['messageType'], $templateMessage['message']);                
                $this->redirect('pim/viewReportingMethods');
                
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
        $object = $this->getReportingMethodConfigurationService()->getReportingMethodByName($this->form->getValue('name'));
        
        if ($object instanceof ReportingMethod) {
            
            if (!empty($id) && $id == $object->getId()) {
                return false;
            }
            
            $this->getUser()->setFlash('warning', __('Name Already Exists'));
            $this->redirect('pim/viewReportingMethods');            
            
        }
        
        return false;

    }    
    
}
