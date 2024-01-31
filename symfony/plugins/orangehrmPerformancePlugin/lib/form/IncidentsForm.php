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
class IncidentsForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
     $this->formWidgets['employee']   =new sfWidgetFormChoice(array('choices' => EmployeeDao::hydrateEmployeeEarnings()));
    $locations=  OhrmLocationTable::getAllLocations();
     foreach ($locations as $value) {
        $courses[$value->id]=$value->name;
    }
    //departments
     $depts=OhrmSubunitTable::getAllDepartments();
    foreach ($depts as $value) {
        $departments[$value->id]=$value->name;
    }
    //violations
       $violations=  OhrmViolationTypeTable::getAllViolations();
    foreach ($violations as $value) {
        $violationtypes[$value->id]=$value->violation_type;
    }
      $this->formWidgets['branch']   = new sfWidgetFormChoice(array('choices' =>$courses));
   $this->formWidgets['subunit']   = new sfWidgetFormChoice(array('choices' =>$departments));
       $this->formWidgets['violation']   =new sfWidgetFormChoice(array('choices' =>$violationtypes));
       $this->formWidgets['date']   = new sfWidgetFormInputText(array(),array('class'=>'datetimepicker')); 
        $this->formWidgets['appealed']   = new sfWidgetFormChoice(array('choices' =>array("yes"=>"Yes","no"=>"No")));
      $this->formWidgets['verdict']   = new sfWidgetFormTextarea(array());  
       
     


        $this->setWidgets($this->formWidgets);
    

      
$this->formValidators['employee'] = new sfValidatorString(array('required' => true));
$this->formValidators['branch'] = new sfValidatorString(array('required' => true));
$this->formValidators['subunit'] = new sfValidatorString(array('required' => true));
$this->formValidators['violation'] = new sfValidatorString(array('required' =>true));
$this->formValidators['date'] = new sfValidatorString(array('required' =>true));
$this->formValidators['appealed'] = new sfValidatorString(array('required' =>true));
$this->formValidators['verdict'] = new sfValidatorString(array('required' =>false));

        $this->widgetSchema->setNameFormat('incidents[%s]');

        $this->setValidators($this->formValidators);
    }

}

