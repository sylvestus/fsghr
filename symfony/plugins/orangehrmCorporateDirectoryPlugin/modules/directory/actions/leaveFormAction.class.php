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
class leaveFormAction extends basePimAction {

   

    public function execute($request) {
        $empNumber=$request->getParameter('empNumber');
        $rq=$request->getParameter('leave');
        //die(print_r($rq."leave"));
        $lv=-new OhrmLeave();
        $leaveperiod=LeaveTable::getLeavePeriodByLeaveId($rq);
        
        
        $startdateleave=$leaveperiod[0]['date'];
        $endleave=end($leaveperiod);
              $enddateleave=$endleave['date'];
              $reportback=new DateTime($enddateleave);
              $reportbackdate=$reportback->modify("+1 day");
              
             // die(print_r($enddateleave));
              $leavereccommend="";
              $leaveapproved="";
              
              
        //die($empNumber);
        $employee=EmployeeDao::getEmployeeByNumber($empNumber);
        $empnames=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname();
        $year=substr($_SESSION["payrollmonth"],3,4);
       $leavedays= OhrmLeaveEntitlementTable::getEmployeeLeave($empNumber,$year);
  $requestcomment=  LeaveRequestCommentTable::getRequestComment($rq);
       $totaldaysgiventhisyear=0;$daysremaining=0;
       foreach ($leavedays as $leaveday) {
           $totaldaysgiventhisyear+=$leaveday["no_of_days"];
            $daysremaining+=$leaveday["no_of_days"]-$leaveday["days_used"];
       }
$totaldaysyear=2*date("m");
//die(print_r($leavedays["days_used"])."csds");
       
      
        $dao=new EmployeeDao();
        $salaries=$dao->getEmployeeSalaries($empNumber);
        
       $basicsalarydet= HsHrEmpDirectdebitTable::getEmpDirectDebitDetails($empNumber);
       $bankname="";$branchname="";$bankcode="";$branchcode="";
           $department="";
$dept=OhrmSubunitTable::getDepartment($employee->getWorkStation());
    $department=$dept->name;
       $accountno="";

       if(is_object($basicsalarydet)){
    //$bank=  OhrmBankTable::getBankById($basicsalarydet->dd_bank);
          $branch= OhrmBankBranchTable::getBranchById($basicsalarydet->dd_bankbranch);
          $bank=OhrmBankBranchTable::getBankDetailsFromBranch($basicsalarydet->dd_bankbranch);
            $bankname=$bank->bank_name; $bankcode=$bank->bank_code;
             $branchname=$branch->branch_name; $branchcode=$branch->branch_code;
             $accountno=$basicsalarydet->dd_account;
            
       }
       $jtdao=new JobTitleDao();
       if(!empty($employee->job_title_code)){
        $employeeduty= $jtdao->getJobTitleOnly($employee->job_title_code);
       }
       else{
          $employeeduty=""; 
       }
       
       $terminationreason="";
    if(!empty($employee->termination_id)){
            $employeeTerminationRecord = $this->getEmployeeService()->getEmployeeTerminationRecord($employee->getTerminationId());
        $terminationdate=$employeeTerminationRecord->termination_date;
        $reason= TerminationReasonTable::getTerminationReason($employeeTerminationRecord->reason_id);
        $terminationreason=$reason->name;
            }else{
       $terminationdate=date("d-m-Y");
       $terminationreason="";
        }
       
        $imagePath = theme_path("images");
        $logopath="{$imagePath}/logoo.png";
    //die($employee->joined_date."sdsds");
            $salarysum=0;
        if(count($salaries)>0){
            foreach($salaries as $salary){
            $salarysum+=$salary->getAmount();
            }
        }
        
        //difference
        $date1 = date_create($startdateleave);
$date2 = date_create($enddateleave);

$diff = date_diff($date1,$date2);


        
     
        $html="<br><br><br><br><br><br><br>"
                . "<table style='border-collapse:separate;border-spacing:10em;'><tr>"
                . "<td colspan='4' style='text-align:center'><b><u>EMPLOYEE LEAVE APPLICATION FORM</u></b></td>"
                . "</tr><tr> <td colspan='4'><br></td></tr>" 
              . "<tr><td colspan='4'><b>1.NAME OF EMPLOYEE:</b>&nbsp;&nbsp;".strtoupper($empnames)."</td></tr>".
               "<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td colspan='4'>&nbsp;&nbsp;&nbsp;<b>ID NO:</b>&nbsp;".$employee->getEmpDriLiceNum()."</td></tr>". "<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td colspan='4'>&nbsp;&nbsp;&nbsp;<b>PAYROLL NO:</b>&nbsp;".strtoupper($employee->getEmployeeId())."</td></tr>"."<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td colspan='4'>&nbsp;&nbsp;&nbsp;<b>JOINING DATE: </b>".date("d-m-Y",strtotime($employee->joined_date))."</td></tr>"
                   ."<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;<b>BRANCH/DEPARTMENT:</b>&nbsp;".strtoupper($department)."</td><td></td><td><b>DESIGNATION</b>&nbsp;".  strtoupper($employeeduty)."</td></tr>"
                  . "<tr> <td colspan='4'>2.No of Days applied for .........".round($diff->format("%a"),2)."......... From....".date("d-m-Y",strtotime($startdateleave))."........ To.....".date("d-m-Y",strtotime($enddateleave))."......</td></tr>".
                "<tr> <td colspan='4'><br></td></tr>"
                 . "<tr> <td colspan='4'>3.To report back on .............".$reportbackdate->format("d-m-Y")."........................................................</td></tr>"
                ."<tr> <td colspan='4'><br></td></tr>"
                    ."<tr><td colspan='4'>4.Balance of leave days brought forward.............".round($totaldaysgiventhisyear,2)."........................................</td></tr>".
                        "<tr> <td colspan='4'><br></td></tr>"
                        ."<tr><td colspan='4'>This years entitlement......................".round($totaldaysyear,2)."....................................</td></tr>"."<tr> <td colspan='4'><br></td></tr>"
                ."<tr><td colspan='4'>Days remaining after this application...................".round($daysremaining,2)."................</td></tr>".
                "<tr> <td colspan='4'><br></td></tr>"
                ."<tr><td colspan='4'>5.Person to relieve the applicant while on leave................................................................</td></tr>"."<tr> <td colspan='4'><br></td></tr>"
                ."<tr><td colspan='4'>Name................................................................Job Title....................................</td></tr>".
                "<tr> <td colspan='4'><br></td></tr>"."<tr><td colspan='4'>6.Applicant's contact address while on leave:....................".$employee->emp_street1."&nbsp;".ucwords($employee->city_code).".............................</td></tr>".
               "<tr> <td colspan='4'><br></td></tr>" ."<tr><td colspan='4'>Telephone No......................".$employee->emp_mobile."...................Alternative Phone No....".$employee->emp_hm_telephone.".......</td></tr>".
               "<tr> <td colspan='4'><br></td></tr>" ."<tr><td colspan='4'>7.Signature of applicant................................................................</td></tr>".
               "<tr> <td colspan='4'><br></td></tr>" ."<tr><td colspan='4'>8.Leave Recommended/Rejected by:</td></tr>".
               "<tr> <td colspan='4'><br></td></tr>" ."<tr><td colspan='4'>Name....................................................Signature..........................................</td></tr>".
                 "<tr> <td colspan='4'><br></td></tr>" ."<tr><td colspan='4'>9.Leave Approved/Rejected by:</td></tr>".
             "<tr> <td colspan='4'><br></td></tr>"   ."<tr><td colspan='4'>Name...................................................Signature..........................................</td></tr>
<tr><td colspan='4'><br></td></tr>".
      "<tr><td colspan='4'><b>Employee's Declaration</b></td></tr>" .
                "<tr> <td colspan='4'><br></td></tr>"       
                      ."<tr><td colspan='4'><i>I hereby confirm that i have taken my annual leave and further agree that i have no claim against the company for any outstanding dues or days in lieu of my annual leave to (month)</i></td></tr>"
                ."<tr><td colspan='4'>...................".$year."...................................Signature..........................................</td></tr>"
                   ."<tr><td colspan='4'><br><br>(Date)...........................".date("d/m/Y").".........................................</td></tr>".
                "<tr><td colspan='4'><br></td></tr>".
                 "<tr><td colspan='4'><b>(Incase your services are required,you will be called back prior to completion of your leave)</b></td></tr>".
               "</table>";
        
       // die($html);
       
        
        
        

        $url=$this->createPDF($html); 
        $backurl=url_for('leave/viewLeaveList/reset/1');
      echo "<center><h2><a href='$backurl'>Back</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='$url'>View Document</a></h2></center>";
    
      exit();
    }

    public function createPDF($html){
         require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
        $rand=  rand(100,1000000);
        $imagePath = theme_path("images");
        $logopath="{$imagePath}/logo.png";
  
         // always load alternative config file for examples


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shiloah HRM');
$pdf->SetTitle('Report');
$pdf->SetSubject('Custom Report');
$pdf->SetKeywords('TCPDF, PDF, report, test, guide');

$pdf->setPrintHeader(FALSE);

// set default header data


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT,"", PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->SetTopMargin(10);
//$pdf->Image('*'.$logopath);
 $organisationdao=new OrganizationDao();
               $organisationinfo= $organisationdao->getOrganizationGeneralInformation();
        $logopath=sfConfig::get('sf_upload_dir') . "\assets"."\\".$organisationinfo["letter_head"];
$pdf->AddPage("P");
$pdf->Image($logopath,10,0,150,30);

$pdf->SetFont('helvetica', '',10);   
      $tbl = <<<EOD
        
       <br><br>
<table  width="99%" cellspacing="0" cellpadding="2" style="white-space: nowrap !important;" id="pdftable"><tr><td>$html</td></tr></table>
        
EOD;

      //write page
      $pdf->writeHTML($tbl, true, false, false,true, '');
      $pdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf','F');

$url = "http://".$_SERVER["HTTP_HOST"].'/ohrm/symfony/pdfs/'.$rand.".pdf";

return $url;

    }
  

}