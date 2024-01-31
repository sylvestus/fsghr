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
class payslipDao extends BaseDao {

    public function getPaySlipById($id) {
    
        try {
            return Doctrine::getTable('Payslip')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getPayslipsForLocation($location,$monthyear){
        $allslips=array();
        $totalbasic=array();
        $totalhousing=array();
        $totalgross=array();
        $totalnssf=array();
        $totalnhif=array();
        $totalpaye=array();
        $totalloan=array();
        $totalinterest=array();
        $totaldeductions=array();
        $totalnet=array();
        
          $employeesinlocation= HsHrEmpLocationsTable::findEmployeesInLocation($location);
           $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
           foreach ($employeesinlocation as $empno) {
                
             if(is_numeric($empno)){
             $employeeslip= PayslipTable::getPayslipForMonth($empno, $month);
             
             if(is_object($employeeslip)){
                 array_push($allslips, $employeeslip);
             }
    }
           }
           foreach ($allslips as $slip) {
          $basicpay=  PayslipsTable::getEmpBasicSalary($slip->getEmpNumber(),$monthyear);     
          $hallowance=PayslipsTable::getEmpHouseAllowance($slip->getEmpNumber(),$monthyear);
         array_push($totalgross,$slip->getGrossPay());
 array_push($totalbasic,$basicpay);
  array_push($totalhousing,$hallowance); 
  array_push($totalnssf,$slip->getNssf());
   array_push($totalnhif,$slip->getNhif());
   array_push($totalpaye,$slip->getNettaxPayable());
   array_push($totalloan,$slip->getLoanDeduction());
     array_push($totaldeductions,$slip->getTotalDeductions());
   array_push($totalnet,$slip->getNetPay());
    $emploans=  LoanAccountsDao::getEmpLoanAccounts($slip->getEmpNumber());
                            $allinterests=0;
                           foreach ($emploans as $emploan){
                           $loanaccount=$emploan;
                          
                           $interest=  LoanAccountsDao::getInterestForMonth($loanaccount->getId(), $monthyear);
                        $allinterests=$allinterests+$interest;
                     
                           }
                             array_push($totalinterest,$allinterests);
                            
   
           }      
           
         return  array("total_basic"=>array_sum($totalbasic),"total_basic"=>  array_sum($totalbasic),"total_housing"=>  array_sum($totalhousing),"total_gross"=>  array_sum($totalgross),
             "total_nssf"=>  array_sum($totalnssf),"total_nhif"=>  array_sum($totalnhif),"total_payee"=>  array_sum($totalpaye),"total_loan"=>  array_sum($totalloan),
             "total_interest"=>array_sum($totalinterest),"total_deductions"=>  array_sum($totaldeductions),"total_net"=>  array_sum($totalnet));
         
    }
    
    public static function getPayslipsForDepartment($department,$monthyear){
        
        $allslips=array();
        $totalbasic=array();
        $totalhousing=array();
        $totalgross=array();
        $totalnssf=array();
        $totalnhif=array();
        $totalpaye=array();
        $totalloan=array();
        $totalinterest=array();
        $totaldeductions=array();
        $totalnet=array();
        $empdao=new EmployeeDao();
          $employeesinlocation= $empdao->getEmployeesBySubUnit($department,false);
           $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
 //die(print_r($employeesinlocation));
           foreach ($employeesinlocation as $empno) {
                
             if(is_numeric($empno->getEmpNumber())){
             $employeeslip= PayslipTable::getPayslipForMonth($empno->getEmpNumber(), $month);
             
             if(is_object($employeeslip)){
             array_push($allslips, $employeeslip);
             }
    }
           }
           foreach ($allslips as $slip) {
          $basicpay=  PayslipsTable::getEmpBasicSalary($slip->getEmpNumber(),$monthyear);     
          $hallowance=PayslipsTable::getEmpHouseAllowance($slip->getEmpNumber(),$monthyear);
         array_push($totalgross,$slip->getGrossPay());
 array_push($totalbasic,$basicpay);
  array_push($totalhousing,$hallowance); 
  array_push($totalnssf,$slip->getNssf());
   array_push($totalnhif,$slip->getNhif());
   array_push($totalpaye,$slip->getNettaxPayable());
   array_push($totalloan,$slip->getLoanDeduction());
     array_push($totaldeductions,$slip->getTotalDeductions());
   array_push($totalnet,$slip->getNetPay());
    $emploans=  LoanAccountsDao::getEmpLoanAccounts($slip->getEmpNumber());
                            $allinterests=0;
                           foreach ($emploans as $emploan){
                           $loanaccount=$emploan;
                          
                           $interest=  LoanAccountsDao::getInterestForMonth($loanaccount->getId(), $monthyear);
                        $allinterests=$allinterests+$interest;
                     
                           }
                             array_push($totalinterest,$allinterests);
                            
   
           }      
           
         return  array("total_basic"=>array_sum($totalbasic),"total_basic"=>  array_sum($totalbasic),"total_housing"=>  array_sum($totalhousing),"total_gross"=>  array_sum($totalgross),
             "total_nssf"=>  array_sum($totalnssf),"total_nhif"=>  array_sum($totalnhif),"total_payee"=>  array_sum($totalpaye),"total_loan"=>  array_sum($totalloan),
             "total_interest"=>array_sum($totalinterest),"total_deductions"=>  array_sum($totaldeductions),"total_net"=>  array_sum($totalnet));
         
    }
    public static function getAllPayslips() {
        try {
            return Doctrine_Query::create()->from('Payslip')->orderBy("payslipdate ASC")->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function savePayslip(Payslip $subunit) {
        try {
            if ($subunit->getId() == '') {
                $subunit->setId(0);
            } else {
                $tempObj = Doctrine::getTable('Payslip')->find($subunit->getId());

                $tempObj->setMinfigure($subunit->getMinfigure());
                $tempObj->setMaxfigure($subunit->getMaxfigure());
                $tempObj->setPercentage($subunit->getPercentage());
                $subunit = $tempObj;
            }

            $subunit->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function addPayslip(Payslip $parentSubunit, Payslip $subunit) {
        try {
            $subunit->setId(0);
            $subunit->getNode()->insertAsLastChildOf($parentSubunit);

            $parentSubunit->setRgt($parentSubunit->getRgt() + 2);
            $parentSubunit->save();

            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deletePayslip($id) {
        try {
             $deletequery=Doctrine::getTable('Payslip')
  ->createQuery()
  ->delete()
  ->where(" `id`=$id")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    //get payee rate

    
    
    

 
    public function getPayslipTreeObject() {
        try {
            return Doctrine::getTable('Payslip')->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
