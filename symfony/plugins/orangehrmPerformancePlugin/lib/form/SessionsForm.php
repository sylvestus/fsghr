<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class SessionsForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
    $this->formWidgets['title']  = new sfWidgetFormInputText();
    $depts= OhrmTrainingCoursesTable::getAllCourses();
    foreach ($depts as $value) {
        $courses[$value->id]=$value->course_title;
    }
      $this->formWidgets['date']   = new sfWidgetFormInputText(array(),array('class'=>'datetimepicker'));
   
       $this->formWidgets['project']   = new sfWidgetFormInputText();
              $this->formWidgets['trainer']   = new sfWidgetFormInputText();
       $this->formWidgets['course']= new sfWidgetFormChoice(array('choices' =>$courses));
       $this->formWidgets['status']= new sfWidgetFormChoice(array('choices' =>array('pending'=>'Pending','completed'=>'Completed'))); 
     


        $this->setWidgets($this->formWidgets);
    

      
$this->formValidators['title'] = new sfValidatorString(array('required' => true));
$this->formValidators['date'] = new sfValidatorString(array('required' => true));
$this->formValidators['project'] = new sfValidatorString(array('required' => true));
$this->formValidators['trainer'] = new sfValidatorString(array('required' => true));
$this->formValidators['course'] = new sfValidatorString(array('required' => true));
$this->formValidators['status'] = new sfValidatorString(array('required' => true));

        $this->widgetSchema->setNameFormat('trainingsession[%s]');

        $this->setValidators($this->formValidators);
    }

}

