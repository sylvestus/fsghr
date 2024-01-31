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
 * Actions class for PIM module updateDependentAction
 */

class updateTaxationAction extends basePimAction {

    /**
     * Add / update employee customFields
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function execute($request) {
        
        // this should probably be kept in session?
       
        if ($this->getRequest()->isMethod('post')) {

$empno=$request->getParameter('empno');
            // Handle the form submission
            $post=$request->getPostParameters();
          //  die(print_r($post));
            $employee=  EmployeeDao::getEmployeeByNumber($empno);
            $employee->pay_nssf=$post["nssf"];
            $employee->pay_nhif=$post["nhif"];
            $employee->pay_tax=$post["tax"];
            $employee->fixed_tax=$post["fixedtax"];
            $employee->encash_leave=$post["encashleave"];
            $employee->vehicle_value=$post["carvalue"];
            $employee->vehicle_benefit=$post["carbenefit"];
                      $employee->emp_nick_name=$post["insurancerelief"];
            $employee->save();
            
                echo "Successfully updated ";
           
            exit();
            
//            if ($this->form->isValid()) {
//
//                $empNumber = $this->form->getValue('EmpID');
//                if (!$this->IsActionAccessible($empNumber)) {
//                    $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
//                }
//
//                $this->form->save();
//                $this->getUser()->setFlash('customFieldsMessage', array('success', __(TopLevelMessages::UPDATE_SUCCESS)));                
//            } else {
//                $this->getUser()->setFlash('customFieldsMessage', array('warning', __('Failed to Save: Length Exceeded')));
//            }
        }                    

                    
        $this->redirect($this->getRequest()->getReferer() . '#custom');
    }

}
