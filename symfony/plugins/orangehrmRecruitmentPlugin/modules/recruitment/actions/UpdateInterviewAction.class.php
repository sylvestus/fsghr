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
 *
 */
class UpdateInterviewAction extends baseAction {

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

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {
        $status=$request->getParameter('status');
              $action=$request->getParameter('action');
                $id=$request->getParameter('id');
                if  (isset($status)) {
                $interview=  Ohrm_InterviewTable::getInterview($id);
                 $interview->setStatus($status); 
                       $interview->setAverageMark($request->getParameter('catch'));
                 $interview->save();
                     $this->getUser()->setFlash('success', __('Interview Status marked as '.$status));
                 $this->redirect('recruitment/candidateInterviews?id='.$id);    
        }
                
      else if($request->isMethod('post')) {
   
     $id=$request->getParameter('id');

              $this->setForm(new InterviewForm(array(), $optionsForForm, true));
                $postArray = $request->getPostParameters();
               unset($postArray['_csrf_token']);
                $_SESSION['approveApplication'] = $postArray;
                     $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid()) {
           $interviewquestions=  Ohrm_InterviewTable::getInterview($id);
         $interviewquestions->setCandidateFirstName($this->form->getValue('candidate_first_name'));
           $interviewquestions->setCandidateMiddleName($this->form->getValue('candidate_middle_name'));
              $interviewquestions->setCandidateLastName($this->form->getValue('candidate_last_name'));
            $interviewquestions->setInterviewerName($this->form->getValue('interviewer_name'));
            $interviewquestions->setInterviewPosition($this->form->getValue('interview_position'));
                $interviewquestions->setInterviewDate(date("Y-m-d H:i:s",  strtotime($this->form->getValue('interview_date'))));
                 $interviewquestions->setStatus($this->form->getValue('status'));
                $interviewquestions->save();

  
 
    $this->getUser()->setFlash('success', __('Successfully added interview'));
     $this->redirect('recruitment/interviews');     
            
   }
    else {

      $this->getUser()->setFlash('error', __('Invalid form details'));
 }
            }
      
                   else {

                $this->id=$id;
                 $interviewquestions=  Ohrm_InterviewTable::getInterview($id);
              $this->setForm(new InterviewForm(array("interview_date"=>date("Y-m-d H:i:s"),"candidate_first_name"=>$interviewquestions->getCandidateFirstName(),"candidate_middle_name"=>$interviewquestions->getCandidateMiddleName(),"candidate_last_name"=>$interviewquestions->getCandidateLastName(),"interviewer_name"=>$interviewquestions->getInterviewerName(),"interview_position"=>$interviewquestions->getInterviewPosition(),"status"=>$interviewquestions->getStatus()),$optionsForForm, true));
 }
    }

  

}
