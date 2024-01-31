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
class processEmployeePayrollAction extends payrollActions {

    public function execute($request) {

        $empnumbers = $request->getParameter("ids");
        $my = "28/".$request->getParameter("monthyear");
        $myDateTime = DateTime::createFromFormat('d/m/Y',$my);
       $hours=$request->getParameter("hours");
        $yearmonth = $myDateTime->format('Y-m');
       
        $monthyear = $myDateTime->format('m-Y');
         $mymonth = $myDateTime->format('m');
        $month = date("m", strtotime($yearmonth));

        $effected = 1; // $request->getParameter("effected");
        $employees = explode(",", $empnumbers);
            $workedhours=explode(",", $hours);
            $casualemployees=array();
            $allworked=array();
            //add all casuals in array for comparison
          foreach($workedhours as $worked){
              $explode=  explode("*", $worked);
              $workedemployee[$explode[0]]=$explode[1];   //employee no and hours worked
              array_push($casualemployees,$explode[0]);
              if(in_array($explode[0], $employees) && $explode[1]>0 ){ //if casual employee is in array and has worked for at least an hour
              $this->addHoursWorked($explode[0],$explode[1], $monthyear,0)  ;
              }
              
             //  array_push($allworked, $workedemployee);
          }  
          
            
          // die(print_r($workedemployee));

        if (!$empnumbers) {
            $this->getUser()->setFlash('error', __('Select at least 1(one) employee'));

            $this->redirect('payroll/processPayroll');
        } else {


            foreach ($employees as $empno) {
                $alldeductions = array();

                if (is_numeric($empno)) {   //also remove terminated employees
                    //get current month payslips
                    $employeeslip= PayslipTable::getPayslipForMonth($empno,$myDateTime->format('m/Y'));
                 
             if(is_object($employeeslip)){
                $this->getUser()->setFlash('error', __('Some Employee(s) slips have already been generated for ' . $monthyear.' please roll back first'));

            $this->redirect('payroll/processPayroll');
             }
                    
                    $employeedao = new EmployeeDao();
                    $employeedetail = $employeedao->getEmployee($empno);
                    if (!is_numeric($employeedetail->getTerminationId())) {


                        $payslip = new Payslip();
                        $payslipno = $this->getRandom();

                        $payslip->setEmpNumber($empno);




                        $payslip->setEmpname($employeedetail->getEmpFirstname() . ' ' . $employeedetail->getEmpMiddleName() . ' ' . $employeedetail->getEmpLastname());
                        //$employeedetail->getOhrmSubunit()
                        $location = HsHrEmpLocationsTable::findEmployeeLocation($empno);
                        if(empty($location)){
                            $location="N/A";
                        }
                        $payslip->setDepartment($location);
                        //check earnings
                        $empearnings = $this->getEmployeeEarnings($empno, $yearmonth);
$totalearning = 0;
                           //get leave entitlements
if(in_array($empno, $casualemployees)){
    $basicpay=$this->getEmpBasicPay($empno, $monthyear)*$workedemployee[$empno]; //get hours worked for casual employee
}else{ $basicpay = $this->getEmpBasicPay($empno, $monthyear);}
                        $hallowance = $this->getEmpHouseAllowance($empno, $monthyear);
                      
                        $dailypay = round((($basicpay + $hallowance) * 12) / 365,2);
                     if($employeedetail->getEncashLeave()>0){
                    $leaveentitlements= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$myDateTime->format('Y'));
                    foreach ( $leaveentitlements as $value) {
                                 $leaveentitlement+=$value["no_of_days"];
                                 $leavetaken+=$value["days_used"];
                                
                             }
                      $balance=$leaveentitlement-$leavetaken;   
                      
                      
                        $encashmentamount=round($balance*$dailypay,2);
                      if($balance>0){
                          $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" =>"LEAVE ENCASHMENT:".$balance."DAYS", "itemtype" => "earning", "amount" => $encashmentamount, "earning" => 1, "loan" => 0, "deduction" => 0), $monthyear);
                      }
                      $totalearning+=$encashmentamount;
                     }   
                     
                     if($employeedetail->vehicle_benefit > 0){
                     //check vehicle benefit
                     $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no"=> $empno, "itemname" =>"CAR-BENEFIT", "itemtype" => "earning", "amount" =>$employeedetail->vehicle_benefit, "earning" => 1, "loan" => 0, "deduction" => 0), $monthyear);
                     $totalearning+=$employeedetail->vehicle_benefit;
                     }
                     //encash from leave balance  
                     $encashmentdays= EncashLeaveTable::getEncashedLeaveForMonth($empno, $monthyear);
                     
                     if($encashmentdays>0){
                       $encashmentamount=round($encashmentdays*$dailypay,2);
                          $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" =>"LEAVE ENCASHMENT:".$encashmentdays."DAYS", "itemtype" => "earning", "amount" => $encashmentamount, "earning" => 1, "loan" => 0, "deduction" => 0), $monthyear);
                      
                      $totalearning+=$encashmentamount;  
                      //update Encashment
                    //  EncashLeaveTable::updateLeaveEncashment($empno, $monthyear);
                     }
                $untaxablearning=0;     
           
                        foreach ($empearnings as $earning) {
                          
                            
                        
                            //take care of untaxable earnings ie 100-tax_percentage
                            if($earning["taxable"] > 0 && ($earning["tax_percentage"] < 100) ){
                                $untaxablearning+=$totalearning + round(((100-$earning["tax_percentage"])*$earning["amount"])/100,2);
                            }
                            $totalearning = $totalearning + $earning["amount"];
                            $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => $earning["earning_name"], "itemtype" => "earning", "amount" => $earning["amount"], "earning" => 1, "loan" => 0, "deduction" => 0), $monthyear);
                        }

                        $payslip->setTotalEarnings($totalearning);
                        //absenteesm
                       $daysworked=  $this->getDaysinMonth($mymonth);
                        $absentdays = $this->getAbsentDays($empno, date("m-Y", strtotime($yearmonth)));

                        $payslip->setWeekoff($absentdays);
                       // $basicpay = $this->getEmpBasicPay($empno, $monthyear);
                        $hallowance = $this->getEmpHouseAllowance($empno, $monthyear);
                        $payslip->setBasicPay(round($basicpay,2));
                        $dailypay = round((($basicpay + $hallowance) * 12) / 365);
                        $absenteepay = $dailypay * $absentdays;
                        //houseallowance

                        if ($absenteepay && $hallowance >0) {
                            $hallowance = $hallowance - $absenteepay;
                            $payslip->setHouseAllowance(round($hallowance));
                        } else {

                            $payslip->setHouseAllowance(round($hallowance));
                        }


                        $payslip->setPaidDays($daysworked - $absentdays);
                        unset($daysworked);
                        unset($absentdays);


                        //calculate gross pay
                        $grosspay = $basicpay + $hallowance + $totalearning;



                        $payslip->setGrossPay($grosspay);



                        //check deductions for this month
                        $empdeductions = $this->getEmployeeDeductions($empno, $yearmonth);

                        $totaldeduction = 0;
                        $insurancereliefs = array();
                      
                        foreach ($empdeductions as $deduction) {
                            $totaldeduction = $totaldeduction + $deduction["amount"];


                            if ($deduction["insurance_relief"] == 1 && empty($employeedetail->getEmpNickName())) {   //if he has a deduction of type relief
                                $irelief = round(0.15 * $deduction["amount"],2);

                                if ($irelief >= 5000) {
                                    $insurancerelief = 5000;
                                    array_push($insurancereliefs, $irelief);
                                } else {
                                    $insurancerelief = $irelief;
                                    array_push($insurancereliefs, $irelief);
                                }
                               if( $deduction["deduction_name"] && $deduction["amount"]){
                                $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => $deduction["deduction_name"], "itemtype" => "deduction", "amount" => $deduction["amount"], "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                               }
                               
                               } else {

                                $insurancerelief =$employeedetail->getEmpNickName();//get fixed relief amount
                              
                                array_push($insurancereliefs, $insurancerelief);
                                 if( $deduction["deduction_name"] && $deduction["amount"]){
                                $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => $deduction["deduction_name"], "itemtype" => "deduction", "amount" => $deduction["amount"], "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                                 }
                               
                                 }
                        }
               //  die($employeedetail->getEmpNickName()."ddd");
                       
                        $payslip->setInsuranceRelief(array_sum($insurancereliefs));
                       // if(array_sum($insurancereliefs)>0){
                        //$this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "INSURANCE RELIEF", "itemtype" => "deduction", "amount" => array_sum($insurancereliefs), "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                      //  }
                        array_push($alldeductions, $totaldeduction);

                        //check loans->deduction
                        $loans = round($this->getEmployeeLoan($empno, $yearmonth));



                        $account = LoanAccountsDao::getEmpLoanAccounts($empno);

                        if ($loans > 1) {
                            $emploans = LoanAccountsDao::getEmpLoanAccounts($empno);
                            $allinterest = array();
                            $allloans = array();
                            foreach ($emploans as $emploan) {
                                $loanaccount = $emploan;
                                $loanaccountdao = new LoanAccountsDao();
                                $loanaccountobject = $loanaccountdao->getAccountById($loanaccount["id"]);


                              

                                //deduct loan if theres a loan balance and if repayment start date is reached
                                $date = DateTime::createFromFormat("m-Y", $monthyear);
                                $repaydate = DateTime::createFromFormat("Y-m-d", $loanaccount->getRepaymentStartDate());
                                $dates = $date->format("m") . $date->format("Y");
                                $repaydates = $repaydate->format("m") . $repaydate->format("Y");

                                if (OrganizationDao::isDateLesserOrEqualTo($repaydates, $dates)) {
                                    $loantransactiondao = new LoanTransactionsDao();

                                    $loanbalance = $loantransactiondao->getLoanBalance($loanaccount["id"]);
                                     /*                                 * **************returns monthly principle ****************** */
                                $loan = $this->getEmployeeLoanFromId($loanaccount["id"], $yearmonth);
                               
                                //if remaining balance is less than $monthlypayment
                               
                                if(round($loanbalance)< round($loan)){
                                    $loan=$loanbalance;
                                }
                                    $balance = $loanbalance;

                                    if ($balance > 1) {

                                        //update payment counter
                                        LoanAccountsDao::updateRepaymentCounter($loanaccount["id"]);
                                       $acct=$loanaccountdao->getAccountById($loanaccount["id"]);
                                      $loanproduct=new LoanProductsDao();
                                      $product=$loanproduct->getLoanProductById($loanaccountobject->loanproduct_id);
                                        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" =>  ucwords($product->name), "itemtype" => "loan", "amount" => $loan, "earning" => 0, "loan" => 1, "deduction" => 0), $monthyear);


//calculate interest
                                        $interestrate = $loanaccountobject->getInterestRate();
                                        // if ($loanaccount->getRepaymentCounter() > 1) {
                                        $interest = ($balance * ($interestrate / 100));
                                        array_push($allinterest, $interest);

                                        //update amount of loan
                                        $earlierrepaid = $loanaccount->getAmountDisbursed() - $loanbalance;
                                        $allrepaidtillnow = $loan + $earlierrepaid;

                                        //if only loan has not been fully repaid
                                        if ($loanaccount->getAmountDisbursed() - $earlierrepaid > 1) {
                                            //loan transaction for repayment
                                            $loantransactiondao = new LoanTransactionsDao();

                                            $loantransactiondao->repayLoan($loanaccount["id"], $loan, date("Y-m-d", strtotime($yearmonth)));

                                            //loan interest
                                            if($interest){
                  $loantransactiondao->repayLoanInterest($loanaccount["id"], $interest, date("Y-m-d", strtotime($yearmonth)));
                                            }
                                            $loanaccount->setAmountRepaid($allrepaidtillnow);
                                            $loanaccount->save();
                                            $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "loan interest", "itemtype" => "loan", "amount" => $interest, "earning" => 0, "loan" => 1, "deduction" => 0), $monthyear);
                                            array_push($allloans, $loan);
                                        }
                                    }
                                }
                            } //end for each loan
                            array_push($alldeductions, (int) array_sum($allinterest));
                            unset($allinterest);
                            array_push($alldeductions, (int) array_sum($allloans));

                            $payslip->setLoanDeduction((int) array_sum($allloans));
                            unset($allloans);
                        }
                        //nhif->deduction
                        //cater for non nhif
                        if($employeedetail->getPayNhif()==0){
                          $nhif=0;  
                         
                        } else{
                        $nhif = $this->getNhifAmount($grosspay);
                        }
                        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "nhif", "itemtype" => "deduction", "amount" => $nhif, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                        $payslip->setNhif($nhif);
                        array_push($alldeductions, $nhif);

                        //nssf->deduction
                        //cater for non nssf
                         if($employeedetail->getPayNssf()==0){
                              $nssf = 0;  
                            } else{
                        $nssf =$this->getNssfAmount($grosspay);
                            }
                        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "nssf", "itemtype" => "deduction", "amount" => $nssf, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                        $payslip->setNssf($nssf);
                        array_push($alldeductions, $nssf);


                        //get relief
                       $inrelief =$employeedetail->getEmpNickName();
                     
                        if(empty($inrelief)){
                        $inrelief=array_sum($insurancereliefs);
                       if(array_sum($insurancereliefs)>5000){
                           $inrelief=5000;
                        }}
                        $relief = $this->getEmployeeReliefs($inrelief);

                        //payee deduction
                        //taxable income
                        $grossminuspensionminusabsent = $grosspay - $nssf;

                        //other pension
                        //if pensionable
                        if ($employeedetail->getEmpPensionable()) {
                            $pension = round(0.05 * $grosspay);
                            if ($pension >= 19800) {
                                $pension = 19800;
                            } else {
                                $grossminuspensionminusabsent = $grossminuspensionminusabsent - $pension;
                            }
                            $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "Pension", "itemtype" => "deduction", "amount" => $pension, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);

                            array_push($alldeductions, $pension);
                        }


                        $payslip->setTaxableIncome($grossminuspensionminusabsent-$untaxablearning);
if($employeedetail->getPayRelief()==0){
                                $personalrelief= 0;  
                            }
                            else{
                           $personalrelief = $relief["personal_relief"];     
                            }
                        

$insurancerelief=$relief["insurance_relief"];
                            //cater for non-paye employees
                            if($employeedetail->getPayTax()==0){
                              
                              $payee = 0;  
                            }
                            else if ($employeedetail->fixed_tax > 0) {
                              $payee = round(($employeedetail->fixed_tax/100)*($grossminuspensionminusabsent-$untaxablearning))-($personalrelief + $inrelief);   # code...
                            }
                            else{
                                
                        $payee = ($this->getPayee($grossminuspensionminusabsent-$untaxablearning) - ($personalrelief + $insurancerelief));
                       // die(print_r($payee));   
                        }
                        if ($payee < 0) {  //if payee is less than personal relief,do not deduct from salary
                            $payee = 0;
                        }
                        //get relief amount

                        $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "paye", "itemtype" => "deduction", "amount" => $payee, "earning" => 0, "loan" => 0, "deduction" => 1), $monthyear);
                        $payslip->setNettaxPayable($payee);
                        array_push($alldeductions, $payee);





                        array_sum($payee);

                        //deductions
                        $payslip->setTotalDeductions(array_sum($alldeductions));
                        //reliefs

                        $allreliefs = 0;

                         $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "insurance_relief", "itemtype" => "relief", "amount" => $insurancerelief, "earning" => 0, "loan" => 0, "deduction" => 0), $monthyear);
                        if ($payee != 0) {
                            
                            
                            $payslip->setPersonalRelief($personalrelief);
                            $this->addPaySlipItems(array("payslipno" => $payslipno, "emp_no" => $empno, "itemname" => "personal_relief", "itemtype" => "relief", "amount" => $personalrelief, "earning" => 0, "loan" => 0, "deduction" => 0), $monthyear);
                            $allreliefs = $personalrelief;
                        } else {
                            $payslip->setPersonalRelief(0);
                        }



                        $totalsalarydeductions = array_sum($alldeductions); //-($allreliefs);
                        $payslip->setNetPay(round($grosspay - $totalsalarydeductions));
                        //other items
                        $payslip->setEmploymentIncome(round($grosspay - $totalsalarydeductions));
                        $payslip->setPaidday(date("d"));
                        $payslip->setDividends(0);

                        $payslip->setPreparedBy($this->getUser()->getAttribute('auth.firstName'));
                        //time
                        $payslip->setTime(date("Y-m-d H:i:s"));

                        $payslip->setPayslipdate(date("Y-m-d", strtotime($yearmonth)));

                        //commit payslip?
                        $payslip->setEffected($effected);
                        $payslip->setPayslipNo($payslipno);


                        $payslip->save();

                        //Add leave entitlement for employees not on probation and the ones joined more than a year ago
                        if(!$employeedetail->on_probation){
                        $this->AddEmployeeLeaveEntitlement($empno, $monthyear);
                        }
                        
                        
                        unset($totaldeduction);
                        unset($alldeductions);
                        unset($grosspay);
                        unset($totalearning);
                        unset($allreliefs);
                    }
                }
            }
            $this->getUser()->setFlash('success', __('Successfully processed payroll for ' . $monthyear));

            $this->redirect('payroll/processPayroll');
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
        $dailypay = round(($salary * 12) / 365,2);
        $salarynewemployee = round($attendeddays*$dailypay);
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

        $payslipitems = new PayslipItems();
        $payslipitems->setPayslipId($data["payslipno"]);
        $payslipitems->setEmpNumber($data["emp_no"]);
        $payslipitems->setItemType($data["itemtype"]);
        $payslipitems->setItemName($data["itemname"]);
        $payslipitems->setAmount(round($data["amount"], 2));
        $payslipitems->setIsDeduction($data["deduction"]);
        $payslipitems->setIsEarning($data["earning"]);
        $payslipitems->setIsLoan($data["loan"]);
        $payslipitems->setDatetime($mydate->format("Y-m-d H:i:s"));
        $payslipitems->save();
    }

    public function getEmployeeEarnings($empno, $yearmonth) {
        $earnings = EmployeeEarningsDao::getEmployeeEarningsForMonth($empno, $yearmonth);
        $allearnings = array();
        foreach ($earnings as $earning) {
            $ded = EarningsDao::getEarningById($earning->getEarningId());
            $deductiondetail["earning_name"] = $ded->getName();
            $deductiondetail["amount"] = $earning->getAmount();
            $deductiondetail["earning_id"] = $earning->getEarningId();
            $deductiondetail["taxable"] = $ded->getTaxable();
            $deductiondetail["tax_percentage"] = $ded->getTaxPercentage();
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
     //$rate = NssfRatesDao::getRateFromAmount($amount, $maxamount);
      $rt=  new NssfRatesDao();
      $ratedetail=$rt->getNssfRatesById(1);
      $rate=$ratedetail->max_employee_nssf;
      
        return $rate;
    }

    //reliefs
    public function getEmployeeReliefs($insurancerelief) {
        return array("personal_relief" =>1408, "insurance_relief" => $insurancerelief);
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
        if (date("m-Y", strtotime($joineddate)) == date("m-Y", strtotime($firstday)) && date("d", strtotime($joineddate))>date("d", strtotime($firstday))) {
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
    
    
    
 
          public  function addHoursWorked($empnumber,$hours,$month,$halfmonth) {
      
   $conn = Doctrine_Manager::connection();
        //$sql = $conn->prepare($countQuery);
       // $result = $statement->execute($bindParams);
       
        $sql=$conn->prepare("INSERT INTO casualhours (emp_id,monthyear,hours,half) VALUES (? ,? ,?,?)");

$sql->bindParam(1, $empnumber);
$sql->bindParam(2, $month);
$sql->bindParam(3, $hours);
$sql->bindParam(4, $halfmonth);
$sql->execute();
    }
    
    
    
    
    /*******************function to add 2 leave days per month to employee*****************************/
    function AddEmployeeLeaveEntitlement($empno,$monthyear,$days=1.75,$leavetype=2){ //1.75 for melvins,2 shiloah
       $conn = Doctrine_Manager::connection();
       $date=date("Y-m-d H:i:s");
       $year=substr($monthyear, -4);
       $createdbyid=1;
       $createdbyname="Admin";
        //$sql = $conn->prepare($countQuery);
       // $result = $statement->execute($bindParams);
       
      $sql=$conn->prepare("UPDATE ohrm_leave_entitlement SET no_of_days=no_of_days+?,leave_type_id=?,credited_date=?,created_by_id=?,created_by_name=? WHERE emp_number='$empno' AND  DATE_FORMAT(from_date,'%Y')='$year'");

$sql->bindParam(1,$days);
$sql->bindParam(2, $leavetype);
$sql->bindParam(3, $date);
$sql->bindParam(4, $createdbyid);
$sql->bindParam(5, $createdbyname);
//$sql->bindParam(6, "Leave assignment after payroll ".$monthyear);
$sql->execute(); 
    }
    
    
    

}