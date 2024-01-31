<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
/**
 * SavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 SavannaHRM Inc., http://www.orangehrm.com
 *
 * SavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * SavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/**
 * viewSalaryAction
 */
class printTerminationAction extends basePimAction {

    public function execute($request) {

    $terminationid= $request->getParameter('id');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
$pdo = $q->execute("SELECT * from ohrm_emp_termination where id='$terminationid'");
$pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
$terminationdetails=$pdo->fetchObject();


$this->generateTerminationReport($terminationdetails);


}

 public function generateTerminationReport($terminationrecord){
   //die(print_r($terminationrecord));
           require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
       // $pdf->AddPage('L', 'A5');
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);	
        $pdf->SetAutoPageBreak(TRUE, 0);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        $pdf->SetMargins(PDF_MARGIN_LEFT, '', PDF_MARGIN_RIGHT);
        // set default footer margin
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);   
/***************required info*********************/
       $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $employeedetails=  EmployeeDao::getEmployeeByNumber($terminationrecord->emp_number);
           if($terminationrecord->one_month_pay >0){
       $empsalary=  @PayrollMonthTable::getEmpSalary($terminationrecord->emp_number);
           }
           else{
               $empsalary=0;
           }

try{
   

    $bottom='';    
    $pdf->AddPage();	
    $pdf->ln(7);
   $pdf->SetFont('times');
    $pdf->writeHTML('<table style="line-height: 1.2px;letter-spacing:+0.100mm;">'
            . '<tr><th colspan="2" width="70%" style="width: 50%;font-stretch:80%;text-align:right;font-size:20px;font-weight:bold;">'.strtoupper($organizationinfo->name).'.</th><th style="text-align:right;"><img src="'.theme_path('images/megaicon.png').'"  width="42" height="42" ><br><br><br></th></tr>
        <tr style="font-size:9px" >    
			<td width="35%">P.O.Box '.$organizationinfo->street1.$organizationinfo->getZipCode().','.$organizationinfo->city.',Kenya</td>
			<td width="35%">Mega Plaza Block "B" 11th Floor</td>
			<td align="right">Tel: 057 - 2023550 / 2021269 </td> 
		</tr>
                <tr><td colspan="3">'.  str_repeat('<br>',10).'</td></tr>
              <tr style="font-size:9px" >    
			<td width="35%">E-Mail:'.$organizationinfo->email.str_repeat('<br>',15).$organizationinfo->note.'</td>
			<td width="35%">Oginga Odinga Road'.str_repeat('<br>',20).'Kisumu.</td>
			<td align="right"> Mobile: 0727944400 </td> 
		</tr>            <tr><td height="20px" colspan="3"></td></tr>
                <tr><td height="15px"><b>NAME:</b></td><td height="15px" colspan="2">'.$employeedetails->emp_firstname.'</td></tr>
                       <tr><td height="15px"><b>ADDRESS:</b></td><td height="15px" colspan="2">'.$employeedetails->emp_street1.'-'.$employeedetails->emp_zipcode.'</td></tr>
                             <tr><td height="15px"><b>TOWN:</b></td><td height="15px" colspan="2">'.$employeedetails->city_code.'</td></tr>
                                   <tr><td height="15px"><b>TEL:</b></td><td height="15px" colspan="2">'.$employeedetails->emp_mobile.'</td></tr>
</table>');
   
    


   $pdf->SetFont('times','',12);
   $pdf->writeHTML('<table width="100%">    
       <tr><td style="text-align:center"><b>REF: TERMINATION OF EMPLOYMENT</b></td></tr>
        </table>', true, false, true, false, '');
  $pdf->writeHTML('<table width="100%">    
       <tr><td style="text-align:justify">Please be advised that your employment with the company has been terminated with effect from 
        <u>'.date("d/m/Y",strtotime($terminationrecord->termination_date)).'</u>  </td></tr></table>', true, false, true, false, '');
  $earninngs=$empsalary+$terminationrecord->overtime_amount+$terminationrecord->pending_leave_amount+$terminationrecord->service_benefit_amount;
    $dues ='<table width="100%">		
   <tr><td colspan="4">Your dues are as follows:</td></tr>
        <tr><td width="3%">1. </td><td width="40%">Payment up to and including salary up to:</td><td> <u>'.$_SESSION['payrollmonth'].'</u>&nbsp;</td><td>Kshs <u>'.$empsalary.'</u></td></tr>
        <tr><td width="3%">2. </td><td width="40%">Over time  for Months </td><td><u>'.$terminationrecord->overtime_for_months.'</u> Hrs </td><td>Kshs <u>'.$terminationrecord->overtime_amount.'</u></td></tr>
        <tr><td width="3%">3. </td><td width="40%">Pending Leave </td><td><u>'.$terminationrecord->pending_leave.'</u>days </td><td>Kshs <u>'.$terminationrecord->pending_leave_amount.'</u></td></tr>
        <tr><td width="3%">4. </td><td width="40%">One Month pay in Lieu Notice </td><td></td><td>Kshs <u>'.$terminationrecord->one_month_pay.'</u></td></tr>
        <tr><td width="3%">5. </td><td width="40%">Service Benefits </td><td><u>'.$terminationrecord->service_benefit_years.'</u> years</td><td>Kshs <u>'.$terminationrecord->service_benefit_amount.'</u></td></tr>
<tr><td></td><td width="40%"><b><br>SUB TOTAL</b> </td><td></td><td><b><br>Kshs <u>'.number_format($earninngs).'</u></b></td></tr>

</table>';   
    
$pdf->writeHTML($dues, true, false, true, false, '');


if($empsalary>0){
 $nhif = NhifRatesDao::getRateFromAmount($earninngs);
 $nssf=  NssfRatesDao::getRateFromAmount($earninngs, 18000);
}
else{
    $nhif=0;
    $nssf=0;
}
 
 $paye=  @PayrollMonthTable::getEmployeePayee($terminationrecord->emp_number, $earninngs,$nssf);
 $deductionamounts=$terminationrecord->notifice_payment+$terminationrecord->salary_advance+$terminationrecord->company_loan+$paye+$nhif+$nssf;
$deductions ='<table width="100%">		
   <tr><td colspan="4"><b>DEDUCTIONS:</b></td></tr>
        <tr><td width="3%">1. </td><td width="30%">Notice payment to company:</td><td>Kshs <u>'.$terminationrecord->notifice_payment.'</u></td><td></td></tr>
        <tr><td width="3%">2. </td><td width="30%">Salary Advance</td><td>Kshs <u>'.$terminationrecord->salary_advance.'</u></td><td></td></tr>   
        <tr><td width="3%">3. </td><td width="30%">Company Loan</td><td>Kshs <u>'.$terminationrecord->company_loan.'</u></td><td></td></tr>
        <tr><td colspan="4"><b>Statutory Deductions</b></td></tr>
        <tr><td width="3%">4. </td><td width="30%">PAYE</td><td>Kshs <u>'.$paye.'</u></td><td></td></tr>
        <tr><td width="3%">5. </td><td width="30%">NHIF</td><td>Kshs <u>'.$nhif.'</u></td><td></td></tr>
        <tr><td width="3%">6. </td><td width="30%">NSSF</td><td>Kshs <u>&nbsp;'.$nssf.'&nbsp;</u></td><td></td></tr>
   <tr><td></td><td width="40%"><b><br>SUB TOTAL</b> </td><td></td><td><b><br>Kshs <u>'.$deductionamounts.'</u></b></td></tr>     
</table>';   
$pdf->writeHTML($deductions, true, false, true, false, '');
$netpay ='<table width="100%">		
   <tr><td width="3%"></td><td width="40%"><b><br>NET PAY</b> </td><td></td><td><b><br>Kshs '.number_format($earninngs-($deductionamounts)).'</b></td></tr>     
</table>';   
$pdf->writeHTML($netpay, true, false, true, false, '');
//$pdf->SetFont('dejavusans','BU',13);
$signatures ='<table width="100%" cellpadding="6">		
   <tr><td colspan="3">Please sign clearance certificate and collect Net Pay from Cashier</td></tr>
        <tr><td width="20%">Signed by: </td><td> _____________________</td><td>Existing Staff</td></tr>
        <tr><td width="20%">Witnessed by: </td><td> _____________________</td><td>HRM/HOD</td></tr>
        <tr><td width="20%">Approved by: </td><td> _____________________</td><td>DIRECTOR</td></tr>
        <tr><td width="20%">Processed by: </td><td> _____________________</td><td>FINANCE CONTROLLER</td></tr>
        
</table>';  
$pdf->writeHTML($signatures, true, false, true, false, '');


    $pdf->writeHTML($bottom, true, false, true, false, '');
  
    $pdf->SetXY(10, 270);
    $pdf->writeHTML("<hr>", true, false, true, false, '');    

            $pdf->SetXY(15, 272);
//            $pdf->Image('../images/mp_logo.jpg', '', '', 14, 14, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
//            $pdf->SetXY(95, 272);
//            $pdf->Image('../images/mc_logo.jpg', '', '', 14, 14, '', '', '', false, 200, '', false, false, 0, false, false, false);
//            $pdf->SetXY(180, 272);
//            $pdf->Image('../images/mm_logo.jpg', '', '', 14, 14, '', '', '', false, 300, '', false, false, 0, false, false, false);
            

        
    
    $companyname = $companyname."_";
    ////$pdf->Output("../../pms_docs/creditnote/".$companyname.".pdf","F");
    //$pdf->Output($invfilepath.$companyname.".pdf","F");
    $pdf->Output($companyname, 'I');
    exit;    
}
catch (Exception $err)
{
    $custom = array('result'=> "Error: ".$err->getMessage().", Line No:".$err->getLine(),'s'=>'error');
    $response_array[] = $custom;
    echo '{"error":'.json_encode($response_array).'}';
    exit;
}
    }

}