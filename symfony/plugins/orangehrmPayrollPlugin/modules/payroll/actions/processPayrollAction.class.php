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
class processPayrollAction extends payrollActions {

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

        $employeedao=new EmployeeDao();
     $empNumber = $request->getParameter('empNumber');
        $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
        
 $this->activemonth=$payrollmonth->getPayrollmonth();
        $isPaging = $request->getParameter('hdnAction') == 'search' ? 1 : $request->getParameter('pageNo', 1);

        $pageNumber = $isPaging;
     $noOfRecords = sfConfig::get('app_items_per_page');

        $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;

      

        $this->form = new EmployeeSearchForm($this->getFilters());
        if ($request->isMethod('post')) {
$post=$request->getPostParameters();

if($post["hdnAction"]=="reset"){ //if reset
    $this->form = new EmployeeSearchForm();
      $this->employees=EmployeeDao::getEmployees();
}
else{
$searchparams=$post["empsearch"];

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                
                if($this->form->getValue('isSubmitted')=='yes'){
                    $employeedao=new EmployeeDao();
                    if($searchparams["employee_name"]["empId"]){
                        $empNumber=$searchparams["employee_name"]["empId"];
                
            $this->employees=  array(EmployeeDao::getEmployeeByNumber($empNumber)) ;
       
                    } 
                    //search by department
                    elseif ($searchparams["sub_unit"] && !$searchparams["employee_name"]["empId"]) {
                        $dept=$searchparams["sub_unit"];
                        $empdao=new EmployeeDao();
                      $this->employees=$empdao->getEmployeesByDepartment($dept);
                }
                //search by location
                elseif ($searchparams["location"] && !$searchparams["employee_name"]["empId"]) {
                        $location=$searchparams["location"];
                        $empdao=new EmployeeDao();
                      $this->employees=$empdao->getEmployeesByBranch($location);
                }
                  
                    
                    
                }         
                
                $this->setFilters($this->form->getValues());
                
            } else {
                $this->setFilters(array());
            }

            $this->setPage(1);
        }
        }
    else{
       $sortParam = array("field"=>$request->getParameter('sortField'), 
                               "order"=>$request->getParameter('sortOrder'));
            $this->setSortParameter($sortParam);
            $this->setPage(1);
              $this->employees=EmployeeDao::getEmployees();
    }
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
