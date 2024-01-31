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
class processSampleEmployeePayrollAction extends payrollActions {

    public function execute($request) {
      
$post=$request->getPostParameters();
        $grosspaypost =$post["grosspay"];
        $netpaypost =$post["netpay"];
        $totalearning = $post["benefits"];
        $insurancerelief = $post["insurancerelief"];
        $deductions = $post["deductions"];
        $alldeductions=array();
        $empdeductions = array("deductions" => $deductions);
        
        //calculate gross pay
        $grosspay = $grosspaypost + $totalearning;

        $payslipno = "#001";
        $monthyear = date("m/Y");
        $empno="SMP001";
        $totaldeduction = 0;

if(empty($grosspaypost)){
    
    die("supply gross pay");
} else{
        foreach ($empdeductions as $deduction) {
            $totaldeduction = $totaldeduction + $deduction["amount"];

            if ($deduction["deduction_name"] && $deduction["amount"]) {
                $this->addPaySlipItems(array("payslipno" => $payslipno, "itemname" => $deduction["deduction_name"], "itemtype" => "deduction", "amount" => $deduction["amount"], "earning" => 0, "loan" => 0, "deduction" => 1));
            }
        }


        //nhif->deduction
        //cater for non nhif

        $nhif = $this->getNhifAmount($grosspay);

        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "nhif", "itemtype" => "deduction", "amount" => $nhif, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);

        array_push($alldeductions, $nhif);

        //nssf->deduction
        //cater for non nssf

        $nssf = $this->getNssfAmount($grosspay);

        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "nssf", "itemtype" => "deduction", "amount" => $nssf, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);

        array_push($alldeductions, $nssf);

        //payee deduction
        //taxable income
        $grossminuspensionminusabsent = $grosspay - $nssf;

        //other pension


        $personalrelief =1408;




        //cater for non-paye employees


        $payee = ($this->getPayee($grossminuspensionminusabsent) - ($personalrelief + $insurancerelief));
        // die(print_r($payee));   
        //  }
        if ($payee < 0) {  //if payee is less than personal relief,do not deduct from salary
            $payee = 0;
        }
        //get relief amount

        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "paye", "itemtype" => "deduction", "amount" => $payee, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
        //$payslip->setNettaxPayable($payee);
        array_push($alldeductions, $payee);


      //reliefs

        $allreliefs = 0;

        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "insurance_relief", "itemtype" => "relief", "amount" => $insurancerelief, "earning" => 0, "loan" => 0, "deduction" => 0), $monthyear);
        if ($payee != 0) {


         //personal relief
            $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "personal_relief", "itemtype" => "relief", "amount" => $personalrelief, "earning" => 0, "loan" => 0, "deduction" => 0), $monthyear);
            $allreliefs = $personalrelief;
        } else {
            $personalrelief=0;
        }



        $totalsalarydeductions = array_sum($alldeductions); //-($allreliefs);
                          
                     $netpay=$grosspay - $totalsalarydeductions;
         $this->setLayout(false);
        echo(json_encode(["grosspay"=>$grosspay,"netpay"=>$netpay,"earnings_benefits"=>$totalearning,"taxable_pay"=>$grossminuspensionminusabsent,"paye"=>$payee,"deductions"=>$totalsalarydeductions,"nhif"=>$nhif,"nssf"=>$nssf,"personal_relief"=>$personalrelief,"insurance_relief"=>$insurancerelief,"empno"=>$empno]));
        exit();
        
}
        }

//get No of days employee has worked,to be taken from leave module later
    public function getDaysWorked($empno, $yearmonth) {
        $date = DateTime::createFromFormat("Y-m", $yearmonth);
        $month = $date->format("m");
        $year = $date->format("Y");
        $monthyear = $date->format("m-Y");
        $daysinmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $absentdays = $this->getAbsentDays($empno, $monthyear);

//for now returngetDaysWorked( 30 days
        return $daysinmonth - $absentdays;
    }

    public function calculateGrossPay($empno, $month) {
        //earnings plus salary
        $totalpay = array();
        $salarycomponents = $this->getEmployeeService()->getEmployeeSalaries($empno);
        foreach ($salarycomponents as $salary) {
            array_push($totalpay, $salary->getAmount());
        }
        return array_sum($totalpay);
    }

    public function getEmpBasicPay($empno, $monthyear) {

        //for new employees
        //check joined date,hence days worked
        $employeedao = new EmployeeDao();
        $employeedetail = $employeedao->getEmployee($empno);
        $attendeddays = $this->checkJoinedDate($employeedetail->getJoinedDate(), $monthyear);
        $salary = HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
        $dailypay = round(($salary * 12) / 365);
        $salarynewemployee = round($attendeddays * $dailypay);
        if ($salarynewemployee) {
            return $salarynewemployee;
        } else {
            $salary = HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
            return $salary;
        }
    }

    public function getEmpHouseAllowance($empno, $monthyear) {
        $employeedao = new EmployeeDao();
        $employeedetail = $employeedao->getEmployee($empno);
        $attendeddays = $this->checkJoinedDate($employeedetail->getJoinedDate(), $monthyear);
        $salary = HsHrEmpBasicsalaryTable::getEmpHouseAllowance($empno);
        $dailypay = (($salary * 12) / 365);
        $salarynewemployee = round($attendeddays * $dailypay);
        if ($salarynewemployee) {
            return round($salarynewemployee);
        } else {
            $salary = HsHrEmpBasicsalaryTable::getEmpHouseAllowance($empno);
            return $salary;
        }
    }

    //payslip items
    public function addPaySlipItems($data, $monthyear) {
        $datetime = new DateTime();
        $mydate = $datetime->createFromFormat("m-Y", $monthyear);

        $payslipitems = array();
        $payslipitems["payslip"] = ($data["payslipno"]);
        $payslipitems["emp_no"] = $data["#Test"];
        $payslipitems["type"] = $data["itemtype"];
        $payslipitems["item"] = $data["itemname"];
        $payslipitems["amount"] = round($data["amount"], 2);
        $payslipitems["is_deduction"] = $data["deduction"];
        $payslipitems["is_earning"] = $data["earning"];
        $payslipitems["is_loan"] = $data["loan"];
    }

    public function getEmployeeEarnings($empno, $yearmonth) {
        $earnings = EmployeeEarningsDao::getEmployeeEarningsForMonth($empno, $yearmonth);
        $allearnings = array();
        foreach ($earnings as $deduction) {
            $ded = EarningsDao::getEarningById($deduction->getEarningId());
            $deductiondetail["earning_name"] = $ded->getName();
            $deductiondetail["amount"] = $deduction->getAmount();

            array_push($allearnings, $deductiondetail);
        }
        return $allearnings;
    }

    public function getEmployeeDeductions($empno, $yearmonth) {

        $deductions = EmployeeDeductionsDao::getEmployeeDeductionsForMonth($empno, $yearmonth);
        $deductiondetail = array();
        $alldeductions = array();
        foreach ($deductions as $deduction) {
            $ded = DeductionsDao::getDeductionById($deduction->getDeduction());
            $deductiondetail["deduction_name"] = $ded->getName();
            $deductiondetail["amount"] = $deduction->getAmount();
            $deductiondetail ["insurance_relief"] = $ded->getInsuranceRelief();
            array_push($alldeductions, $deductiondetail);
        }
        return $alldeductions;
    }

    /*     * **
     * @param empno
     * @return array monthlyprinciples
     */

//    public function getEmployeeLoan($empno,$yearmonth) {
//        $loanaccounts = LoanAccountsDao::getEmpLoanAccounts($empno);
//
//
//        $monthlyprinciples = array();
//        foreach ($loanaccounts as $loanaccount) {
//            //only pick mp whose loans have started being repaid
//       
//          $date=  DateTime::createFromFormat("Y-m",$yearmonth);
//          $repaydate=DateTime::createFromFormat("Y-m-d",$loanaccount->getRepaymentStartDate());
//  $repaydates=$repaydate->format("m").$repaydate->format("Y");
//
//    $dates=$date->format("m").$date->format("Y");
//   
//if(OrganizationDao::isDateGreaterOrEqualTo($dates, $repaydates)){
//            $monthlyprinciple = LoanAccountsDao::getEMP($loanaccount->getId());
//
//            array_push($monthlyprinciples, $monthlyprinciple);
//            }
//        }
//       
//       
//
//        return array_sum($monthlyprinciples);
//    }

    public function getEmployeeLoan($empno, $yearmonth) {
        $loanaccounts = LoanAccountsDao::getEmpLoanAccounts($empno);


        $monthlyprinciples = array();
        foreach ($loanaccounts as $loanaccount) {
            //only pick mp whose loans have started being repaid

            $date = DateTime::createFromFormat("Y-m", $yearmonth);
            $dates = $date->format("Y-m") . $date->format("Y");
            $monthlyprinciple = LoanAccountsDao::getEMP($loanaccount->getId(), $yearmonth);

            array_push($monthlyprinciples, $monthlyprinciple);
        }
        return array_sum($monthlyprinciples);
    }

    public function getEmployeeLoanFromId($loanacctid, $yearmonth) {



        $monthlyprinciple = 0;
        $loanaccountdao = new LoanAccountsDao();
        $loanaccount = $loanaccountdao->getAccountById($loanacctid);
        $monthlyprinciple = LoanAccountsDao::getEMP($loanacctid, $yearmonth);
        return $monthlyprinciple;
    }

    public function getNextInterest($loanacctid) {
        
    }

    public function getNhifAmount($amount) {
        $rate = NhifRatesDao::getRateFromAmount($amount);

        return $rate;
    }

    //to be refined later
    public function getNssfAmount($amount) {
        $maxamount = 18000;
        $rate = NssfRatesDao::getRateFromAmount($amount, $maxamount);
        //$rate=200;
        return $rate;
    }

    //reliefs
    public function getEmployeeReliefs($insurancerelief) {
        return array("personal_relief" => 1408, "insurance_relief" => $insurancerelief);
    }

    public function getPayee($amount) {
        $payee = IncomeTaxSlabDao::getRatesFromAmount($amount);
        return $payee;
    }

    //DI
    public function getEmployeeService() {
        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    //generate random string

    public function getRandom() {
        return rand(1000, 100000);
    }

    public function getAbsentDays($empnumber, $monthyear) {

        $days = OhrmMissedAttendanceTable::getEmployeeMissedDaysOfMonth($empnumber, $monthyear);
        return $days;
    }

    public function checkJoinedDate($joineddate, $monthyear) {
        $firstday = "1-" . $monthyear;
        $date = DateTime::createFromFormat("d-m-Y", $firstday);
        $firstday = $date->format("d-m-Y");
        $month = $date->format("m");
        $daysinmonth = $this->getDaysinMonth($month);
//if employee joined in this month and came late by more than a day
        if (date("m-Y", strtotime($joineddate)) == date("m-Y", strtotime($firstday)) && date("d", strtotime($joineddate)) > date("d", strtotime($firstday))) {
//how many days late did he join
            $date1 = new DateTime($firstday);
            $date2 = new DateTime($joineddate);

            $difference = $date2->diff($date1);

            $daysworked = $daysinmonth - (abs($difference->d));

            return $daysworked;
        } else {
            return 0;
        }
    }

    public function getDaysinMonth($month) {

        $days = 0;
        switch ($month) {

            case "1":
                $days = 31;
                break;
            case "2":
                $days = 29;
                break;
            case "3":
                $days = 31;
                break;
            case "4":
                $days = 30;
                break;
            case "5":
                $days = 31;
                break;
            case "6":
                $days = 30;
                break;
            case "7":
                $days = 31;
                break;
            case "8":
                $days = 31;
                break;
            case "9":
                $days = 31;
                break;
            case "10":
                $days = 31;
                break;
            case "11":
                $days = 30;
                break;
            case "12":
                $days = 31;
                break;
        }

        return $days;
    }

}
