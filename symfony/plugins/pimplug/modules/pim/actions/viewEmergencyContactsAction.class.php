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
 */

/**
 * Actions class for PIM module emergency contacts
 */
class viewEmergencyContactsAction extends basePimAction {

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
        
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $this->showBackButton = true;
        
        $contacts = $request->getParameter('emgcontacts');
        $empNumber = (isset($contacts['empNumber']))?$contacts['empNumber']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        
        $this->emergencyContactPermissions = $this->getDataGroupPermissions('emergency_contacts', $empNumber);

        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        
        //hiding the back button if its self ESS view
        if($loggedInEmpNum == $empNumber) {

            $this->showBackButton = false;
        }
        
        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);
        $param = array('empNumber' => $empNumber, 'ESS' => $essMode , 'emergencyContactPermissions' => $this->emergencyContactPermissions);

        $this->setForm(new EmployeeEmergencyContactForm(array(), $param, true));
        $this->deleteForm = new EmployeeEmergencyContactsDeleteForm(array(), $param, true);

        $this->emergencyContacts = $this->getEmployeeService()->getEmployeeEmergencyContacts($this->empNumber);
    }

}
