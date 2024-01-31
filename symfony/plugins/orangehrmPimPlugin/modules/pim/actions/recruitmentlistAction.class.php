<?php

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
 * Actions class for PIM module dependents
 */
class recruitmentlistAction extends basePimAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $this->showBackButton = true;

        $dependentParams = $request->getParameter('dependent');
        $empNumber = (isset($dependentParams['empNumber'])) ? $dependentParams['empNumber'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        $this->dependentPermissions = $this->getDataGroupPermissions('dependents', $empNumber);

        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        //hiding the back button if its self ESS view
        if ($loggedInEmpNum == $empNumber) {
            $this->showBackButton = false;
        }

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
           $limit=$request->getParameter('limit');
            $page=$request->getParameter('page');
        $dates="ALL DATES";
    if ($this->getRequest()->isMethod('get')) {
    $offset=$request->getParameter('start');
         
            if(!$page){$page=1;} if(!$limit){$limit=500;} if(!$offset){$offset=0;}
          if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate')){
              
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("addEmployee",$request->getParameter('location'),$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
         $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
             }
			  else if($request->getParameter('location')&&!$request->getParameter('fromdate')&&!$request->getParameter('todate')){
             // die("dsdsd");
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("addEmployee",$request->getParameter('location'),"2016-01-01",date("Y-m-d"),$offset, $limit);
         $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $dates="ALL DATES";
             }
             else if(!$request->getParameter('location')&&$request->getParameter('fromdate')){
                 $location="All Locations";
           $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("addEmployee",NULL,$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
       
         $dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
                   
             }
          else{
              $location="All Locations";
             $this->employees =  AuditTrailTable::getTrailByModule("addEmployee",$offset, $limit);
          }
             $this->page=$page;
    }
    else{
        $offset=0;$limit=500;
        if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate')){
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("addEmployee",$request->getParameter('location'),$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
            $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $this->dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
             } else{
         $this->employees =  AuditTrailTable::getTrailByModule("addEmployee",$offset, $limit);
        $location="All Locations";
        
          }
         $this->page="Page 1";
    }
    $employees = $this->employees;
	if($request->getParameter("xls") || $request->getParameter("pdf") ){
             $grades= new PayGradeDao();
         $gradeslist=$grades->getPayGradeList();
        
            date_default_timezone_set('Africa/Nairobi');
             $offset=$request->getParameter('start');
            $limit=$request->getParameter('limit');
            $page=$request->getParameter('page');
			 //print_r($page);
 //die();
 

 $count=1;
 $tables = '<table border="1"><tbody><tr><td colspan="12" style="text-align:center"><img src="../web/uploads/letterhead.png" alt="mda" width="760" height="116"></td></tr>
			<tr><td colspan="12" style="text-align:center"></td></tr>
<tr><td>Serial No</td><td>MDA</td><td>ID/Payroll No</td><td>Magaca/Name</td><td>Job Title</td><td>Gender</td><td>T.La Qoray/Rec Date</td><td>T. Dalacay/pro Date</td><td>Ref/Reference</td></tr>';

	
  foreach ($trails as $record){ 
                     
                   
                   $table.='<tr>
                        <td class="tdName tdValue">'.$count;
                      $employeedetail=  EmployeeDao::getEmployeeByNumber($record["affected_user"]);
                           if(!$record["affected_user"]){  $employeedetail=EmployeeDao::getEmployeeByNumber(130);}
               $location = HsHrEmpLocationsTable::findEmployeeLocation($record["affected_user"]);
               $locationid=HsHrEmpLocationsTable::findEmployeeLocationId($record["affected_user"]);
                        if(empty($location)){
                            $location="N/A";
                        }
                        if($employeedetail->termination_id){$status="Terminated";}else { $status="Active";}
                                 $table.='</td>
                         <td class="tdName tdValue">
                        '.$locationid.'
                        </td>
                        <td class="tdName tdValue">'.$location.'</td>
                        <td class="tdName tdValue">'.$employeedetail->getEmployeeId().'</td>
						<td class="tdName tdValue">
                       '.ucwords($record['updated_value']).'    
                        </td>';
                         
                         $table.='<td class="tdName tdValue">';
                          
                        $jb=new JobTitleDao();
                        $title=$jb->getJobTitleOnly($employee->job_title_code);
                         if($title){echo $title;} else{echo "N/A";}
                           
                        $table.='</td><td class="tdName tdValue">';
                       if($employeedetail->emp_gender==2){$table.= "Female";}else{$table.="Male";}
                        $table.='</td>';
                      
                    
                    
                       $table.='
                        
                       <td class="tdValue" style="text-align:right">'.date("d/m/Y",strtotime($record['datecreated'])).'</td>
                       <td class="tdValue" style="text-align:right">'.date("d/m/Y",strtotime($record['dateupdated'])).'</td>
                       <td class="tdValue" style="text-align:right"></td>
                    </tr>';
                    
                    
                    
                    $count++;
                    $row++;
  } 
   
          
                $table.='<tr><td class="boldText borderBottom" style="font-weight:bold">No of Records </td>
                       <td class="boldText borderBottom" style="font-weight:bold">'.count($employees).'</td>
       
                    </tr> 
                      <tr><td colspan="13" style="text-align:left">
                                Certified Correct by Organisations Authorised Officer.<br><br>
                                    
                                Name:.................................. &nbsp;&nbsp; &nbsp;  Signature ........................... &nbsp;&nbsp; &nbsp; Designation.....................&nbsp;&nbsp; &nbsp; Date: /'.$month.'   <br>
                                <br>
                                <span style="font-weight:bold">NB:THIS FORM IS INVALID WITHOUT THE OFFICIAL STAMP/SEAL OF THE EMPLOYER </span>
                                <br>
                              
                                
              
                                
                    </td></tr>
                      
                    
                 $path= "https://'.$_SERVER["HTTP_HOST"].'/fgshr/symfony/web/uploads/letterhead.png';
			//$path= "letterhead.png";

		
					
		

$tables.=$table;
$tables.= '</tbody></table>';
if($request->getParameter("xls")){
header('Content-Encoding: UTF-8');
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel;charset=UTF-8");
header ("Content-Disposition: attachment; filename=Mdalist.xls" );

echo $tables;
//exit();
} else{
	
	//pdf
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Savanna HRM');
$pdf->SetTitle('Mda Report');
$pdf->SetSubject('Mda Report');
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
try{
$pdf->AddPage("P");
$pdf->SetFont('helvetica', '',10); 	
	$pdf->writeHTML($tables, true, false, false, false, '');
	$rand="Mdareport".rand(2000,100000);
	 //$filee=$pdf->Output($_SERVER['DOCUMENT_ROOT']."/fgshr/symfony/pdfs/".$rand.'.pdf','D');
	 $filee=$pdf->Output($rand.'.pdf','D');
	
}
catch (Exception $err)
{
    $custom = array('result'=> "Error: ".$err->getMessage().", Line No:".$err->getLine(),'s'=>'error');
    $response_array[] = $custom;
    echo '{"error":'.json_encode($response_array).'}';
    exit;
}
} //end pdf

        }
	
    $this->locationd=$location;
        $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->dates=$dates;
      // die(print_r($this->employees));
    }

}
