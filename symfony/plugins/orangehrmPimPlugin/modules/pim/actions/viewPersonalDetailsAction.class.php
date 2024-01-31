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
 * personalDetailsAction
 *
 */
class viewPersonalDetailsAction extends basePimAction {

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
        //$this->isLeavePeriodDefined();

        $personal = $request->getParameter('personal');
        $empNumber = (isset($personal['txtEmpID']))?$personal['txtEmpID']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        // TODO: Improve            
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        $this->personalInformationPermission = $this->getDataGroupPermissions('personal_information', $empNumber);
        $this->canEditSensitiveInformation = ($empNumber != $loggedInEmpNum) || $adminMode;

$newemployeestatus=ApprovalsDao::getApprovalStatus("addemployee","create", $empNumber);
            $this->employeestatus=$newemployeestatus->status;
        $param = array('empNumber' => $empNumber, 
            'personalInformationPermission' => $this->personalInformationPermission,
            'canEditSensitiveInformation' => $this->canEditSensitiveInformation);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $this->showDeprecatedFields = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_DEPRECATED);
        $this->showSSN = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_SSN);
        $this->showSIN = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_SIN);

        $this->setForm(new EmployeePersonalDetailsForm(array(), $param, true));

        if ($this->personalInformationPermission->canUpdate()){
            if ($request->isMethod('post')) {
           
                $this->form->bind($request->getParameter($this->form->getName()),$request->getFiles($this->form->getName()));
            
                if ($this->form->isValid()) {
                    
                     $postArray = $request->getPostParameters();
                   
                 // die(print_r($postArray));
                         //log in audit trail
                         $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
                       
$target_file = $target_dir.basename($_FILES['personal']['name']["fileApprove"]);
//die(print_r($this->getUser()));
$returned=$this->handleFile($target_file);
                if($returned=="success"){
                $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="personaldetails";
                $trail->file1=$_FILES['personal']['name']["fileApprove"];
                $trail->approval_levels=1;
                $trail->previous_value=$postArray["personal"]["txtEmpFirstName"];
                $trail->updated_value=$postArray["personal"]["txtEmpFirstName"];
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                $this->_checkWhetherEmployeeIdExists($this->form->getValue('txtEmployeeId'), $empNumber);

                    $employee = $this->form->getEmployee();
                    $this->getEmployeeService()->saveEmployee($employee);
                    $this->getUser()->setFlash('personaldetails.success', __(TopLevelMessages::SAVE_SUCCESS));
                }
                    else{
                     $this->getUser()->setFlash('personaldetails.error', __(TopLevelMessages::SAVE_FAILURE)." ".$returned);   
                    }
                   

                } else{
                    $error="";
                    foreach ($this->form as $key => $field) {
  $message = $field->renderError();
  if ($message) {
                            $error.= 'Error with field ' . $key;
                        }// ':'. htmlspecialchars($message);
}
           $this->getUser()->setFlash('personaldetails.error', __(TopLevelMessages::SAVE_FAILURE)." ".  $error);             
                    
                }
                  $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
            }
           
        }
        
       // $this->employees=EmployeeDao::getEmployeesMinInfo();
    }

//    private function isLeavePeriodDefined() {
//
//        $leavePeriodService = new LeavePeriodService();
//        $leavePeriodService->setLeavePeriodDao(new LeavePeriodDao());
//        $leavePeriod = $leavePeriodService->getCurrentLeavePeriodByDate(date("Y-m-d"));
//        $flag = 0;
//        
//        if(!empty($leavePeriod)) {
//            $flag = 1;
//        }
//
//        $_SESSION['leavePeriodDefined'] = $flag;
//    }

    protected function _checkWhetherEmployeeIdExists($employeeId, $empNumber) {

        if (!empty($employeeId)) {

            $employee = $this->getEmployeeService()->getEmployeeByEmployeeId($employeeId);

            if (($employee instanceof Employee) && trim($employee->getEmpNumber()) != trim($empNumber)) {
                $this->getUser()->setFlash('templateMessage', array('warning', __('Employee Id Exists')));
                $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
            }

        }

    }

    
    protected  function handleFile($target_file){
    
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES['personal']['tmp_name']["fileApprove"]);
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
if ($_FILES['personal']['size']["fileApprove"] > 5000000) {
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
    if (move_uploaded_file($_FILES['personal']['tmp_name']["fileApprove"], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    }
}
