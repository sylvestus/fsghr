<?php
require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
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
class promotionlistAction extends basePimAction {

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
		        
      
    if ($this->getRequest()->isMethod('get')&& $request->getParameter('start')) {
    $offset=$request->getParameter('start');
            $limit=$request->getParameter('limit');
            $page=$request->getParameter('page');
          
             $this->employees =  EmployeeDao::getAllEmployees($limit,$offset);
             if($request->getParameter('fromdate')&&$request->getParameter('todate') && !$request->getParameter('location') ){
             $trails= AuditTrailTable::getApprovedTrailByModuleTime("jobtitle",$request->getParameter('fromdate'), $request->getParameter('todate'),$offset,$limit);
             }
             if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate') ){
             $trails= AuditTrailTable::getTrailByModuleLocationTime("jobtitle",$request->getParameter('location'),$request->getParameter('fromdate'), $request->getParameter('todate'),$offset,$limit);
             }
             
             $this->page=$page;
    }
    else{
        $offset=0;$limit=500;
         $this->employees =  EmployeeDao::getAllEmployees($limit,$offset);
         if($request->getParameter('fromdate')&&$request->getParameter('todate') && !$request->getParameter('location') ){
             $trails= AuditTrailTable::getApprovedTrailByModuleTime("jobtitle",$request->getParameter('fromdate'), $request->getParameter('todate'),$offset,$limit);
             }
             if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate') ){
             $trails= AuditTrailTable::getTrailByModuleLocationTime("jobtitle",$request->getParameter('location'),$request->getParameter('fromdate'), $request->getParameter('todate'),$offset,$limit);
             }
             
              if($request->getParameter('location')&& !$request->getParameter('fromdate')&&!$request->getParameter('todate') ){
               
             $trails= AuditTrailTable::getTrailByModuleLocation("jobtitle",$request->getParameter('location'),$offset,$limit);
            
             }
         $this->page="Page 1";
    }
	
	 if($request->getParameter("xls") || $request->getParameter("pdf") ){
             $grades= new PayGradeDao();
         $gradeslist=$grades->getPayGradeList();
        
            date_default_timezone_set('Africa/Nairobi');
             $offset=$request->getParameter('start');
            $limit=$request->getParameter('limit');
            $page=$request->getParameter('page');
			 //print_r($page);
 //die();
 $employees = $trails;

 $count=1;
 $tables = '<table border="1"><tbody><tr><td colspan="12" style="text-align:center"><img src="../web/uploads/letterhead.png" alt="mda" width="760" height="116"></td></tr>
			<tr><td colspan="12" style="text-align:center"></td></tr>
<tr><td>Serial No</td><td>MDA</td><td>ID/Payroll No</td><td>Magaca/Name</td><td>Job Title</td><td>Jinsi/Gender</td><td>Darajo/Grade</td><td>Department</td><td>TR.Dhalasho/Date Of Birth</td><td>Maalinta/Day</td><td>Bisha/Month</td><td>Sanadaha/Year</td></tr>';

	
  foreach ($trails as $record){ 
                     
                   
                   $table.='<tr>
                        <td class="tdName tdValue">'.$count;
                       $employeedetail=  EmployeeDao::getEmployeeByNumber($record["affected_user"]);
               $location = HsHrEmpLocationsTable::findEmployeeLocation($record["affected_user"]);
                        if(empty($location)){
                            $location="N/A";
                        }
                         $locationid=HsHrEmpLocationsTable::findEmployeeLocationId($record["affected_user"]);
                        if($employeedetail->termination_id){$status="Terminated";}else { $status="Active";}
                        $code=HsHrEmpBasicsalaryTable::getSalaryCode($record["affected_user"]);
                         $dao=new PayGradeDao();
                $prevgrade=$dao->getPayGradeById($code);
                        $employee=EmployeeDao::getEmployeeByNumber($record["affected_user"]);
                                 $table.='</td>
                         <td class="tdName tdValue">
                        '.$locationid.'
                        </td>
                        <td class="tdName tdValue">'.$location.'</td>
                        <td class="tdName tdValue">'.$employeedetail->getEmployeeId().'</td>
						<td class="tdName tdValue">
                       '.$employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->emp_lastname.'    
                        </td>';
                         
                         $table.='<td class="tdName tdValue">';
                          
                        $jb=new JobTitleDao();
                        $title=$jb->getJobTitleOnly($employee->job_title_code);
                         if($title){echo $title;} else{echo "N/A";}
                           
                        $table.='</td><td class="tdName tdValue">';
                       if($employeedetail->emp_gender==2){$table.= "Female";}else{$table.="Male";}
                        $table.='</td><td class="tdName tdValue">'.$record['previous_value'].'</td><td class="tdValue" style="text-align:right">';
                        
                    //$dept=OhrmSubunitTable::getDepartment($record["work_station"]);
                    $table.= $record['updated_value'].'</td>';
                      
                    
                    
                       $table.='<td class="tdValue" style="text-align:right">'.$prevgrade.'</td>
                        
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
                     <tr><td colspan="12" style="text-align:center;font-weight:bold">SUMMARY
                
                    </td></tr>    
           
            <tr><td colspan="6" style="text-align:center;font-weight:bold">Grade/Rank</td>
                <td colspan="6" style="text-align:center;font-weight:bold">Number(Count)</td></tr>';
            
            $totalcount=0;
            foreach($gradeslist as $grade) {
           $table.='<tr><td colspan="6" style="text-align:center;font-weight:bold">'.$grade->name.'</td>
                <td colspan="6" style="text-align:center;">';
                    
 $empcount=HsHrEmpBasicsalaryTable::getEmployeeCountyBySalaryCode($grade->id);
 $totalcount+=$empcount;
 $table.= $empcount;
          
                    
          $table.='</td></tr>';
             } 
                $table.='<tr><td colspan="6" style="text-align:center;font-weight:bold">Total</td>
                <td colspan="6" style="text-align:center;">'.$totalcount.'</td></tr>';    
                    
                 $path= 'https://'.$_SERVER["HTTP_HOST"].'/fgshr/symfony/web/uploads/letterhead.png';
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
		
    if($request->getParameter('fromdate')&&$request->getParameter('todate')){
        $this->dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
    } else{
        $this->dates="ALL DATES";
    }
    if($request->getParameter('location')){
        $locationdao=new LocationDao();
    $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
    } else{
        $location="ALL LOCATIONS";
    }
        $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $grades= new PayGradeDao();
         $this->gradeslist=$grades->getPayGradeList();
         //die(print_r($trails));
         $this->employees=$trails;
         $this->locationd=$location;
         
         
         
      // die(print_r($this->employees));
    }

}
