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
class emailDocsAction{

    private $moduleService;



    public function execute() {
//        require_once('../tcpdf/config/tcpdf_config.php');
//       require_once('../tcpdf/tcpdf.php');
//                   $pdf->SetProtection(array(),$employee->emp_dri_lice_num, null, 0, null);
//             $file=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/pdfs/".$rand.'.pdf','F');
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
