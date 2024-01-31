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
class saveDocumentAction extends basePimAction {
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setEducationForm(sfForm $form) {
        if (is_null($this->educationForm)) {
            $this->educationForm = $form;
        }
    }
    
    public function execute($request) {
  
        if ($request->isMethod('post')) {
 $employeeid=$request->getParameter("employee");
  $document=$request->getParameter("document");
   $remarks=$request->getParameter("remarks");
    $status=$request->getParameter("status");
   $documentsch=new DocumentsChecklist();
   $documentsch->setEmpNumber($employeeid);
   $documentsch->setStatus($status);
   $documentsch->setDocument($document);
   $documentsch->setRemarks($remarks);
   $saved=$documentsch->save();
 echo "document checklist saved";
           
   
    
    
        }
   exit(); 
    }

    private function getEducation(sfForm $form) {

        $post = $form->getValues(); 
        
        $isAllowed = FALSE;
        if (!empty($post['id'])) {
            if($this->educationPermissions->canUpdate()){
                $education = $this->getEmployeeService()->getEducation($post['id']);
                $isAllowed = TRUE;
            }
        } 
        
        if (!$education instanceof EmployeeEducation) {
            if ($this->educationPermissions->canCreate()) {
                $education = new EmployeeEducation();
                $isAllowed = TRUE;
            }
        }        

        if ($isAllowed) {
            $education->empNumber = $post['emp_number'];
            $education->educationId = $post['code'];
            $education->institute = $post['institute'];
            $education->major = $post['major'];
            $education->year = $post['year'];
            $education->score = $post['gpa'];
            $education->startDate = $post['start_date'];
            $education->endDate = $post['end_date'];
        }
        
        return $education;
    }
}
?>