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
class p9yearlyAction extends payrollActions {

    public function execute($request) {

        $emps = $request->getParameter("ids");
        $employeesunfiltered = explode(",", $emps);
        $payrollmonth = PayrollMonthTable::getActivePayrollMonth();
        $month = $payrollmonth->getPayrollmonth();
        $date = DateTime::createFromFormat("m/Y", $month);
        $employees = array();

        $monthsyear = array();
        $monthc = 0;
        $i = (int) $date->format("m");



        while ($monthc <= $i) {
            if ($monthc < 10) {
                $dateyear = "0" . $monthc . '/' . $date->format("Y");
            } else {
                $dateyear = $monthc . '/' . $date->format("Y");
            }
            array_push($monthsyear, $dateyear);
            //$employeeslip= PayslipTable::getPayslipForMonth($empno,$date->format("Y")); 
            $monthc++;
        }

        //filter employees
        foreach ($employeesunfiltered as $empno) {
            if (is_numeric($empno)) {
                array_push($employees, $empno);
            }
        }


        $organization = new OrganizationDao();
        $organizationinfo = $organization->getOrganizationGeneralInformation();
        $this->organisationinfo = $organizationinfo;
        $this->employees = $employees;
        $this->monthsyear = $monthsyear;

        $this->year = $date->format("Y");
    }

}
