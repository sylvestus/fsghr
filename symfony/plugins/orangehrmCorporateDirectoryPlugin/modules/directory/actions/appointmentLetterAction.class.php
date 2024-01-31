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
class appointmentLetterAction extends basePimAction {

   

    public function execute($request) {
        $empNumber=$request->getParameter('empNumber');
        $employee=EmployeeDao::getEmployeeByNumber($empNumber);
        $empnames=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname();
       $jtdao=new JobTitleDao();
       if(!empty($employee->job_title_code)){
        $employeeduty= $jtdao->getJobTitleOnly($employee->job_title_code);
       }
       else{
          $employeeduty=""; 
       }
        $dao=new EmployeeDao();
        $salaries=$dao->getEmployeeSalaries($empNumber);
        $imagePath = theme_path("images");
        $logopath="{$imagePath}/logo.png";
   
            $salarysum=0;
        if(count($salaries)>0){
            foreach($salaries as $salary){
            $salarysum+=$salary->getAmount();
            }
        }
        
         $organisationdao=new OrganizationDao();
               $organisationinfo= $organisationdao->getOrganizationGeneralInformation();
        $html="<div style='text-align:justify;'><p><br><br>
</p>


<p><br></p>
<p><b>NAME OF EMPLOYEE:&nbsp;</b>".strtoupper($empnames)." </p>

<table><tr><td><b>POSTAL ADDRESS:</b></td><td>P.O. BOX&nbsp;".$employee->getEmpStreet1()."</td><td><b>CODE/TOWN:</b></td><td>".strtoupper($employee->getEmpZipcode().",".$employee->getCityCode())." </td></tr>

<tr><td><b>ID CARD NO:</b></td><td>".$employee->getEmpDriLiceNum()."&nbsp;&nbsp;&nbsp;</td><td><b>SERIAL NO: </b></td><td>".$employee->getCustom2()."&nbsp;&nbsp;&nbsp;</td></tr>

<tr><td><b>PLACE OF ISSUE:</b></td><td>".$employee->getCustom4()."&nbsp;&nbsp;&nbsp;</td><td><b>DATE OF ISSUE:</b></td><td>".date("d-m-Y",strtotime($employee->getCustom3()))."&nbsp;&nbsp;&nbsp;</td></tr>

<tr><td><b>DISTRICT OF BIRTH:</b></td><td>".$employee->getCustom5()."&nbsp;&nbsp;&nbsp;</td><td><b>DATE OF BIRTH:</b></td><td>".date("d-m-Y",strtotime($employee->getEmpBirthday()))."&nbsp;&nbsp;&nbsp;</td></tr>
    <tr><td><b>DIVISION:</b></td><td>".$employee->getCustom6()."&nbsp;&nbsp;&nbsp;</td><td><b>LOCATION:</b></td><td>".$employee->getCustom7()."&nbsp;</td></tr>
 <tr><td><b>SUB LOCATION:</b></td><td>".$employee->getCustom8()."&nbsp;&nbsp;&nbsp;</td><td><b>VILLAGE:</b></td><td>".$employee->getCustom9()."&nbsp;</td></tr>
</table>
<p><br />
</p>

<p><b><u>LETTER OF APPOINTMENT FOR NON-UNIONISABLE EMPLOYEES</u></b></p>

<p>This letter confirms your appointment as an employee of on the following terms and condition of service.</p>

<p><b>DUTIES: </b></p>

<p>You will be employed initially as a/an  <b>".$employeeduty."</b> but your function and duties may be altered at the discretion of the Management.</p>

<p><b>DATE OF COMMENCEMENT: </b></p>

<p>You will be required to commence employment with effect from ..".date("d-m-Y",strtotime($employee->getJoinedDate()))."...</p>

<p><b>SALARY: </b></p>

<p>You will be paid in arrears at the end of each month as a consolidated salary of Kshs......<b>".number_format($salarysum)."</b>...... including House Allowance</p>

<p><b>PROBATION: </b></p>

<p>You will be on Probation in the first instance for a period of 6 months which may be extended for further period according to the discretion of the management during which time 15 days notice or pay in lieu of either side will be required</p>

<p><b>LEAVE: </b></p>

<p>On completion of twelve months’ Service, you will be eligible for 24 days paid leave. All leave to be taken at the discretion of the Management.</p>

<p><b>WORKING HOURS: </b></p>

<p>Your working hours will be 48 hours per week. The Management from time to time depending on the organization’s operational needs will determine the time of reporting and departure from work.</p>

<p><b>CONFIDENTIAL MATTERS: </b></p>

<p>You will not, without the written consent of the Company, disclose any of its secrets or other confidential matters to anyone.</p>

<p><b>TERMINATION OF EMPLOYMENT: </b></p>

<p>At any time after satisfactory completion of your probationary service, the Company shall be entitled to terminate this agreement by giving you one Month notice in writing or to pay one month salary in lieu of such notice. This is without prejudice of the Company’s right to terminate the employment summarily for a lawful cause. <br><br>If during your period of service, you would wish to leave the service of Company, you must give the Company one-month notice of your intention or forfeit your salary for the period by which your notice falls short of.</p>

<p><b>STANDING ORDERS: </b></p>

<p>You are required to make yourself familiar with, and abide by such standing orders as shall from time to time be issued by the Company.You will not, without the consent of the Management of the company engage in any other business or occupation, which would be in conflict with your duties as a full time employee of the Company.This letter is sent to you in duplicate and we shall be grateful if you sign one copy and return it to us signifying that you have accepted the above terms and conditions.When reporting on duty, please produce the following:</p>



<p><br />
</p>

<p>Copies of Academic & Professional certificates</p>

<p>Copy of Identity Card</p>

<p>2 Colored Passport size photos</p>

<p>Copy of National Social Security Fund Card</p>

<p>Copy of National Hospital Insurance Fund Card</p>

<p>Copy KRA PIN</p>

<p>Certificate of Good Conduct</p>

<p>Salary remittance bank account details</p>

<p><br />
</p>

<p>Yours faithfully,</p>

<p><b>FOR ".strtoupper($organisationinfo["name"]).": </b></p>

<p><br />
</p>

<p><br />
</p>

<p><b>HUMAN RESOURCES MANAGER</b></p>

<p><b>DECLARATION:</b></p>

<p>I hereby accept the above-mentioned Terms and Conditions of employment, which have been read and understood by me.</p>

<p><b>EMPLOYEE’S NAME: ___________".strtoupper($empnames)."_____________</b></p>

<p><br />
</p>

<p><br />
</p>

<p><b>SIGNATURE: _____________________________ DATE: ______".date('d-m-Y')."_____________</b></p></div>
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
        $organisationdao=new OrganizationDao();
               $organisationinfo= $organisationdao->getOrganizationGeneralInformation();
        $logopath=sfConfig::get('sf_upload_dir') . "\assets"."\\".$organisationinfo["letter_head"];
  
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
$pdf->SetHeaderMargin(10);
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
$pdf->Image($logopath,10,0,150,30);

$pdf->SetFont('helvetica', '',10);   
      $tbl = <<<EOD
        
       <br><br>
<table  width="99%" cellspacing="0" cellpadding="2" style="white-space: nowrap !important;" id="pdftable"><tr><td style="text-align:justify">$html</td></tr></table>
        
EOD;

      //write page
      $pdf->writeHTML($tbl, true, false, false,true, '');
      $pdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf','F');

$url = "http://".$_SERVER["HTTP_HOST"].'/ohrm/symfony/pdfs/'.$rand.".pdf";

return $url;

    }
  

}