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
class changepayrollAction extends payrollActions {

    private $moduleService;

    public function getModuleService() {

        if (!($this->moduleService instanceof ModuleService)) {
            $this->moduleService = new ModuleService();
        }

        return $this->moduleService;
    }

    public function setModuleService($moduleService) {
        $this->moduleService = $moduleService;
    }

    public function execute($request) {
$chosenmonthyear=$request->getParameter("month");
if(!$chosenmonthyear){
     $this->getUser()->setFlash('error', __('Please select valid period'));
    
     $this->redirect('payroll/configuration'); 
}
else{
    
                        //if theres an active month,update it
    $activemonth=PayrollMonthTable::getActivePayrollMonth();
      PayrollMonthTable::updateActivePayrollMonth($activemonth->getPayrollmonth(), 0);  
                       $month=PayrollMonthTable::checkMonthExists($chosenmonthyear);
                      //check if payrollmonth exists
                        if(empty($month)){
                         //insert
                             $payrollmonthobj=new PayrollMonth();
                     $payrollmonthobj->setPayrollmonth($chosenmonthyear);
                     $payrollmonthobj->setActive(1);
                     $payrollmonthobj->save();
                        }
                        
                        else{
                        PayrollMonthTable::updateActivePayrollMonth($chosenmonthyear, 1);  
                        }
                    
                   
}
$this->getUser()->setFlash('success', __('Payroll month changed to'.$chosenmonthyear));
    
     $this->redirect('payroll/configuration');    
       
    }

    protected function _checkAuthentication() {

        $user = $this->getUser()->getAttribute('user');

        if (!$user->isAdmin()) {
            $this->redirect('pim/viewPersonalDetails');
        }
    }

    protected function _resetModulesSavedInSession() {

        $this->getUser()->getAttributeHolder()->remove('admin.disabledModules');
        $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
    }

}
