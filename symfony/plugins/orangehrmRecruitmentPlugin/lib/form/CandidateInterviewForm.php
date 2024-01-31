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
class CandidateInterviewForm  extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
 $this->formWidgets['interview_id']= new sfWidgetFormChoice(array("choices"=> Ohrm_InterviewTable::hydrateInterviews()));
//    $this->formWidgets['question_id']  = new sfWidgetFormChoice(array("choices"=> Ohrm_InterviewSetupTable::hydrateQuestions()));
  //$this->formWidgets['response_weight']  = new sfWidgetFormInputText();
  // $this->formWidgets['remark']  = new sfWidgetFormTextarea();
   
     
$this->formWidgets['interview_id']->setLabel("Interview Session");
//$this->formWidgets['question_id']->setLabel("Evaluation Criteria");

        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['interview_id'] = new sfValidatorInteger();
        $this->formValidators['question_id'] = new sfValidatorInteger();
$this->formValidators['response_weight'] = new sfValidatorString(array("required"=>FALSE));
$this->formValidators['remark'] = new sfValidatorString();


        $this->widgetSchema->setNameFormat('candidateinterview[%s]');

        $this->setValidators($this->formValidators);
    }

}
