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
class CoursesForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
    $this->formWidgets['course_title']  = new sfWidgetFormInputText();
    $depts=OhrmSubunitTable::getAllDepartments();
    foreach ($depts as $value) {
        $departments[$value->id]=$value->name;
    }
      $this->formWidgets['subunit']   = new sfWidgetFormChoice(array('choices' =>$departments));
   
       $this->formWidgets['coordinator']   = new sfWidgetFormInputText();
       $this->formWidgets['cost']   = new sfWidgetFormInputText();
       
        $this->formWidgets['status']= new sfWidgetFormChoice(array('choices' => array('active'=>'active','inactive'=> 'disabled')));
       
     


        $this->setWidgets($this->formWidgets);
    

      
$this->formValidators['course_title'] = new sfValidatorString(array('required' => true));
$this->formValidators['subunit'] = new sfValidatorString(array('required' => true));
$this->formValidators['cost'] = new sfValidatorNumber(array('required' => true));
$this->formValidators['status'] = new sfValidatorString(array('required' => true));

$this->formValidators['coordinator'] = new sfValidatorString(array('required' => false));
        $this->widgetSchema->setNameFormat('course[%s]');

        $this->setValidators($this->formValidators);
    }

}

