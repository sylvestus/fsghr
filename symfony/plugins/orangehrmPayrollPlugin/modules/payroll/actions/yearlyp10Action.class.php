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
class yearlyp10Action extends payrollActions {

  

 
    public function execute($request) {
             $employeedao=new EmployeeDao();
  $employees= $employeedao->getEmployeeIdList(FALSE);
  $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
   $month=$payrollmonth->getPayrollmonth();
 $date=DateTime::createFromFormat("m/Y", $month);

       $slipsforyear=array();
       
        $month=1; $i=12;
                    
        foreach ($employees as $empno) {
             if(is_numeric($empno)){
                          while ($month<=$i) {
                                 $dateyear=$month.'/'.$date->format("Y");
                              $employeeslip= PayslipTable::getPayslipForMonth($empno,$date->format("Y")); 
                               if(is_object($employeeslip)){
                           
                 array_push($slipsforyear,$employeeslip);
                 }
                                 $month++;
                             }
            
             
            
             
             $slipsforyears[$empno]=$slipsforyear;
             // unset($slipsforyear);
             }
            
         }  
         
          $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->employees=  $employees;   
         $this->year=$date->format("Y");
         
         
}

}