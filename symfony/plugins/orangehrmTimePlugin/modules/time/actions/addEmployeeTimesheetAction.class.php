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
class addEmployeeTimesheetAction extends baseTimeAction {

  
 /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function getForm() {
        return $this->form;
    }
    public function execute($request) {
       if($request->isMethod('post')) {
                      
     $optionsForForm=array();
              $this->setForm(new EmployeeTimesheetForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
         $empnumbers=$postArray['employeetimesheet']['employee_id'];
    
        foreach ($empnumbers as $empnumber) {
        $interviewquestions=new OhrmTimesheet();
        $interviewquestions->setEmployeeId($empnumber);
            $interviewquestions->setStartDate(date("Y-m-d",  strtotime($this->form->getValue('start_date'))));
            $interviewquestions->setEndDate(date("Y-m-d",  strtotime($this->form->getValue('end_date'))));
                $interviewquestions->setState($this->form->getValue('state'));
                               $interviewquestions->save();

        }
 
    $this->getUser()->setFlash('success', __('Successfully added timesheet'));
     $this->redirect('time/viewEmployeeTimesheet');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
                   else {

            
              $this->setForm(new EmployeeTimesheetForm(array("start_date"=>date("d-m-Y"),"end_date"=>date("d-m-Y")),$optionsForForm, true));
 }  
 
   }
    
    

}

