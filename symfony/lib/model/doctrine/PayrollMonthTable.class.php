<?php

/**
 * PayrollMonthTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PayrollMonthTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PayrollMonthTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PayrollMonth');
    }
    
     public static function getActivePayrollMonth(){
    
        $payrollmonth= Doctrine_Query::create()->from ('PayrollMonth')
             ->where(" `active`= 1")
      ->fetchOne();
        
        if(is_object($payrollmonth)){
         
          return $payrollmonth;  
        }
        else{
           return NULL; 
        }       
        
     }  
     
     public static function checkMonthExists($month){
           $payrollmonth= Doctrine_Query::create()->from ('PayrollMonth')
             ->where(" `payrollmonth` = '$month' ")
      ->fetchArray();
return $payrollmonth[0];
     }

          
     public static function updateActivePayrollMonth($month,$status){
    
          $payrollmonth= Doctrine_Query::create()->from ('PayrollMonth')
             ->where(" `payrollmonth` = '$month' ")
      ->fetchArray();
         
      $payrollmonthnew=self::getInstance()->find($payrollmonth[0]['id']);
         
          $payrollmonthnew->setActive($status);
          $payrollmonthnew->save();
          
     }
     
      public static function getDailyEmployeeRate($empno){
                $basicpay = self::getEmpBasicPay($empno);
                        $hallowance = self::getEmpHouseAllowance($empno);
                      
                        $dailypay = round((($basicpay + $hallowance) * 12) / 365);
                        return $dailypay;
     }
     
     public static function getEmpSalary($empno){
          $basicpay = self::getEmpBasicPay($empno);
                        $hallowance = self::getEmpHouseAllowance($empno);
                        return round($basicpay + $hallowance);
     }
     
       private function getEmpBasicPay($empno) {

        
            $salary = HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
            return $salary;
        
    }

    private function getEmpHouseAllowance($empno) {
       
            $salary = HsHrEmpBasicsalaryTable::getEmpHouseAllowance($empno);
         return $salary;
        }
        
        
  public static function getEmployeePayee($empno,$grosspay,$nssf){
      $grossminuspensionminusabsent=$grosspay-$nssf;
      
      $employeedetail=  EmployeeDao::getEmployeeByNumber($empno);
      $inrelief =$employeedetail->emp_nick_name;
                     
                  
                       if($inrelief >5000){
                           $inrelief=5000;
                        }
                       
      
      $payeee = IncomeTaxSlabDao::getRatesFromAmount($grossminuspensionminusabsent);
      
      $payee = ($payeee - (1408 + $inrelief));
      if($payee < 0){
          return 0;
      }
      else{
      return $payee;
      }
  }    
  
  
   
     
}