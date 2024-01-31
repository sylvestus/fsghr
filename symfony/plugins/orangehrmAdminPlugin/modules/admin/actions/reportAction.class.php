<?php

class reportAction extends baseAdminAction {
    
   public function execute($request) {
   //$rp=new reportAction();
       $date=  date("d-m-Y");
header('Content-type: application/excel');
$filename = 'LeaveReport'.$date.'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>

<body>
   '.$this->leaveReport().'
</body></html>';

echo $data ;


exit();
   }


    public function leaveReport() {
$payrollmonth=PayrollMonthTable::getActivePayrollMonth();
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
        
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allentitlements=$allentitlements;
        
         $this->year=$year;
         
            $report='<table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr><td></td><td></td><td colspan="2"></td><td><b>LEAVE ENTITLEMENTS AND USAGE FOR '.$year.'</b></td><td></td><td></td></tr>
                    <tr><td class="boldText borderBottom">#</td><td class="boldText borderBottom">Employee Number</td><td class="boldText borderBottom">Employee Name</td><td class="boldText borderBottom">Leave Entitlement(Days)</td><td class="boldText borderBottom">Leave Scheduled/Taken(Days)</td><td class="boldText borderBottom">Leave Encashed</td><td class="boldText borderBottom">Leave Balance(Days)</td></tr>
                                      
                   
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
                        <td class="tdName tdValue">'.strtoupper($employeedetail->getEmpFirstname())." ".strtoupper($employeedetail->getEmpMiddleName())." ".strtoupper($employeedetail->getEmpLastname()).'
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
                        $report.=$leaveencashed.'</td> <td class="tdValue">'.($leaveentitlement-$leavetaken-$leaveencashed).'</td><td></td>
                       
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
               
               
               return $report;
    }
    
    function emailReport($data,$docpath){
    
      $message = Swift_Message::newInstance()
                ->setFrom('admin@techsavanna.technology')
              
                ->setTo($data["toemail"])
                ->setSubject(strtoupper($data["subject"]));
                   $message->attach(
Swift_Attachment::fromPath($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf')->setFilename($rand.'.pdf')
);    

     
        if($this->getMailer()->send($message)){
            echo "Successfully sent email";
        } else{
                 echo "Could not send email";
        }
    }
      
    
}

