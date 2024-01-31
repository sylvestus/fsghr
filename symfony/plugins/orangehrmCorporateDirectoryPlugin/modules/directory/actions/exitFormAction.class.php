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
class exitFormAction extends basePimAction {

   

    public function execute($request) {
        $empNumber=$request->getParameter('empNumber');
        //die($empNumber);
        $employee=EmployeeDao::getEmployeeByNumber($empNumber);
        $empnames=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname();
       
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
        
     
        $html="<br><br><br><br><br><br><br>"
                . "<table><tr>"
                . "<td>&nbsp;</td><td colspan='2'><center><b><u>EMPLOYEE EXIT FORM</u></b></center></td><td>&nbsp;</td>"
                . "</tr>"
                . "<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td><b>NAME OF EMPLOYEE:</b>&nbsp;&nbsp;".strtoupper($empnames)."</td><td></td><td><b>ID NO:</b>&nbsp;".$employee->getEmpDriLiceNum()."</td></tr>"
               . "<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td><b>PAYROLL NO:</b>&nbsp;".strtoupper($employee->getEmployeeId())."</td><td></td><td><b>JOINING DATE: </b>".date("d-m-Y",strtotime($employee->joined_date))."</td></tr>"
                   . "<tr> <td colspan='4'><br></td></tr>"   
                . "<tr><td><b>DEPARTMENT:</b>&nbsp;".strtoupper($department)."</td><td></td><td><b>DESIGNATION</b>&nbsp;".  strtoupper($employeeduty)."</td></tr></table>"
                  . "<table>"
                  . "<tr> <td colspan='4'><br></td></tr>"
                . "<tr><td><b>DATE OF EXIT/TERMINATION/DISMISSAL:</b>&nbsp;".$terminationdate."</td></tr></table>"
                ."<table><tr><td colspan='4'><br></td></tr>
                    <tr><td colspan='4'><i>Please be adviced that the above employee has ceased being an employee of  with effect from the above date.</i></td></tr>
<tr><td colspan='4'><br></td></tr>".
      "<tr><td colspan='4'><b>NATURE OF EXIT/TERMINATION</b></td></tr>" .
                "<tr> <td colspan='4'><br></td></tr>".
          "<tr><td colspan='4'>".$terminationreason."</td></tr><tr><td colspan='4'><br></td></tr>".
                      "<tr><td colspan='2'><b>Initated By (HOD).......................................</b></td><td colspan='2'>DATE:".date("d-m-Y")."</td></tr>" .
                "<tr><td colspan='2'><b>Approved By .............................................</b></td><td colspan='2'>DATE:".date("d-m-Y")."</td></tr>" .
                "<tr><td colspan='2'><b>Initated By (HOD).......................................</b></td><td colspan='2'>DATE:".date("d-m-Y")."</td></tr>" .
                  
               "</table>";
        
       
        
        
        

        $url=$this->createPDF($html); 
        $backurl=url_for('directory/viewDirectory/reset/1');
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
$pdf->AddPage("P");
$pdf->Image($logopath);

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