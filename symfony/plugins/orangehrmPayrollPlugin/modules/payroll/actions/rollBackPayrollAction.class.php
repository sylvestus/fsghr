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
class rollBackPayrollAction extends payrollActions {

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
     $empnumbers = $request->getParameter('empNumber');

        $payrollmonth="28/".$request->getParameter("monthyear");
                   $myDateTime = \DateTime::createFromFormat('d/m/Y',$payrollmonth);
 $yearmonth = $myDateTime->format('Y-m');
  $monthyear = $myDateTime->format('m-Y');
  $monthstrokeyear=$myDateTime->format('m/Y');
   $employees = explode(",", $empnumbers);

        if (!$empnumbers) {
            $this->getUser()->setFlash('error', __('Select at least 1(one) employee'));

            $this->redirect('payroll/processPayroll');
        } else {


            foreach ($employees as $empnumber) {
                if(is_numeric($empnumber)){
                    
                     $employeedao = new EmployeeDao();
                    $employeedetail = $employeedao->getEmployee($empnumber);
        //find loan amounts paid and reset remaining balance
        
        //delete payslips
       $deletedpayslip=PayslipsTable::deletePayslipsForMonth($yearmonth,$empnumber);
        //delete payslip items
         $deletedpayslipitems=PayslipItemsTable::deletePayslipsItemsForMonth($yearmonth,$empnumber);
       /*delete missed attendance*****/
         $deletedmissedattandance=  OhrmMissedAttendanceTable::deleteMissedAttendanceForMonth($monthyear,$empnumber);//deletePayslipsItemsForMonth($yearmonth);
         /*******roll back loan repayment************************/
         $loantransactiondao=new LoanTransactionsDao();
   // $loantransactiondao->deleteLoanForMonth(date("Y-m-d", strtotime($yearmonth . "-30")));
    
   
    $emploans = LoanAccountsDao::getEmpLoanAccounts($empnumber);
    foreach ($emploans as $emploan) {
        
    
                        $loanaccount = $emploan;
                        $loanaccountdao = new LoanAccountsDao();
                        $loanaccountobject = $loanaccountdao->getAccountById($loanaccount["id"]);
                         //update payment counter
                       
                         //update balance -vely
                       $monthlyprinciple=  $this->getEmployeeLoan($empnumber);
                       if($loanaccountobject->getRepaymentCounter()>0){ //if repaid times >o
                            
                            //if amounts repaid are greater than once
                            if($loanaccountobject->getAmountRepaid() > 0){
                                //-$monthlyprinciple
                                $repaidamount= LoanTransactionsDao::getRepaymentsForMonth($loanaccount["id"], $monthyear);
                                if($repaidamount >0){
                                    LoanAccountsDao::updateRepaymentCounter($loanaccount["id"],"-");
                                    
                                    OhrmLoanrepaymentsTable::deleteRepaymentForMonth($loanaccount["id"], $monthyear);
                                }
                                $setrepaidamount=$loanaccountobject->getAmountRepaid()-$repaidamount;
                                if($setrepaidamount < 0){$setrepaidamount=0;}
     $loanaccountobject->setAmountRepaid($setrepaidamount);
                            }
                            else{
                            $loanaccountobject->setAmountRepaid(0);         
                            }
     $loanaccountobject->save();
                       }
         
    }

    //for casuals remove worked hours
    $this->removeHoursWorked($empnumber,$monthyear);
    
  
    //remove leave assignment for employees not on probation and the ones joined more than a year ago
    
    
                }
       
         if($deletedpayslip && $deletedpayslipitems){
               if(!$employeedetail->on_probation){
                        $this->RemoveEmployeeLeaveEntitlement($empnumber, $monthyear);
                        }
       
               $employee=$employeedao->getEmployee($empnumber);
                  $this->getUser()->setFlash('warning', __('Payroll for the period ('.$payrollmonth.') for '.$employee->getEmployeeId().'has been rolled back '));
         
     //$this->redirect('payroll/processPayroll');  
       }
       else{
            $this->getUser()->setFlash('error', __('Payroll for the period ('.$payrollmonth.') could not be rolled back '));
    
   
       //}
          }
           }
           
             $this->redirect('payroll/processPayroll');      
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
    
   

 function RemoveEmployeeLeaveEntitlement($empno,$monthyear,$days=1.75,$leavetype=2){
       $conn = Doctrine_Manager::connection();
       $date=date("Y-m-d H:i:s");
       $year=substr($monthyear, -4);
       $createdbyid=1;
       $createdbyname="Admin";
        //$sql = $conn->prepare($countQuery);
       // $result = $statement->execute($bindParams);
       
      $sql=$conn->prepare("UPDATE ohrm_leave_entitlement SET no_of_days=no_of_days-?,leave_type_id=?,credited_date=?,created_by_id=?,created_by_name=? WHERE emp_number='$empno' AND  DATE_FORMAT(from_date,'%Y')='$year'");

$sql->bindParam(1,$days);
$sql->bindParam(2, $leavetype);
$sql->bindParam(3, $date);
$sql->bindParam(4, $createdbyid);
$sql->bindParam(5, $createdbyname);
//$sql->bindParam(6, "Leave assignment after payroll ".$monthyear);
$sql->execute(); 
    }
    
    
    public function getEmployeeLoan($empno) {
        $loanaccounts = LoanAccountsDao::getEmpLoanAccounts($empno);


        $monthlyprinciples = array();
        foreach ($loanaccounts as $loanaccount) {

            $monthlyprinciple = LoanAccountsDao::getEMP($loanaccount->getId());

            array_push($monthlyprinciples, $monthlyprinciple);
        }

        return array_sum($monthlyprinciples);
    }
    
     public  function removeHoursWorked($empid,$monthyear) {
        $conn = Doctrine_Manager::connection();
        $query="Delete from casualhours where emp_id=:emp_id and monthyear=:monthyear";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bindParam(':emp_id', $empid);
$stmt->bindParam(':monthyear', $monthyear);
$stmt->execute();
     
    }
     }

}
