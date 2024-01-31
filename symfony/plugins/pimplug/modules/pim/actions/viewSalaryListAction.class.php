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
 * viewSalaryAction
 */
class viewSalaryListAction extends basePimAction {

    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $salary = $request->getParameter('salary');
        $empNumber = (isset($salary['emp_number'])) ? $salary['emp_number'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        $this->essUserMode = !$this->isAllowedAdminOnlyActions($loggedInEmpNum, $empNumber);

        $this->ownRecords = ($loggedInEmpNum == $empNumber) ? true : false;

        $this->salaryPermissions = $this->getDataGroupPermissions('salary_details', $empNumber);

        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        $this->isSupervisor = $this->isSupervisor($loggedInEmpNum, $empNumber);

        $this->essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $params = array('empNumber' => $empNumber, 'ESS' => $this->essMode,
            'employee' => $employee,
            'loggedInUser' => $loggedInEmpNum,
            'loggedInUserName' => $loggedInUserName,
            'salaryPermissions' => $this->salaryPermissions);

        $this->form = new  EmployeeSalaryForm(array(), $params, true);

        // TODO: Use embedForm or mergeForm?
        $this->directDepositForm = new EmployeeDirectDepositForm(array(), array(), true);

        if ($this->getRequest()->isMethod('post')) {

           
            // Handle the form submission    
            $this->form->bind($request->getParameter($this->form->getName()),$request->getFiles($this->form->getName()));

            if ($this->form->isValid()) {
               

                if ($this->salaryPermissions->canCreate() || $this->salaryPermissions->canUpdate()) {

                    $salary = $this->form->getSalary();
                    $postArray = $request->getPostParameters();
                  // die(print_r($postArray['salary']['basic_salary']));
                //previous salary
                $prevsalary=HsHrEmpBasicsalaryTable::getEmpBasicSalary($empNumber); //this is an amount
                $prevcode=HsHrEmpBasicsalaryTable::getSalaryCode($empNumber);
                
                      $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
                       
$target_file = $target_dir.basename($_FILES["salary"]['name']['fileApprove']);

$returned=$this->handleFile($target_file);
                if($returned=="success"){
                    //log salary change
                    if($prevsalary!=$postArray['salary']['basic_salary']){
                $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="salary";
                $trail->file1=$_FILES["salary"]['name']['fileApprove'];
                $trail->approval_levels=1;
                $trail->previous_value=$prevsalary;
                $trail->updated_value=$postArray['salary']['basic_salary'];
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                    }
                    if($prevcode!=$postArray['salary']['sal_grd_code']){
                     $trail=new AuditTrail();
                $trail->transaction_type="update";
                $trail->datecreated=date("Y-m-d H:i:s");
                $trail->dateupdated=date("Y-m-d H:i:s");
                $trail->created_by= $this->getUser()->getAttribute('user')->getUserId();
                $trail->module="salarygrade";
                $trail->file1=$target_file;
                $trail->approval_levels=1;
                //get paygrade name
                
                $dao=new PayGradeDao();
                $prevgrade=$dao->getPayGradeById($prevcode);
                $currentgrade=$dao->getPayGradeById($postArray['salary']['sal_grd_code']);
                //continue save
                $trail->previous_value=$prevgrade->name;
                $trail->updated_value=$currentgrade->name;
                $trail->affected_user=$empNumber;
                $trail->status="pending";
                $trail->save();
                    }
                    
         
                    $this->getUser()->setFlash('salary.success', __(TopLevelMessages::SAVE_SUCCESS));
                }
                    else{
                     $this->getUser()->setFlash('salary.error', __(TopLevelMessages::SAVE_FAILURE)." ".$returned); 
                     $this->redirect('pim/viewSalaryList?empNumber=' . $empNumber);
                    }

                    $setDirectDebit = $this->form->getValue('set_direct_debit');
                    $directDebitOk = true;

                    if (!empty($setDirectDebit)) {

                        $this->directDepositForm->bind($request->getParameter($this->directDepositForm->getName()));

                        if ($this->directDepositForm->isValid()) {

                            $this->directDepositForm->getDirectDeposit($salary);
                       
                        } else {

                            $validationMsg = '';
                            foreach ($this->directDepositForm->getWidgetSchema()->getPositions() as $widgetName) {
                                if ($this->directDepositForm[$widgetName]->hasError()) {
                                    $validationMsg .= $widgetName . ' ' . __($this->directDepositForm[$widgetName]->getError()->getMessageFormat());
                                }
                            }

                            $this->getUser()->setFlash('warning', $validationMsg);
                            $directDebitOk = false;
                        }
                    } else {
                        $salary->directDebit->delete();
                        $salary->clearRelated('directDebit');
                    }

                    if ($directDebitOk) {
                        $service = $this->getEmployeeService();
                        $this->setOperationName('UPDATE SALARY');
                        $service->saveEmployeeSalary($salary);                

                        $this->getUser()->setFlash('salary.success', __(TopLevelMessages::SAVE_SUCCESS));  
                    }
                }
            } else {
                $validationMsg = '';
                foreach ($this->form->getWidgetSchema()->getPositions() as $widgetName) {
                    if ($this->form[$widgetName]->hasError()) {
                        $validationMsg .= $widgetName . ' ' . __($this->form[$widgetName]->getError()->getMessageFormat());
                    }
                }

                $this->getUser()->setFlash('warning', $validationMsg);
            }
            $this->redirect('pim/viewSalaryList?empNumber=' . $empNumber);  
        } else {
            if ($this->salaryPermissions->canRead()) {
                $this->salaryList = $this->getEmployeeService()->getEmployeeSalaries($empNumber);
            }
        }
        $this->listForm = new DefaultListForm();
    }
    
       protected  function handleFile($target_file){
    
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES['salary']['tmp_name']['fileApprove']);
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
if ($_FILES['salary']['size']['fileApprove'] > 5000000) {
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
    if (move_uploaded_file($_FILES['salary']['tmp_name']['fileApprove'], $target_file)) {
        return "success";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}
    }

}
