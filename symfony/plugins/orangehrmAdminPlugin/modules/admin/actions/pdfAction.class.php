<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., https://www.techsavanna.technology
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
class pdfAction extends baseAdminAction {

   
    public function execute($request) {
   require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
              
       if($request->getPostParameters()) {
           $post=$request->getPostParameters();
          $html=$post["data"];
          $payslip=$post["payslip"];
          $p9=$post["p9"];
       $nssfnhif=$post["nssfnhif"];
       $register=$post["register"];
       $email=$post["email"];
          //send email function
         
          
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


// -----------------------------------------------------------------------------
if($payslip){
    
    $pdf->AddPage("L");
$pdf->SetFont('helvetica', '',11);
    
$tbl = <<<EOD
        
       
 <table cellpadding="4"  id="recordsList" style="font-size:11px;"  >$html</table>
        
EOD;
       }
       else if($p9){
    
    $pdf->AddPage("L");
$pdf->SetFont('helvetica', '',11);
    
$tbl = <<<EOD
        
       
 <table cellpadding="4"  id="recordsList" style="font-size:11px;"  >$html</table>
        
EOD;


       }
       
       
  else if($nssfnhif)  {
    $pdf->AddPage("P");
$pdf->SetFont('helvetica', '',10);   
      $tbl = <<<EOD
        
       <br><br>
<table border="1" width="99%" cellspacing="0" cellpadding="2" style="white-space: nowrap !important;" id="pdftable">$html</table>
        
EOD;
      
  } 
  
   else if($register)  {
    $pdf->AddPage("P");
$pdf->SetFont('helvetica', '',7);   
      $tbl = <<<EOD
        
       <br><br>
<table border="1" width="99%" cellspacing="0" cellpadding="2" style="white-space: nowrap !important;" id="pdftable">$html</table>
        
EOD;
  } 
  
else if($p9){
    $pdf->AddPage("L");
$pdf->SetFont('helvetica', '',12);
$tbl = '<br><br>
<table border="1" width="99%" cellspacing="0" cellpadding="2" style="font-size:12px;white-space: nowrap !important;" id="pdftable">$html</table>';
        

}

else{
        $pdf->AddPage("L");
$pdf->SetFont('helvetica', '',12);
$tbl = <<<EOD
        <br><br>
<table border="1" width="99%" cellspacing="0" cellpadding="2" style="font-size:12px;white-space: nowrap !important;" id="pdftable">$html</table>
        
EOD;
}
$pdf->writeHTML($tbl, true, false, false, false, '');

 $tbl2="";

if($p9){
    $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
    $employersname=  strtoupper($organizationinfo->getName());
    $address=  strtoupper("P.O BOX ".$organizationinfo->getStreet1()."-".$organizationinfo->getZipCode().",".$organizationinfo->getCity());
    //car benefit
     $carbenefit=number_format($post["carbenefit"],2);
    
    
   $pdf->AddPage("L");
   $pdf->SetFont('helvetica', '',9);
  $tbl2='<table width="100%" >
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
        



  $pdf->writeHTML($tbl2, true, false, false, false, '');
  $filee=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/fgshr/symfony/pdfs/".$rand.'.pdf','F');
  //   $pdf->writeHTML($htmll, true, false, false, false, '');

   
}


// -----------------------------------------------------------------------------

//Close and output PDF document or email
  if($request->getParameter("sendemail")=="true" ){
    
    $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
    $employersname=  strtoupper($organizationinfo->getName());
    $address=  strtoupper("P.O BOX ".$organizationinfo->getStreet1()."-".$organizationinfo->getZipCode().",".$organizationinfo->getCity());
    //car benefit
     $carbenefit=number_format($post["carbenefit"],2);
    
    if(isset($p9)){
   $pdf->AddPage("L");
   $pdf->SetFont('helvetica', '',9);
  $tbl2='<table width="100%" >
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
        



  $pdf->writeHTML($tbl2, true, false, false, false, '');
    }
  //$filee=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/fgshr/symfony/pdfs/".$rand.'.pdf','F');
  //   $pdf->writeHTML($htmll, true, false, false, false, '');

   

      
      
      $emailto="krufed@gmail.com";
      
   
      $path=$_SERVER['DOCUMENT_ROOT']."/fgshr/symfony/pdfs/".$rand.'.pdf';
       $FILE=$pdf->Output($path,'F');
   
      if($email){
          $emailto=$email;
      }
     


               $message = Swift_Message::newInstance()
                ->setFrom('info@shiloahmega.com')
               //->setTo("krufed@gmail.com")
                ->setTo($emailto)
                ->setSubject(strtoupper($request->getParameter("report")))
         ->attach(Swift_Attachment::fromPath($path)
                        );
     
        if($this->getMailer()->send($message)){
            echo "Successfully sent email";
        } else{
                 echo "Could not send email";
        }
        exit();
       } 
       else{

$pdf->Output($_SERVER['DOCUMENT_ROOT']."/fgshr/symfony/pdfs/".$rand.'.pdf','F');

$url = "https://".$_SERVER["HTTP_HOST"].'/fgshr/symfony/pdfs/'.$rand.".pdf";

echo $url;
       }
exit();
       }

              else {

      $this->getUser()->setFlash('error', __('Invalid data to write'));
 }
        
    }
    
    
       public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
        }
        return $this->configService;
    }


}