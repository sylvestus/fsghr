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
class entryFormAction extends basePimAction {

   

    public function execute($request) {
        $empNumber=$request->getParameter('empNumber');
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
       
        $imagePath = theme_path("images");
        $logopath="{$imagePath}/logoo.png";
   
            $salarysum=0;
        if(count($salaries)>0){
            foreach($salaries as $salary){
            $salarysum+=$salary->getAmount();
            }
        }
        
        $documents=array("academic_and_proffesional_certificates"=>"Academic and Proffessional Certificates","copy_of_id"=>"Copy Of ID Card","passport_photo"=>"2 Colored Passport Size Photos","nssf_card"=>"Copy Of NSSF Card","nhif_card"=>"NHIF Card","kra_pin"=>"Copy Of KRA PIN","good_conduct"=>"Certificate Of Good Conduct","salary_details"=>"Salary Remittance Bank Account Details");
     $count=1;
        foreach ($documents as $key=>$value) {
          $docchecklist=  DocumentsChecklistTable::getDocumentChecklist($key,$empNumber);
                              if($docchecklist->status==1){
                                  $status="<i>V</i>";
                              }
 else {$status="X";}
   $htmldocuments.="<tr><td>(".$count.")&nbsp;&nbsp;".$value."</td><td><center>&nbsp;&nbsp;&nbsp;".$status."</center></td><td>".$docchecklist->remarks."</td></tr>";      
   $count++; 
   }
        
        $html="<br><br><br><br><br><p style='text-align:center'><center><b>STAFF ENTRY FORM</b></center><hr></p>



<table><tr><td><b>NAME: MR./ MS:</b></td><td>".  strtoupper($empnames)."&nbsp;</td><td><b>ID NO:</b></td><td>".$employee->getEmpDriLiceNum()."</td></tr>

<tr><td><b>DATE OF BIRTH :</b></td><td>".$employee->getEmpBirthday().'</td><td><b>JOINING DATE:</b></td><td>'.$employee->getJoinedDate()."</td></tr>

<tr><td><b>DEPARTMENT:</b></td><td>".$department."</td><td><b>DESIGNATION:</b></td><td>".$employeeduty."</td></tr>

<tr><td><b>PIN NO:</b></td><td>".$employee->getEmpOtherId()."</td><td><b>NSSF NO: </b></td><td>".$employee->getEmpSsnNum()."</td></tr>

<tr><td><b>NHIF NO:</b></td><td>".$employee->getEmpSinNum()."</td></tr>

</table>
<p><br></p>
<p><b>Contact Details</b><hr></p>



<table><tr><td style='width:40%'><b>POSTAL ADDRESS:</b></td><td>".$employee->getEmpStreet1()."</td><td><b>CODE:</b></td><td>".$employee->getEmpZipcode()."</td><td><b> TOWN:</b></td><td>".$employee->getEmpStreet2()."</td></tr></table>

<p><br />
</p>

<p><b>TELEPHONE NO: ".$employee->getEmpMobile()."</b></p>

<p><br />
</p>

<p><b>EMAIL ADDRESS: ".$employee->getEmpWorkEmail()."</b></p>

<p><br />
</p>

<p><b>Bank Account Details</b><hr></p>



<p><b>BANK ACCOUNT NO:</b> ".@$accountno."</p>

<p><br>
</p>

<table><tr><td><b>BANK NAME:</b>&nbsp;".@$bankname." &nbsp;&nbsp;</td><td><b>BANK CODE:</b>&nbsp;".@$bankcode."&nbsp;</td></tr></table>

<p><br>
</p>

<table><tr><td><b>BRANCH NAME:</b>&nbsp;".$branchname. "&nbsp;&nbsp;</td><td><b>BRANCH CODE:</b>&nbsp;&nbsp;".$branchcode."</td></tr></table>

<p><br />
</p>

<p><br />
</p>

<p><b>FOR OFFICIAL USE ONLY <hr></b></p>


<table width='100%'>
<tr><td><b>PAYROLL NO:</b>".$employee->getEmployeeId()."</td><td><b>BASIS:</b> PERMANENT</td></tr>

<tr><td colspan='3'><br></td></tr>
<tr><td><b>SALARY:</b> KSHS.".number_format($salarysum)."</td><td></td><td><b>COST CENTRE: </b>".$employee->getEmployeeId()."</td></tr>

<tr><td colspan='3'><br></td></tr></table>
<table width='100%'>
<tr><td  style='text-align:left'><b>RECRUITED BY(HOD):</b>.................................</td><td><b>PROCESSED&nbsp;BY&nbsp;(FINANCE CONTROLLER):</b>..............................</td></tr>
</table>
<table><tr><td colspan='3'><br></td></tr></table>
<table><tr><td><b>HR MANAGER</b>......................................</td><td colspan='2'></td></tr></table>
<table><tr><td colspan='3'><br></td></tr></table>
<table width='100%'><tr><td style='text-align:left'><b>APPROVED&nbsp;BY&nbsp;(DIRECTOR)</b>.............................</td><td colspan='2'><b>DATE APPROVED:</b> ".date("d-m-Y")."</td></tr></table>  
   <table width='100%'> <tr><td colspan='3'><br></td></tr>
    </table>
<table><tr><td colspan='3'><br><br><br><br><br><br><br><br><br></td></tr></table>

<p><b>DOCUMENT CHECKLIST <hr></b></p>

<table width='100%'><tr><th style='font-weight:bold'><b>Document</b></th><th style='font-weight:bold'><b>Status</b></th><th style='font-weight:bold'><b>Remarks</b></th></tr><tr><th></th><th><br></th><th></th></tr>".$htmldocuments."</table>

";
     
        
        
        

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