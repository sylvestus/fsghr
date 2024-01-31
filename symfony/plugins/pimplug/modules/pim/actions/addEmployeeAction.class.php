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
class addEmployeeAction extends basePimAction {

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
//        $allowedToAddEmployee = $this->getContext()->getUserRoleManager()->isActionAllowed(PluginWorkflowStateMachine::FLOW_EMPLOYEE, 
//                Employee::STATE_NOT_EXIST, PluginWorkflowStateMachine::EMPLOYEE_ACTION_ADD);
        
        $this->openIdEnabled = $this->getConfigService()->getOpenIdProviderAdded();
        
       // if ($allowedToAddEmployee) {

            $this->showBackButton = true;
            $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

            //this is to preserve post value if any error occurs
            $postArray = array();
            $this->createUserAccount = 0;

            if($request->isMethod('post')) {
                $postArray = $request->getPostParameters();
                unset($postArray['_csrf_token']);
                $_SESSION['addEmployeePost'] = $postArray;
            }

            if(isset ($_SESSION['addEmployeePost'])) {
                $postArray = $_SESSION['addEmployeePost'];

                if(isset($postArray['chkLogin'])) {
                    $this->createUserAccount = 1;
                }
            }

            $optionsForForm = array('openIdEnabled' => $this->openIdEnabled);
            $this->setForm(new AddEmployeeForm(array(), $optionsForForm, true));

            if ($this->getUser()->hasFlash('templateMessage')) {
                unset($_SESSION['addEmployeePost']);
                list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
            }

            if ($request->isMethod('post')) {

                $this->form->bind($request->getPostParameters(), $request->getFiles());
                $posts = $this->form->getValues();
                $photoFile = $request->getFiles();

                 $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
                
$target_file = $target_dir.basename($_FILES['fileApprove']['name']);
//die(print_r($target_file));
$returned=$this->handleFile($target_file);
    if($returned=="success"){
                $trail=new AuditTrail();
                $trail->transaction_type="create";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="addemployee";
                $trail->file1=$_FILES['fileApprove']['name'];
                $trail->approval_levels=1;
                $trail->previous_value="";
                $trail->updated_value=$posts["firstName"]." ".$posts["middleName"]." ".$posts["lastName"];
                $trail->status="pending";
                $trail->save();
                
                }
                    else{
                         $this->getUser()->setFlash('warning', __(TopLevelMessages::FILE_TYPE_SAVE_FAILURE)." ".$returned);
                            $this->redirect('pim/addEmployee');
                   
                    }
                //in case if file size exceeds 10MB
                if($photoFile['photofile']['name'] != "" && ($photoFile['photofile']['size'] == 0 || 
                        $photoFile['photofile']['size'] > 10000000)) {
                    $this->getUser()->setFlash('warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
                    $this->redirect('pim/addEmployee');
                }

                //in case a user already exists with same user name

                if ($this->createUserAccount) {

                    $userService = $this->getUserService();
                    $user = $userService->isExistingSystemUser($posts['user_name'],null);

                    if($user instanceof SystemUser) {

                        $this->getUser()->setFlash('warning', __('Failed To Save: User Name Exists'));
                        $this->redirect('pim/addEmployee');
                    }
                }

                //if everything seems ok save employee and create a user account
                if ($this->form->isValid()) {

                    $this->_checkWhetherEmployeeIdExists($this->form->getValue('employeeId'));

                    try {

                        $fileType = $photoFile['photofile']['type'];

                        $allowedImageTypes[] = "image/gif";
                        $allowedImageTypes[] = "image/jpeg";
                        $allowedImageTypes[] = "image/jpg";
                        $allowedImageTypes[] = "image/pjpeg";
                        $allowedImageTypes[] = "image/png";
                        $allowedImageTypes[] = "image/x-png";

                        if(!empty($fileType) && !in_array($fileType, $allowedImageTypes)) {
                            $this->getUser()->setFlash('warning', __(TopLevelMessages::FILE_TYPE_SAVE_FAILURE));
                            $this->redirect('pim/addEmployee');

                        } else {
                            unset($_SESSION['addEmployeePost']);
                            $this->form->createUserAccount = $this->createUserAccount;
                            $empNumber = $this->form->save();
                            
                            $this->dispatcher->notify(new sfEvent($this, EmployeeEvents::EMPLOYEE_ADDED,
                                    
                                array('employee' => $this->form->getEmployee(), 'emp_number'=> $empNumber)));
                            $trail=new AuditTrail();
                $trail->transaction_type="create";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="addemployee";
                $trail->file1=$target_file;
                $trail->approval_levels=1;
                $trail->previous_value="";
                $trail->updated_value=$posts["firstName"].$posts["middleName"].$posts["lastName"];
                $trail->status="pending";
                $trail->affected_user=$empNumber;
                $trail->save();

                            $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
                        }

                    } catch(Exception $e) {
                        print($e->getMessage());
                    }
                }
            }
      //  } 
//        else {
//            $this->credentialMessage = 'Credential Required';
//        }
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
    
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES['fileApprove']['tmp_name']);
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
if ($_FILES['fileApprove']['size'] > 5000000) {
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
    if (move_uploaded_file($_FILES['fileApprove']['tmp_name'], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    }

}

