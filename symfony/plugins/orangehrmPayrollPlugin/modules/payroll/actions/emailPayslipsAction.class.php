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
class emailPayslipsAction extends payrollActions {

    private $moduleService;

    public function getModuleService() {

        if (!($this->moduleService instanceof ModuleService)) {
            $this->moduleService = new ModuleService();
        }

        return $this->moduleService;
    }

    public function setModuleService($moduleService) {
        $this->moduleService = $moduleService;
    }

    public function execute($request) {
        require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
        $empnumbers = $request->getParameter("id");
        $allslips = array();
        $month = $request->getParameter("month");
        $employees = explode(",", $empnumbers);

        foreach ($employees as $empno) {
            if (is_numeric($empno)) {
                $employeedata = EmployeeDao::getEmployeeByNumber($empno);

                $employeeslip = PayslipTable::getPayslipForMonth($empno, $month);
                // $body="<table>";




                if (is_object($employeeslip)) {
                    array_push($allslips, $employeeslip->getId());
                }
            }
        }

        $organization = new OrganizationDao();
        $organizationinfo = $organization->getOrganizationGeneralInformation();
   
$emails=array();
$message = Swift_Message::newInstance();
   $this->getMailer()->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));

        foreach ($allslips as $slipid) {


            
            $newdata='<table>
                      <tr>
                          
                          <td colspan="2" style="text-align:center">
                              <h3  style="text-align:center">'.strtoupper($organizationinfo->getName()).'</h3>
                                            <h3 style="text-align:center">'. __("PAYSLIP").'</h3>';
            ?>
                                            <?php $employeedao=new EmployeeDao();
                                            $slipdata=  PayslipTable::getPayslipById($slipid);
                                            $employeeinfo=$employeedao->getEmployee($slipdata->getEmpNumber());
                                           $salarycomponents=$employeedao->getEmployeeSalaries($slipdata->getEmpNumber());
                                        $payslipitems=  PayslipItemsTable::getItemsFromPayslipNo($slipdata->getPayslipNo());
                                            ?>
         <?php $newdata.= __(" DEPARTMENT:".$slipdata->getDepartment()).
         ' <br>'. __("MONTH ".$month).'&nbsp;&nbsp;'.
          '<br>'.__("PAYROLL# ".$employeeinfo->getEmployeeId()).'<br>'.
           '<center style="border-bottom:1px dotted black">'.__("NAME:".strtoupper($employeeinfo->getEmpFirstname().' '.$employeeinfo->getEmpMiddleName().' '.$employeeinfo->getEmpLastname() )).'</center>
           <br>
          
                              
                          </td>
                          
                      </tr>
                      <tr><td style="text-align:left;font-weight:bold" colspan="2">'. __("TIME UNITS").
         '</td></tr>
                      <tr><td style="text-align:left;">'.__("DAYS PAID").
                          '</td><td style="text-align:right">'.$slipdata->getPaidDays().'</td></tr>
                             <tr><td style="text-align:left;font-weight:bold" colspan="2">'.__("EARNINGS").
         '</td></tr>
                             <tr>';
         ?>
                                  <?php 
//                                  foreach ($salarycomponents as $component) {
//                                      
//             $newdata.='<td style="text-align:left">'.strtoupper($component->getSalaryComponent()).'</td><td style="text-align:right">'.number_format($component->getAmount(),0).'</td></tr>' ;
//          
//           }
           
                                $newdata.='<td style="text-align:left">BASIC PAY</td><td style="text-align:right">'.number_format($slipdata->getBasicPay(),0).'</td></tr>' ;
                                    $newdata.=  '<td style="text-align:left">HOUSE ALLOWANCE</td><td style="text-align:right">'.number_format($slipdata->getHouseAllowance(),0).'</td></tr>' ;
                                         foreach ($payslipitems as $item) {
                if($item["is_earning"]==1){
                    ?>
 <?php $newdata.= '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],0).'</td></tr>' ?>
                  
           <?php      }
              
           }?> 
                            <?php $newdata.='</tr>
                              <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000">'. __("GROSS PAY").
                                                   '</td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000">'.number_format($slipdata->getGrossPay(),0).'</td></tr>
                      <tr><td style="text-align:left;" colspan="2"><br></td></tr>
                              <tr><td style="text-align:left;font-weight:bold" colspan="2">'. __("DEDUCTIONS").
         '</td></tr>
                             <tr>';
                                  foreach ($payslipitems as $item) {
                if($item["is_deduction"]==1){
                    
  $newdata.='<tr><td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],0).'<br></td></tr>';
                   
               }
               
           }
           ?>
                                 <?php foreach ($payslipitems as $item) {
                if($item["is_loan"]==1){ ?>
                   
     <?php $newdata.=  '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],0).'</td></tr>' ?>
                    
           <?php      }
               
           }  
                             '</tr>';
                            $newdata.= '<tr><td style="text-align:left;" colspan="2"><br></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold">'.__("T.DEDUCTIONS").'
                                                   </td><td style="text-align:right;font-weight:bold">'.number_format($slipdata->getTotalDeductions(),0).'</td></tr>
                      
                                               <tr><td style="text-align:left;font-weight:bold" colspan="2"> <br>'. __("RELIEFS").'</td></tr>';
              foreach ($payslipitems as $item) {
                if($item["item_type"]=="relief"){ ?>
                  
    <?php $newdata.=   '<tr><td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.$item["amount"].'</td></tr>' ?>
                   
           <?php      }
               
           
           }?>  
                                               
                                              <?php $newdata.=  '<tr><td style="text-align:left;font-weight:bold;border-bottom:1px solid #000">'. __("NET PAY:").'</td>  <td style="text-align:right;font-weight:bold;border-bottom:1px solid #000">'.number_format($slipdata->getNetPay(),0).'</td></tr>                  
                                                       <tr><td style="text-align:left;" colspan="2"><br></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold">'.__("STAFF LOAN").'</td><td style="text-align:right;font-weight:bold">';?>
                                                     <?php
                                                     $balance=0;
                           $emploans=  LoanAccountsDao::getEmpLoanAccounts($slipdata->getEmpNumber());
                            $allinterests=0;
                           foreach ($emploans as $emploan){
                           $loanaccount=$emploan;
                        $loantransactiondao=new LoanTransactionsDao();
            
             $loanbalance= $loantransactiondao->getLoanBalance($emploan->getId());
                     $balance=$loanbalance+$balance;
                           } 
                           $newdata.=number_format($balance);
                           ?>
                                                              
                                                                      
                                                 <?php  $newdata.='</td></tr>   
                                                <tr><td style="text-align:left;" colspan="2"></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold" colspan="2">';
                                                       ?>
                                                              
                <?php $employeedirectdebit=EmpDirectdebitTable::getEmployeeBankAndBranch($slipdata->getEmpNumber())?>                 
                   <?php $newdata.=$employeedirectdebit["bankandbranch"]?>  

<?php $newdata.='</td>   </tr>
                                                            <tr><td style="text-align:left;font-weight:bold">'. __("ACCOUNT NO").'</td><td style="text-align:right;font-weight:bold" >'.$employeedirectdebit["account_number"].'</td></tr>    
           <tr><td style="text-align:left;font-weight:bold" colspan="2">   <h3 style="border-bottom:1px dotted black;border-top:1px dotted black;text-align:left" >'. __("PIN #:").'<span>';?>
          <?php $employee=EmployeeDao::getEmployeeByNumber($slipdata->getEmpNumber());
                        $newdata.= $employee->getEmpOtherId();?>
                 <?php $newdata.='</span>
                   </h3>  </td></tr>
                   
                                                   </tr>                               
                  <tr><td style="text-align:left;font-weight:bold" colspan="2">SIGNATURE.............. <br>  <br>  <br>  <br>  <br><br>      </td> </tr>                               
                <tr><td style="text-align:left;font-weight:bold" colspan="2">Powered by www.techsavanna.technology</td> </tr>   
                  </table>';
            
            $tbl = <<<EOD
        
       
 $newdata
        
EOD;


            $data = array("toemail" =>$employee->getEmpWorkEmail(), "subject" => "Payslip for " . $month, "body" => $newdata);
            
            
            //pdf
            
            $pdf=$this->getPdfInstance();
  
    $pdf->AddPage("P");
$pdf->SetFont('helvetica', '',11);
            $rand=  rand(100,1000000);
          
            $pdf->writeHTML($tbl, true, false, false, false, '');
            $pdf->SetProtection(array(),$employee->emp_dri_lice_num, null, 0, null);
             $file=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf','F');
               $message = Swift_Message::newInstance()
                ->setFrom('info@shiloahmega.com')
              
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
     
//            $message->setFrom('payroll@shiloahmega.com')
//              // ->setTo("krufed@gmail.com")
//                ->setTo($data["toemail"])
//                ->setSubject($data["subject"])
//                ->setBody($data["body"], 'text/html');
//        array_push($emails,$employee->getEmpWorkEmail());
//        $this->getMailer()->send($message);
        }
      

        $this->getUser()->setFlash('success', __('Payslips have been sent to respective mailboxes'));

        $this->redirect('payroll/processPayroll');


        $this->organisationinfo = $organizationinfo;
        $this->allslips = $allslips;
        $this->month = $month;

        //send emails
    }

    protected function _checkAuthentication() {

        $user = $this->getUser()->getAttribute('user');

        if (!$user->isAdmin()) {
            $this->redirect('payroll/processPayroll');
        }
    }

    protected function _resetModulesSavedInSession() {

        $this->getUser()->getAttributeHolder()->remove('admin.disabledModules');
        $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
    }

    protected function emailSlip($data) {
        $message = Swift_Message::newInstance()
                ->setFrom('admin@techsavanna.technology')
              // ->setTo("krufed@gmail.com")
                ->setTo($data["toemail"])
                ->setSubject($data["subject"])
                ->setBody($data["body"], 'text/html');
     
        $this->getMailer()->send($message);
    }
    
    
    function pdfEncrypt ($origFile, $password, $destFile){
//include the FPDI protection http://www.setasign.de/products/pdf-php-solutions/fpdi-protection-128/
require_once('fpdi/FPDI_Protection.php');

$pdf =& new FPDI_Protection();
// set the format of the destinaton file, in our case 6×9 inch
$pdf->FPDF('P', 'in', array('8.27','11.69'));

//calculate the number of pages from the original document
$pagecount = $pdf->setSourceFile($origFile);

// copy all pages from the old unprotected pdf in the new one
for ($loop = 1; $loop <= $pagecount; $loop++) {
$tplidx = $pdf->importPage($loop);
$pdf->addPage();
$pdf->useTemplate($tplidx);
}

// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
$pdf->SetProtection(array(), $password,$password);
$pdf->Output($destFile, 'F');

return $destFile;
}



public function getPdfInstance(){
               $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shiloah HRM');
$pdf->SetTitle('Payslip');
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
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

return $pdf;
}



}
