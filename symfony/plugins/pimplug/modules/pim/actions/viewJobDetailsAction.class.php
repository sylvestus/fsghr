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
 * ViewJobDetailsAction
 */
class viewJobDetailsAction extends basePimAction {

    public function execute($request) {
        
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $job = $request->getParameter('job');
        $empNumber = (isset($job['emp_number'])) ? $job['emp_number'] : $request->getParameter('empNumber');
        
        $this->activeEmploymentForm = new ActiveEmploymentForm( array(),array(),true);
        /*
         * TODO: $empNumber gets empty when uploaded file size exceeds PHP max upload size.
         * Check for a better solution.
         */
        if (empty($empNumber)) {
            $this->getUser()->setFlash('jobdetails.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            $this->redirect($request->getReferer());
        }
        
        $this->empNumber = $empNumber;
        
        $this->jobInformationPermission = $this->getDataGroupPermissions('job_details', $empNumber);
        $this->ownRecords = ($loggedInEmpNum == $empNumber) ? true : false;

        //termination approval;
        $termination=ApprovalsDao::getApprovalStatus("termination","update", $empNumber);
        $this->terminationstatus=$termination->status;
        //leave
        
        $enttitlments= OhrmLeaveEntitlementTable::getEmployeeLeave($empNumber,date("Y"));
        $leaveentitlement=0;
                         $leavetaken=0;
                         foreach ($enttitlments as $value) {
                                 $leaveentitlement+=$value["no_of_days"];
                                 $leavetaken+=$value["days_used"];
                                
                             }
                              $leaveencashed=  EncashLeaveTable::getEncashedLeaveForYear($empNumber,date("Y"));
                              $this->leavebalance= $leaveentitlement-$leavetaken-$leaveencashed;  
                              $this->dailyrate= PayrollMonthTable::getDailyEmployeeRate($empNumber);
//end leave
        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $param = array('empNumber' => $empNumber, 'ESS' => $this->essMode,
            'employee' => $employee,
            'loggedInUser' => $loggedInEmpNum,
            'loggedInUserName' => $loggedInUserName);
        
        $joinedDate = $employee->getJoinedDate();

        $this->form = new EmployeeJobDetailsForm(array(), $param, true);
        $this->employeeState = $employee->getState();
        
        if ($loggedInEmpNum == $empNumber) {
            $this->allowActivate = FALSE;
            $this->allowTerminate = FALSE;
        } else {
            $allowedActions = $this->getContext()->getUserRoleManager()->getAllowedActions(WorkflowStateMachine::FLOW_EMPLOYEE, $this->employeeState);
            $this->allowActivate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_REACTIVE]);
            $this->allowTerminate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_TERMINATE]);            
        }
        
        $paramForTerminationForm = array('empNumber' => $empNumber,
            'employee' => $employee,
            'allowTerminate' => $this->allowTerminate,
            'allowActivate' => $this->allowActivate);

        $this->employeeTerminateForm = new EmployeeTerminateForm(array(), $paramForTerminationForm, true);

        if ($this->getRequest()->isMethod('post')) {


            // Handle the form submission           
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

            if ($this->form->isValid()) {
              $empdetails=  EmployeeDao::getEmployeeByNumber($empNumber);
              $postArray = $request->getPostParameters();
             $titledao=  new JobTitleDao(); 
                         $prevtitle=$titledao->getJobTitleById($empdetails->job_title_code);
              $currenttitle=$titledao->getJobTitleById($postArray['job']['job_title']);
             //location
             $loc= new LocationDao();
             $updatedlocation=$loc->getLocationById($postArray['job']['location']);    
             $lastlocationid=HsHrEmpLocationsTable::findEmployeeLocationId($empNumber);
             if(is_numeric($lastlocationid)){
                 $lastlocation=$loc->getLocationById($lastlocationid);
                 $lastlocationname=$lastlocation->name;
             } else{$lastlocationname='N/A';$lastlocation=null;}
             
                $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
 $target_file = $target_dir.basename($_FILES["job"]['name']['fileApprove']);

$returned=$this->handleFile($target_file);
                if($returned=="success"){
                    //log jobdetails change
                 //   die(print_r($prevtitle));
                    if($prevtitle->jobTitleName!=$currenttitle->jobTitleName){
                $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="jobtitle";
                $trail->file1=$_FILES["job"]['name']['fileApprove'];
                $trail->approval_levels=1;
                $trail->previous_value=$prevtitle->id."#".$prevtitle->jobTitleName;
                $trail->updated_value=$currenttitle->id."#".$currenttitle->jobTitleName;
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                    }
                    //location
                    if($prevlocation!=$postArray['job']['location']){
                     $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="joblocation";
                $trail->file1=$target_file;
                $trail->approval_levels=1;
               
                $trail->previous_value= $lastlocationid."#".$lastlocationname;
                $trail->updated_value=$postArray['job']['location']."#".$updatedlocation->name;
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                    }
                    $previousdept=OhrmSubunitTable::getDepartment($empdetails->work_station);
                    $updateddept=OhrmSubunitTable::getDepartment($postArray['job']['sub_unit']);
                    //department/subunit change
                    if($previousdept->id!=$updateddept->id){
                     $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="jobdepartment";
                $trail->file1=$target_file;
                $trail->approval_levels=1;
               
                $trail->previous_value= $previousdept->id."#".$previousdept->name;
                $trail->updated_value=$updateddept->id."#".$updateddept->name;
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                    }
                    
                }
                else{ $this->getUser()->setFlash('jobdetails.error', __(TopLevelMessages::SAVE_FAILURE)." ".$returned); 
                   
                  $this->redirect('pim/viewJobDetails?empNumber=' . $empNumber);  
                }
                // save data
                if ($this->jobInformationPermission->canUpdate()) {
                    $service = new EmployeeService();
                   // die(print_r($this->form->getEmployee()));
                    $service->saveEmployee($this->form->getEmployee(), false);
                   
                    if( $this->form->getIsJoinDateChanged()){
                      
                        $this->dispatcher->notify(new sfEvent($this, EmployeeEvents::JOINED_DATE_CHANGED,
                                array('employee' => $this->form->getEmployee(),'previous_joined_date'=> $joinedDate)));

                    }
                }

                $this->form->updateAttachment();


                $this->getUser()->setFlash('jobdetails.success', __(TopLevelMessages::UPDATE_SUCCESS));
            } else {
                $validationMsg = '';
                foreach ($this->form->getWidgetSchema()->getPositions() as $widgetName) {
                    if ($this->form[$widgetName]->hasError()) {
                        $validationMsg .= $this->form[$widgetName]->getError()->getMessageFormat();
                    }
                }

                $this->getUser()->setFlash('jobdetails.warning', $validationMsg);
            }

            $this->redirect('pim/viewJobDetails?empNumber=' . $empNumber);
        }
    }

    
        protected  function handleFile($target_file){
    
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES['job']['tmp_name']['fileApprove']);
    if($check !== false) {
        return "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        return "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
//die(print_r($target_file));
//if (file_exists($target_file)) {
//    return "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES['job']['size']['fileApprove'] > 5000000) {
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
    if (move_uploaded_file($_FILES['job']['tmp_name']['fileApprove'], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    }

}
