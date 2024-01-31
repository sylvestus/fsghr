<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class employeeCardAction extends basePimAction {

    private $userService;

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }
    
     /**
     * Get ConfigService
     * @return ConfigService
     */
    public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
        }
        return $this->configService;
    }

    public function execute($request) {
        require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
        $postArray = $request->getPostParameters();
                   
                // die(print_r($postArray));
                         //log in audit trail
                         $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
                       
$target_file = $target_dir.basename($_FILES["printapprove"]['name']);

 $configuration=  OhrmPayrollconfigTable::getConfig();
//die($configuration->system_url."dsds");

$issuedate=$request->getParameter("issue_date");
$expiry=$request->getParameter("expiry_date");


        $empNumber=$request->getParameter("id");
        $employeedetails = $this->getEmployeeService()->getEmployee($empNumber);
         $titledao=  new JobTitleDao(); 
                         $prevtitle=$titledao->getJobTitleById($employeedetails->job_title_code);
          //grade
                         $code=HsHrEmpBasicsalaryTable::getSalaryCode($empNumber);
                          $dao=new PayGradeDao();
                $prevgrade=$dao->getPayGradeById($code);
                
                $location = HsHrEmpLocationsTable::findEmployeeLocation($empNumber);
                        if(empty($location)){
                            $location="N/A";
                        }
                         
              $rand=  rand(100,1000000);
              $color=  $request->getParameter('color');
              $printmode=$request->getParameter('printmode');
         // always load alternative config file for examples
$returned="success";//$this->handleFile($target_file);
                if($returned=="success"){
                $trail=new AuditTrail();
                $trail->transaction_type="print";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="printcard";
                $trail->file1=$_FILES["printapprove"]['name'];
                $trail->approval_levels=1;
                $trail->previous_value=$_FILES["printapprove"]['name'];
                $trail->updated_value=$_FILES["printapprove"]['name'];
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                //$trail->save();
  //print card
  
//include("../mpdf/mpdf.php");
//
//    $mpdf = new mPDF(); 
//
//$mpdf->AddPage("L", $condition, $resetpagenum, $pagenumstyle, $suppress, $mgl);
//    $mpdf->SetDefaultBodyCSS('background', "url('$backgroundimage')");
//   
//    $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
//    $mpdf->WriteHTML("Some Html ");
//
//    $mpdf->Output($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/web/uploads".$rand.'.pdf','I');
    //$img = new Imagick($_SERVER['DOCUMENT_ROOT']."/ohrm/symfony/web/uploads".$rand.'.pdf');

//set new format
//$img->setImageFormat('jpg');

//save image file
//$img->writeimage($_SERVER['DOCUMENT_ROOT'].'/ohrm/symfony/web/uploads/file.jpg');
//                // create new PDF document
    //                $page_format = array(
    //    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' =>71, 'ury' =>50),
    //    //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    //    //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
    //    //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
    //    //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
    //    'Dur' => 1,
    //    'trans' => array(
    //        'D' =>1,
    //        'S' => 'Split',
    //        'Dm' => 'V',
    //        'M' => 'O'
    //    ),
    //    'Rotate' => 0,
    //    'PZ' => 1,
    //); 
    ////$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,$page_format, true, 'UTF-8', false);// PDF_PAGE_FORMAT
    //$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //
    //// set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Employee Card');
    //$pdf->SetTitle('Employee Card');
    //$pdf->SetSubject('Employee Card');
    //$pdf->SetKeywords('TCPDF, PDF, report, test, guide');
    //$pdf->setPrintHeader(FALSE);
    //$pdf->setPrintFooter(false);
    //// set default header data
    ////$pdf->SetHeaderData(PDF_HEADER_LOGO,"", PDF_HEADER_TITLE.': REPORT #'.$rand, "");
    //
    //// set header and footer fonts
    //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    //$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    //
    //// set default monospaced font
    //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    //
    //// set margins
    ////$pdf->SetMargins(1,"", 1);
    ////$pdf->SetHeaderMargin(3);
    //$pdf->SetFooterMargin(0);
    //
    //// set auto page breaks
    //$pdf->SetAutoPageBreak(TRUE,0);
    //
    //        
    //// set image scale factor
    //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    //
    //// set some language-dependent strings (optional)
    //if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    //	require_once(dirname(__FILE__).'/lang/eng.php');
    //	$pdf->setLanguageArray($l);
    //}
    //
    //    $pdf->AddPage("L");
    //$pdf->SetFont('helvetica', '',24);
    //$html='<tr><td style="text-align:center">'
    //        . '<b>FEDERAL REPUBLIC <br> OF SOMALIA</b><br><br>Ministry Of Commerce'
    //        . '</td><td><img src="'.$_SERVER['DOCUMENT_ROOT'].'/cdlhr/symfony/web/coat.png" height="200" width="300"></td><td style="text-align:center">'
    //        . '<b>SAMPLE CARD<br><br>Serial No:</b> <span style="color:red">'.$rand.'</span></td></tr>';
//     $image = imagecreatefromstring($employeedetails->photo);
//    $image = imagescale($image, 400, 250);
//    
//    ob_start();
//    imagejpeg($image);
//    $contentss = ob_get_contents();
//    ob_end_clean();
    //
    //
    //
    //
    //$html.='<tr><td colspan="3"><br></td></tr><tr><td colspan="3"><br></td></tr><tr><td colspan="3"><table border="1">'
    //        . '<tr><td rowspan="5" style="padding-left:2px;padding-top:10px"><br><img src="data:image/jpeg;base64,'.base64_encode($contentss).'" /></td><td colspan="2">&nbsp;<b>Name:</b>&nbsp;'.$employeedetails->getEmpFirstname().' '.$employeedetails->getEmpMiddleName().' '.$employeedetails->getEmpLastname().'</td></tr>'
    //        . '<tr><td colspan="2">&nbsp;<b>Position: </b>IT Resource</td></tr>'
    //        . '<tr><td colspan="2">&nbsp;<b>Department:</b>IT Department</td></tr>'
    //        . '<tr><td colspan="2">&nbsp;<b>Ministry: </b>Commerce</td></tr>'
    //        . '<tr><td colspan="2">&nbsp;<b>Staff No:</b>GVL-0076</td></tr>'
    //        . '</table></td></tr>';
    //imagedestroy($image);
    //
    //$tbl = <<<EOD
    //        <br><br>
    //<table width="100%" cellspacing="0" cellpadding="2" style="white-space: nowrap !important;" id="pdftable">$html</table>
    //        
    //EOD;
    //
    //
    //$pdf->Image($backgroundimage,1,0, 0,0, '', '', '',true, 300, '', false, false, 0);
    ////$pdf->Cell(80,150, 'Bottom-Bottom', 0, $ln=0, 'C', 0, '', 0, false, 'B', 'B');
    ////$pdf->writeHTML($tbl, true, false, false, false, '');
    ////$pdf->SetFontSize(20);
    ////$pdf->writeHTMLCell(70,10,7,75,'<b>Magaca/Name</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(100,10,7,87,$employeedetails->getEmpFirstname().' '.$employeedetails->getEmpMiddleName().' '.$employeedetails->getEmpLastname(), $border, $ln, $fill);
    ////$pdf->writeHTMLCell(100,10,7,98,'<b>Xilka/Title</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(150,10,7,110,$prevtitle->jobTitleName, $border, $ln, $fill);
    ////$pdf->SetAlpha(0.5);
    ////$pdf->writeHTMLCell(150,10,110,87,'<img height="130" width="130" src="data:image/jpeg;base64,'.base64_encode($contentss).'" />', $border, $ln, $fill);
    ////$pdf->SetAlpha(1);
    ////
    ////$pdf->writeHTMLCell(150,10,7,126,'<b>Taxane Aqoonsi/ID No.</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(150,10,9,136,$employeedetails->getEmployeeId(), $border, $ln, $fill);
    ////
    ////$pdf->writeHTMLCell(150,10,150,126,'<b>Darajo/Grade</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(150,10,170,136,$prevgrade->name, $border, $ln, $fill);
    ////$pdf->writeHTMLCell(100,70,211,78,'<img height="240" width="240" src="data:image/jpeg;base64,'.base64_encode($contentss).'" />', $border, $ln, $fill);
    ////
    ////
    ////$pdf->writeHTMLCell(130,10,7,150,'<b>Tr.la daabacay/Issue Date.</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(130,10,7,160,date('d/m/Y'), $border, $ln, $fill);
    ////$newEndingDate = date("d/m/Y", strtotime(date('Y-m-d H:i:s') . " + 365 day"));
    ////$pdf->writeHTMLCell(130,10,157,150,'<b>Tr.uu dhacayo/Expiry Date.</b>', $border, $ln, $fill);
    ////$pdf->writeHTMLCell(130,10,187,160,$newEndingDate, $border, $ln, $fill);
    ////
    //////gender
    ////if($employeedetails->emp_gender==2){$gender="Female";}else{$gender="Male";}
    ////$pdf->writeHTMLCell(130,10,100,180,'<b>Jinsi/Gender:'.$gender.'</b>', $border, $ln, $fill);
    //
    //// -----------------------------------------------------------------------------
    //
    ////Close and output PDF document or email
    //
    //      
    //     $file=$pdf->Output($rand.'.pdf','I');
       
    $this->backgroundimage=$configuration->system_url."/symfony/web/uploads/card/".$color.".jpg";;
    $this->backgroundimageback=$configuration->system_url."/symfony/web/uploads/card/".$color."back.jpg";
    $this->names=$employeedetails->getEmpFirstname().' '.$employeedetails->getEmpMiddleName().' '.$employeedetails->getEmpLastname();        
    $this->title=$prevtitle->jobTitleName;  
    $this->englishtitle=$prevtitle->note;
    $this->empphoto=$employeedetails->photo;
    $this->employeeid=$employeedetails->getEmployeeId();
    $this->empNumber=$employeedetails->getEmpNumber();
    $this->grade=$prevgrade->name;
    $this->issuedate=date('d/m/Y',strtotime($issuedate));
     
       $datetime = new DateTime();
$dt = $datetime->createFromFormat('d/m/Y',$this->issuedate);
    $dt->modify('+ '.$expiry.' year');
    $end=$dt->format("d/m/Y");
    $this->expirydate=$end;//date("d/m/Y",strtotime($this->issuedate. " + ".$expiry." year"));
    if($employeedetails->emp_gender==2){$gender="Dhedig/Female";}else{$gender="Lab/Male";}
$this->gender=$gender;
$this->location=$location;

                }
                    else{
                     $this->getUser()->setFlash('personaldetails.error', __(TopLevelMessages::SAVE_FAILURE)." ".$returned);
                     $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
                    }

                    $this->weburl=$configuration->system_url;
                    $this->printmode=$printmode;
    } 


    private function getUserService() {

        if(is_null($this->userService)) {
            $this->userService = new SystemUserService();
        }

        return $this->userService;
    }

    protected function _checkWhetherEmployeeIdExists($employeeId) {

        if (!empty($employeeId)) {

            $employee = $this->getEmployeeService()->getEmployeeByEmployeeId($employeeId);

            if ($employee instanceof Employee) {
                $this->getUser()->setFlash('warning', __('Failed To Save: Employee Id Exists'));
                $this->redirect('pim/addEmployee');
            }

        }

    }
    
     protected  function handleFile($target_file){
    //die(print_r($_FILES["printapprove"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
//die(print_r($target_file));
//if (file_exists($target_file)) {
//    return "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES["printapprove"]['size'] > 5000000) {
    return "Sorry,file larger than 5MB";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx"
&& $imageFileType != "gif" ) {
    return "Sorry, file type not allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    return "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["printapprove"]['tmp_name'], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    }

}

