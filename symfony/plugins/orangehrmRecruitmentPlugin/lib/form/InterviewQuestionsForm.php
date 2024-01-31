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
class InterviewQuestionsForm  extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

    $this->formWidgets['question']  = new sfWidgetFormInputText(array(),array("style"=>"width:50%"));
     $y=20; 
     $priority=array(""=>"Select Priority","1"=>1,"2"=>2,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"10"=>10,"11"=>11,"12"=>12,"13"=>13,"14"=>14,"15"=>15,"16"=>16,"17"=>17,"18"=>18);
    
      $this->formWidgets['priority']   = new sfWidgetFormChoice(array('choices' =>$priority));
    $this->formWidgets['weight']= new sfWidgetFormInputText();
     
$this->formWidgets['question']->setLabel("Benchmark");
$this->formWidgets['weight']->setLabel("Maximum weightage  (pts)");

        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['question'] = new sfValidatorString();
        $this->formValidators['priority'] = new sfValidatorInteger();
$this->formValidators['weight'] = new sfValidatorInteger();


        $this->widgetSchema->setNameFormat('interviewquestions[%s]');

        $this->setValidators($this->formValidators);
    }

}
