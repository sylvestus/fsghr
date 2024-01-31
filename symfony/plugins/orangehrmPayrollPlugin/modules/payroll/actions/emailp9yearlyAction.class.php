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
class emailp9yearlyAction extends payrollActions {

    public function execute($request) {
        require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');

        $emps = $request->getParameter("id");
        $employeesunfiltered = explode(",", $emps);
        $payrollmonth = $_REQUEST["month"];
        $month = $_REQUEST["month"];
        $date = DateTime::createFromFormat("m/Y", $month);
        $employees = array();

        $monthsyear = array();
        $monthc = 0;
        
        $imagePath = theme_path("images");
        $i = (int) $date->format("m");

$year=$date->format("Y");

        while ($monthc <= $i) {
            if ($monthc < 10) {
                $dateyear = "0" . $monthc . '/' . $date->format("Y");
            } else {
                $dateyear = $monthc . '/' . $date->format("Y");
            }
            array_push($monthsyear, $dateyear);
            //$employeeslip= PayslipTable::getPayslipForMonth($empno,$date->format("Y")); 
            $monthc++;
        }

        //filter employees
        foreach ($employeesunfiltered as $empno) {
            if (is_numeric($empno)) {
                array_push($employees, $empno);
            }
        }


        $organization = new OrganizationDao();
        $organizationinfo = $organization->getOrganizationGeneralInformation();
        

        $this->year = $date->format("Y");
        
        
         $html='<div class="inner">';

       
        //$month = $_REQUEST["month"];
        $multiplying=  substr($month,0,2);
       // die(print_r($employees));
        
        $message = Swift_Message::newInstance();
   $this->getMailer()->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
        foreach ($employees as $empno) {
            
       
            $html.='<div id="dvData">';
     $employee = EmployeeDao::getEmployeeByNumber($empno);
                $html.='<input type="hidden" class="carbenefit" value="'.round($multiplying*$employee->getVehicleBenefit()).'">
                <input type="hidden" class="workemail" value="'.$employee->emp_work_email.'">
                <table class="table hover data-table displayTable  tablestatic" style="font-size:10px;" id="recordsList'.$empno.'">
                  
                        <tr>

                            <td class="boldText borderBottom"></td>
                            <td class="boldText borderBottom" style="font-weight:bold;font-size:20px">P9A</td>
                            <td class="boldText borderBottom"></td>
                   <td class="boldText borderBottom" colspan="8" style="text-align:center;font-weight:bold;"><img src="'.$imagePath.'/kra.png"><br>Kenya Revenue Authority<br><?=strtoupper("Domestic Tax Department")?><br><span style="color:red">'.strtoupper("Income Tax Deduction Card");
    
    $date = LoanAccountsDao::getMonthFromDate($month);
    $html.=$date.'</span></td>


                             <td class="boldText borderBottom"></td>
                            
                            <td class="boldText borderBottom"></td>
                            <td class="boldText borderBottom"></td>


                        </tr>

                        <tr><td colspan="3" style="font-weight:bold">Employers Name</td><td colspan="4">'.strtoupper($organizationinfo->getName()).'</td><td colspan="4" style="font-weight:bold">Employer\'s P.I.N</td><td colspan="3">'.$organizationinfo->getTaxId().'</td></tr>'
                  
                        .'<tr><td colspan="3" style="font-weight:bold">Employees Main Name</td><td colspan="4">'.$employee->getEmpFirstname() . "&nbsp;" . $employee->getEmpMiddleName() . "&nbsp;" . $employee->getEmpLastname().'</td><td colspan="4" style="font-weight:bold">Employees P.I.N</td><td colspan="3">'.$employee->getEmpOtherId().'</td></tr>
                        <tr >

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">MONTH </td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">BASIC SALARY</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">BENEFITS NON-CASH</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">VALUE OF QUARTERS</td>

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">TOTAL GROSS PAY</td>

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;" colspan="3">DEFINED CONTRIBUTION RETIREMENT SCHEME</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">OWNER OCCUPIED INTEREST</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">RETIREMENT CONTRIBUTION&OWNER OCCUPIED INTEREST</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">CHARGEABLE PAY KSHS</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">TAX ON (H) KSH</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;">MONTHLY RELIEF KSHS</td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;border-right:1px solid #000;font-size:9px;">PAYE TAX (J-K) KSHS</td>


                        </tr>
                    
                    <tbody >
                        <tr><td style="border-bottom:1px solid #000;border-left:1px solid #000"></td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">A</td><td style="border-bottom:1px solid #000;border-left:1px solid #000" class="boldText">B</td><td style="border-bottom:1px solid #000;border-left:1px solid #000" class="boldText">C</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">D</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center" colspan="3">E</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">F</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">G</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">H</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">I</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">J</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000">K</td></tr>
                        <tr><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;">E1</td><td style="border-right:1px solid #000;border-bottom:1px solid #000;">E2</td><td style="border-right:1px solid #000;border-bottom:1px solid #000;">E3</td><td style="border-bottom:1px solid #000;font-size:8px">AMOUNT OF INTEREST</td><td style="border-bottom:1px solid #000;border-left:1px solid #000;font-size:8px ">THE LOWEST E <br> ADDED TO F</td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000"></td></tr>';
                       
    foreach ($monthsyear as $monthyear) {
        $slip = PayslipTable::getPayslipForMonth($empno, $monthyear);
        if (is_object($slip)) {
            //$html.= $monthyear;
            
                        $html.='<tr><td style="font-size:10px;border-left:1px solid #000;border-bottom:1px solid #000;">';
                                $eachdate =LoanAccountsDao::getMonthFromDate($monthyear);
                                $html.=$eachdate["month"];
                             
                                $basicpay =$slip->basic_pay;// HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
            $hallowance =$slip->house_allowance;// HsHrEmpBasicsalaryTable::getEmpHouseAllowance($empno);

            $grosspay = $hallowance + $basicpay;
            $totalgross+=$grosspay;
            $totalbasic+=$totalbasic;
          
                            $html.='</td>   <td  style="border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($grosspay).'</td>
                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
                                        0
                                    </td>
                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
                                        0

                                    </td>

                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($grosspay).'</td>
                                    
                                    <td style="border-bottom:1px solid #000;border-left:1px solid #000">'.number_format(ceil(0.3 * $grosspay)).'</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;">'.number_format($slip->nssf).'</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">0</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">0</td><td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($slip->getNssf()).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($slip->getTaxableIncome()).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format(($slip->getNettaxPayable() + $slip->getPersonalRelief()), 0).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($slip->getPersonalRelief()).'</td>
                            <td style="border-right:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;text-align:right">'.number_format($slip->getNettaxPayable()).'</td>
                        
                        </tr>';
                                       
                                        $totalnssf+=$slip->nssf;
                                        $totaltaxable+=$slip->getTaxableIncome();
                                        $totalrelief+=$slip->getPersonalRelief();
                                        $totaltaxpayable+=$slip->getNettaxPayable();
                                    }
                                }
                                $html.='<tr><td style="font-weight:bold;border-bottom:1px solid #000;border-left:1px solid #000 ">TOTALS</td>   
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:left">'.number_format($totalgross, 0).'</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">
                                0
                            </td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">
                                0

                            </td>

                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($totalgross, 0).'</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:left;text-align:left">'.round(ceil(0.3 * $totalgross)).'</td>
                            <td  style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000;text-align:left">'.number_format($totalnssf, 0).'&nbsp;</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">0</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">0</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($totalnssf, 0).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($totaltaxable, 0).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format(($totaltaxpayable + $totalrelief), 0).'</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">'.number_format($totalrelief, 0).'</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;text-align:right">'.number_format($totaltaxpayable, 0).'</td></tr>
                        
                       
                        <tr><td colspan="4" style="font-weight:bold">To be completed by employer at the end of the year</td><td colspan="3"></td><td colspan="6">&nbsp;TOTAL TAX COL (J)&nbsp;&nbsp;Kshs.'.number_format($totaltaxpayable, 0).' </td></tr>
                        <tr><td colspan="8" style="font-weight:bold">TOTAL CHARGEABLE PAY (COL H)&nbsp;KSHS.&nbsp;'.number_format($totaltaxable, 0).'</td><td colspan="6">(b)Attach <br>(i)Photostat copy of interest certificate and statement of account from financial institution<br>(ii)The declaration duly signed by the employee</td></tr>
                        <tr><td colspan="8" style="font-weight:bold">IMPORTANT</td><td colspan="6"></td></tr>
                        <tr><td colspan="8" style="font-weight:bold">1)Use P9A (a)For all liable employees and where director/employee receives<br>benefits in addition to cash emoluments<br>
                                (b)Where an employee is eligible to deduction and owner occupier interest </td>
                            <td colspan="6">NAMES OF FINANCIAL INSTITUTION ADVANCING MORTGAGE LOAN----------------------------------------------------------------<br>
                                L.R NO OF OWNER OCCUPIED PROPERTY---------------------------------<br>
                            DATE OF OCCUPATION OF HOUSE----------------------------------</td></tr>

                      
                    </tbody>
                </table><br>
                
                
                
            </div>';
            
            unset($totalbasic);
            unset($totalgross);
            unset($totalnssf);
            unset($totalrelief);
            unset($totaltaxable);
            unset($totaltaxpayable);
       
       
  $html.= '</div>';
        
  
        



  


// -----------------------------------------------------------------------------

//Close and output PDF document or email

    $employersname=  strtoupper($organizationinfo->getName());
    $address=  strtoupper("P.O BOX ".$organizationinfo->getStreet1()."-".$organizationinfo->getZipCode().",".$organizationinfo->getCity());
    //car benefit
     $carbenefit=  number_format(round($multiplying*$employee->getVehicleBenefit()),2);
    
   
  
  $html2='<table width="100%" >
                    <tr><td colspan="3"></td></tr>
                    <tr><td colspan="3"><b>INFORMATION REQUIRED FROM THE EMPLOYER AT THE END OF THE YEAR</b></td></tr>
          <tr><td colspan="2">Date Employee commenced if during the year................................</td><td></td></tr>
        <tr>2)<td colspan="2">Date left if during the year................................</td><td></td></tr>                    
                
         <tr> <td colspan="2">Name and address of new employer................................</td><td></td></tr>
          
        <tr>  <td colspan="2">Where housing is provided,state monthly rent charged KES............................per month<br></td><td></td></tr>
       <tr>   <td colspan="2">Where any of the pay related to a period other than this year, eg.Gratuity (give details of amounts,year and tax)</td><td> 
           <table border="1">
           <tr><td>Year</td><td>Amount</td><td>Sh</td></tr>
          <tr><td>20</td><td></td><td></td></tr>
          <tr><td>20</td><td></td><td></td></tr>
          <tr><td>20</td><td></td><td></td></tr>
          <tr><td>20</td><td></td><td></td></tr>
           </table></td></tr>
   <tr>  <td colspan="3">FOR MONTHLY RATES OF BENEFITS PLEASE REFER TO EMPLOYERS GUIDE TO P.A</td></tr>   
        <tr>  <td colspan="3"><b>CALCULATION OF TAX BENEFITS</b></td></tr>
          <table border="1">
           <tr><td>BENEFIT</td><td>NO</td><td>RATE</td><td>NO OF MONTHS</td><td>TOTAL AMOUNT</td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td></tr>
           </table>
           <tr>  <td colspan="3"></td></tr>
   <tr>  <td colspan="3">Where actual cost is higher than given monthly rates of benefits then actual cost is brought to charge in full</td></tr>
            <tr><td colspan="3"><b>LOW INTEREST RATE BELOW PRESCRIBED RATE OF INTEREST</b></td></tr>
            <tr><td colspan="2">EMPLOYERS LOAN</td><td>=Ksh ................@..........Rate</td></tr>
          <tr><td colspan="2">RATE DIFFERENCE</td><td></td></tr>
          <tr><td colspan="2">PRESCRIBED RATE-EMPLOYERS RATE=</td><td>...........%</td></tr>
          <tr><td colspan="2">MONTHLY(RATE DIFFERENCE*LOAN)=</td><td>...........% X KSH</td></tr>
          <tr><td colspan="2">MOTOR CARS</td><td>...........% X KSH</td></tr>
           <tr><td>Upto</td><td>1500c.c =</td><td></td>.............</tr>
             <tr><td>1501c.c</td><td>1750c.c =</td><td>..............</td></tr>
          <tr><td>1751c.c</td><td>2000c.c =</td><td>..............</td></tr>
          <tr><td>2001c.c</td><td>3000c.c =</td><td>..............</td></tr>
          <tr><td colspan="2">Total Benefit in Year</td><td style="font-weight:bold"><u>&nbsp;&nbsp;Ksh '.$carbenefit.'&nbsp;&nbsp;</u></td></tr>
          <tr>  <td colspan="3">If this amount does not agree with total of Col B overleaf,attach explanation</td></tr>
          <tr>  <td colspan="3">FOR PICKUPS,PANEL VANS AND LAND ROVERS REFER TO APPENDIX 5 OF EMPLOYERS GUIDE</td></tr>
          <tr>  <td colspan="3">CAR BENEFIT-The higher the amount of fixed monthly rate of the prescribed rate of benefits is to be brought to charge:</td></tr>
          <tr>  <td colspan="3">PRESCRIBED RATE:   1996-1% Per month of initial vehicle cost</td></tr>
          <tr>  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  1997-1.5% Per month of initial vehicle cost</td></tr>
          <tr>  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  1998-2% Per month of initial vehicle cost</td></tr>
          <tr>  <td colspan="3"><center><b>EMPLOYERS CERTIFICATE OF THE PAY AND TAX</b></center></td></tr>
          <tr>  <td colspan="3">NAME: <U>'.$employersname.'</U></td></tr>
          <tr>  <td colspan="3">ADDRESS: <U>'.$address.'</U></td></tr>
              <tr> <td colspan="2">SIGNATURE:............................................................</td><td >STAMP:........................................................</td></tr>
          <tr>  <td colspan="3">*Employer\'s certificate to be signed by the person who submits to the PAYE End Of Year Returns and a copy of the P9A to be issued to the employee in January </td></tr>
   </table>';
        
     $rand=  rand(100,1000000);
         // always load alternative config file for examples


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Savanna HRM');
$pdf->SetTitle('Report');
$pdf->SetSubject('Custom Report');
$pdf->SetKeywords('TCPDF, PDF, report, test, guide');
$pdf->setPrintHeader(FALSE);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO,"", PDF_HEADER_TITLE.': REPORT #'.$rand, "");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT,"", PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(3);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
  
 $pdf->AddPage("L");
   
$pdf->SetFont('helvetica', '',11);

$pdf->writeHTML($html, true, false, false, false, '');

$pdf->AddPage("L");
$pdf->SetFont('helvetica', '',9);
$pdf->writeHTML($html2, true, false, false, false, '');
 //$filee=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf','I');

$path=$_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf';
  $FILE=$pdf->Output($path,'F');
 $toemail=$employee->emp_work_email;
  //echo $html;
    $message = Swift_Message::newInstance()
                ->setFrom('info@shiloahmega.com')
               //->setTo("krufed@gmail.com")
                ->setTo($toemail)
                ->setSubject(strtoupper("P9 Report for the year ".$year))
         ->attach(Swift_Attachment::fromPath($path)
                        );
     echo "Sending emails for ".$employee->getEmpFirstname() . "&nbsp;" . $employee->getEmpMiddleName() . "&nbsp;" . $employee->getEmpLastname().",please wait...........";
     
   //  $mmesagesent=$this->getMailer()->send($message);
        if($this->getMailer()->send($message)){
           $this->getUser()->setFlash('success', __('Successfully emailed p9  for ' . $monthyear));

            $this->redirect('payroll/processPayroll');
        } else{
                 $this->getUser()->setFlash('error', __('Encountred an error,please try again'));

            $this->redirect('payroll/processPayroll');
        }
 
       }  
      exit();   
    }

}
