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
class InterviewForm  extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
    $this->formWidgets['candidate_first_name']  = new sfWidgetFormInputText(array());
        $this->formWidgets['candidate_middle_name']  = new sfWidgetFormInputText(array());
            $this->formWidgets['candidate_last_name']  = new sfWidgetFormInputText(array());
    $this->formWidgets['interviewer_name']  = new sfWidgetFormInputText(array());
    $this->formWidgets['interview_position']  = new sfWidgetFormInputText(array());
    $this->formWidgets['interview_date']  = new sfWidgetFormDateTime();
    $this->formWidgets['status']   = new sfWidgetFormChoice(array('choices' =>array("pending"=>"Pending","session"=>"In Session","conducted"=>"Conducted","failed"=>"Failed","passed"=>"Passed")));
    $this->formWidgets["interview_date"]->setLabel("dd/mm/YY");    
    $this->formWidgets["interview_date"]->setOption('date', array('format'=>' %day% %month% %year%'));
    $this->setWidgets($this->formWidgets);
    
 $this->formValidators['candidate_first_name'] = new sfValidatorString();
        $this->formValidators['candidate_middle_name'] = new sfValidatorString();
         $this->formValidators['candidate_last_name'] = new sfValidatorString();
        $this->formValidators['interviewer_name'] = new sfValidatorString();
        $this->formValidators['interview_position'] = new sfValidatorString();
        $this->formValidators['interview_date'] = new sfValidatorDateTime();
         $this->formValidators['status'] = new sfValidatorString();



        $this->widgetSchema->setNameFormat('interview[%s]');

        $this->setValidators($this->formValidators);
    }

}
