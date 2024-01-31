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
class wagesJournalAction extends payrollActions {

    private $moduleService;

   

    public function execute($request) {
 $allslips=array();
 $locationslips=array();
     if(is_numeric($request->getParameter("month"))){
 $month=$request->getParameter("month");
     }
     else{
         $month= date('m/Y', strtotime(date('Y-m')." -1 month"));
     }
     $locations=  OhrmLocationTable::getAllLocations();
        $employeedao =new EmployeeDao();
        foreach ($locations as $location) {
      
            $locationdetails=OhrmLocationTable::getLocation($location->getId());
           
             $employeesforlocation= $employeedao->getEmployeesByBranch($location->getId());
     
         foreach ($employeesforlocation as $empno) {
           
             if(is_numeric($empno->getEmpNumber())){
                 
             $employeeslip= PayslipTable::getPayslipForMonth($empno->getEmpNumber(), $month);
            
             if(is_object($employeeslip)){
                 array_push($allslips, $employeeslip);
             }     
         }

         
        }
        //single location slips per month
                 $slipsforlocation["location"]=$locationdetails->getName();
         $slipsforlocation["slips"]=$allslips;
         array_push($locationslips,$slipsforlocation);
         unset($allslips);
                  unset($slipsforlocation);
             }
      
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allslips=$locationslips;
         $this->month=$month;
        
    }

  
}
