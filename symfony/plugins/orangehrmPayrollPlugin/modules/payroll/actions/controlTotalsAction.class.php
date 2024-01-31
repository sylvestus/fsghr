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
class controlTotalsAction extends payrollActions {

    private $moduleService;

   

   
    public function execute($request) {
     $allslips=array();
     $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
   $this->departmentlist=  OhrmSubunitTable::getAllDepartments();
      $department=$request->getParameter("department");
      if(!is_numeric($department)){
          $this->month=$month;
        
      }else{
    
     $employeedao =new EmployeeDao();
        
       $employees= $employeedao->getEmployeesBySubUnit($department);
       
       $subunitinfo=OhrmSubunitTable::getDepartment($department);
       $subunit=$subunitinfo->getName();
       $allemployees=array();
         foreach ($employees as $emps) {
             $empno=$emps->getEmpNumber();
             array_push($allemployees, $empno);
             if(is_numeric($empno)){
             $employeeslip= PayslipTable::getPayslipForMonth($empno, $month);
             
             if(is_object($employeeslip)){
                 array_push($allslips, $employeeslip);
             }

             }
         }
         
         if(count($allemployees)<=0){
               $this->getUser()->setFlash('error', __('Department has no employees'));
    
     $this->redirect('payroll/controlTotals');   
         }
       
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allslips=$allslips;
         $this->nssf=  PayslipItemsTable::getPayslipNssfForMonth($month,$allemployees);
         $this->nhif=  PayslipItemsTable::getPayslipNhifForMonth($month,$allemployees);
         $this->payee=  PayslipItemsTable::getPayslipPayeeForMonth($month,$allemployees);
         $this->loans=  PayslipItemsTable::getPayslipLoansForMonth($month,$allemployees);
         $this->absenteepay=  PayslipItemsTable::getPayslipAbsenteePayForMonth($month,$allemployees);
         $this->otherdeductions=  PayslipItemsTable::getOtherDeductionsForMonth($month,$allemployees);
         $this->reliefs=  PayslipItemsTable::getPayslipReliefForMonth($month,$allemployees);
         $this->departmentname=$subunit;
         $this->departmentid=$department;
         $this->month=$month;
      }
    }

         
       

  
}
