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
class payslipSummaryAction extends payrollActions {

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
//     $allslips=array();
//     if(is_numeric($request->getParameter("month"))){
// $month=$request->getParameter("month");
//     }
//     else{
//         $month= date('m/Y', strtotime(date('Y-m')." -1 month"));
//     }
//        $employeedao =new EmployeeDao();
//       $employees= $employeedao->getEmployeeIdList(TRUE);
//        
//         foreach ($employees as $empno) {
//             if(is_numeric($empno)){
//             $employeeslip= PayslipTable::getPayslipForMonth($empno, $month);
//             
//             if(is_object($employeeslip)){
//                 array_push($allslips, $employeeslip);
//             }
//
//             }
//         }
//         $organization=  new OrganizationDao();
//         $organizationinfo=$organization->getOrganizationGeneralInformation();
//         $this->organisationinfo=$organizationinfo;
//         $this->allslips=$allslips;
//         $this->month=$month;
        
        $this->getUser()->setFlash('error', __('Functionality coming soon '));
    
     $this->redirect('payroll/processPayroll');    
        
    }

  
}
