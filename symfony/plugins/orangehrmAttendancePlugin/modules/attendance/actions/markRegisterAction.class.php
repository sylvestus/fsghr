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
 */
class markRegisterAction extends sfAction {

 

    public function execute($request) {
             $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
        
       $date=  DateTime::createFromFormat("m/Y", $month);
       $monthandyear=$date->format("m-Y");
        $location=$request->getParameter("location");
       $number = cal_days_in_month(CAL_GREGORIAN,date("m",  strtotime($monthandyear)),date("Y",  strtotime($monthandyear))); // 31
       $this->daysinmonth=$number;
       $employeesmissed=array();
       $misseddays=  OhrmMissedAttendanceTable::getMissedDaysOfMonth($monthandyear);
       foreach ($misseddays as $day){
           $employeemissed[$day["emp_number"]]=$day["day_missed"];
           
           array_push($employeesmissed, $employeemissed);
       }
       $this->employeesmissed=$employeesmissed;
       $this->date=$monthandyear;
       //return employees in selected location
       if(is_numeric($location)){
           $this->employees= EmployeeDao::getEmployeesByLocation($location);
           $location=  OhrmLocationTable::getLocation($location);
           $this->location=$location->getName();
       }
       else{
       $this->employees=  EmployeeDao::hydrateEmployeeEarnings();
        $this->location="All Locations";
       }
     
    }

 

}