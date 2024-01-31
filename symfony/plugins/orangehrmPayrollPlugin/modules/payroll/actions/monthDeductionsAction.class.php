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
class monthDeductionsAction extends payrollActions {

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
//get  last months payroll summery as default
     $allearnings=array();
    $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
        $employeedao =new EmployeeDao();
       $employeedeductionsdao= new EmployeeDeductionsDao();
       $date=  DateTime::createFromFormat("m/Y", $month);
       $yearmonth=$date->format("Y-m");
      $employees=$employeedao->getEmployeeIdList();
      $deduction=$request->getParameter("selected");
       
        if($deduction){
             foreach ($employees as $empno) {
             if(is_numeric($empno)){
             $employeeearning=  PayslipItemsTable::getDeductionsForMonth($month,$empno,$deduction);
             $earningdetails=array("empnumber"=>$empno,"amount"=>$employeeearning);
             if(count($earningdetails)>0){
                
                 array_push($allearnings,$earningdetails);
             }

             }
         }
         $this->deductionname=$deduction;
        }
        else{
         foreach ($employees as $empno) {
             if(is_numeric($empno)){
                 $empnos=array($empno);
             $employeeded=  PayslipItemsTable::getOtherDeductionsForMonth($month,$empnos);
             $deductiondetails=array("empnumber"=>$empno,"amount"=>$employeeded);
             if(count($deductiondetails)>0){
                
                 array_push($allearnings,$deductiondetails);
             }

             }
         }
         $this->deductionname="All deductions";
        }
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allearnings=$allearnings;
         $this->month=$month;
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
