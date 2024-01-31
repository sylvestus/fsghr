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
class terminateEmployementAction extends basePimAction {

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        
        $empNumber = $request->getParameter('empNumber');
        $terminatedId = $request->getParameter('terminatedId');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
     
        $allowedActions = $this->getContext()->getUserRoleManager()->getAllowedActions(WorkflowStateMachine::FLOW_EMPLOYEE, $employee->getState());
        
        $this->allowActivate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_REACTIVE]);
        $this->allowTerminate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_TERMINATE]);

        $paramForTerminationForm = array('empNumber' => $empNumber, 
                                                                 'employee' => $employee, 
                                                                 'allowTerminate' => $this->allowTerminate,
                                                                 'allowActivate' => $this->allowActivate);
        

        $this->form = new EmployeeTerminateForm(array(), $paramForTerminationForm, true);

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        
        if (!$this->isAllowedAdminOnlyActions($loggedInEmpNum, $empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        if ($this->getRequest()->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()),$request->getFiles($this->form->getName()));
            if ($this->form->isValid()) {
                
                
                $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
                      
$target_file = $target_dir.basename($_FILES['terminate']['name']["fileApprove"]);
//die(print_r($this->getUser()));
$returned=$this->handleFile($target_file);
                if($returned=="success"){
                $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="termination";
                $trail->file1=$_FILES['terminate']['name']["fileApprove"];
                $trail->approval_levels=1;
                $trail->previous_value="active";
                $trail->updated_value="terminated";
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                $terminationrecord=$this->form->terminateEmployement($empNumber, $terminatedId);
                 //$this->generateTerminationReport($terminationrecord);
                $this->getUser()->setFlash('jobdetails.success', __(TopLevelMessages::UPDATE_SUCCESS));
                }
                 else{
                     $this->getUser()->setFlash('jobdetails.error', __(TopLevelMessages::SAVE_FAILURE)." ".$returned);   
                    }
               
            }
            else{
                $errormesage='';
                   foreach ($this->form as $key => $field) {
  $message = $field->renderError();
  if ($message) $errormesage.='Error with field '.$key.':'.$message;
}
              $this->getUser()->setFlash('jobdetails.error', __($errormesage));   
            }
        

          
            $this->redirect('pim/viewJobDetails?empNumber=' .$empNumber);
        }
    }

   protected  function handleFile($target_file){
    
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if file already exists
//die(print_r($target_file));
//if (file_exists($target_file)) {
//    return "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES['terminate']['size']["fileApprove"] > 5000000) {
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
    if (move_uploaded_file($_FILES['terminate']['tmp_name']["fileApprove"], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    } 
  
    
    
}

