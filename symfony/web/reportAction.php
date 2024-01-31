<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//require '../lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/vendor/doctrine/Doctrine/Table.php';
//require '../lib/model/doctrine - Copy/PayrollMonthTable.class.php';
//require '../lib/model/doctrine - Copy/OhrmLeaveEntitlementTable.class.php';
class reportAction  {
    
    public function include_all_php($folder){
    foreach (glob("{$folder}/*.php") as $filename)
    {
        //echo ($filename."csd");
        include $filename;
    }
}


    
     public function leaveReport() {
         $this->include_all_php("../lib/vendor/symfony/");
         $this->include_all_php("../lib/model/doctrine - Copy/");
         $this->include_all_php("../lib/model/doctrine/orangehrmCorePlugin/base/");
$payrollmonth=  PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
 $date=  DateTime::createFromFormat("m/Y",$month);
 $year=$date->format("Y");
        $employeedao =new EmployeeDao();
        $allentitlements=array();
      

        
       $employees= $employeedao->getEmployeeIdList(TRUE);
       
        foreach ($employees as $empno) {
             if(is_numeric($empno)){
             $employeentitlement= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($employeentitlement)){
                 array_push($allentitlements, $employeentitlement);
             }

             }
         }
        
    
         $this->allentitlements=$allentitlements;
        
         $this->year=$year;
         
            $report='<table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr><td></td><td></td><td colspan="2"></td><td class="boldText borderBottom">LEAVE ENTITLEMENTS AND USAGE FOR <?=$year?></td><td></td><td></td></tr>
                    <tr><td class="boldText borderBottom">#</td><td class="boldText borderBottom">Employee Number</td><td class="boldText borderBottom">Employee Name</td><td class="boldText borderBottom">Leave Entitlement(Days)</td><td class="boldText borderBottom">Leave Scheduled/Taken(Days)</td><td class="boldText borderBottom">Leave Encashed</td><td class="boldText borderBottom">Leave Balance(Days)</td><td class="boldText borderBottom">Days to encash</td></tr>
                                      
                   
                </thead>
                <tbody>';
                    
                
                    $row = 0;
                    $count=1;
           foreach ($allentitlements as $record):  
               if(count($record)>0){
                        $cssClass = ($row%2) ? 'even' : 'odd';
                   
                   $report.= '<tr>
                        <td>'.$count.'</td>
                        <td class="tdName tdValue">';
                            
                         
                    foreach ($record as $value) {
                      $empno=$value["emp_number"]  ;
                    }
                      
                         $employeedetail=  EmployeeDao::getEmployeeByNumber($empno); 
                         $report.=$employeedetail->getEmployeeId().                    
                     
                       ' </td>
                        <td class="tdName tdValue">'.$employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->getEmpLastname().'
                        </td>
                 
                         <td class="tdName tdValue">';
                        
                         $leaveentitlement=0;
                         $leavetaken=0;
                         foreach ($record as $value) {
                                 $leaveentitlement+=$value["no_of_days"];
                                 $leavetaken+=$value["days_used"];
                                
                             }
                         $report.=$leaveentitlement.'</td>
                         
                        <td class="tdName tdValue">'.$leavetaken.'</td>
                       <td class="tdName tdValue">';
                        $leaveencashed=  EncashLeaveTable::getEncashedLeaveForYear($empno, $year);
                        $report.=$leaveencashed.'</td> <td class="tdValue">'.$leaveentitlement-$leavetaken-$leaveencashed.'</td>
                       
                    </tr>';
                    
                 
                    $row++;
                    $count++;
               }
                    endforeach; 
              
                    
                   if (count($allentitlements) == 0) : 
                   $report= '<tr class="even">
                        <td>'. __(TopLevelMessages::NO_RECORDS_FOUND).
                        '</td>
                       
                    </tr>';
                    endif; 
                    
               $report.=' </tbody>
            </table>';
               
               
               echo $report;
    }
      
    
}



$rp=new reportAction();

$rp->leaveReport();