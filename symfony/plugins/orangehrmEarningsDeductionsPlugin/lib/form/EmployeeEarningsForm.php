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
class EmployeeEarningsForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
      
   
           
      
    $this->formWidgets['earning_id']= new sfWidgetFormChoice(array('choices' => EarningsDao::hydrateEarnings()));
    $this->formWidgets['emp_number']   =new sfWidgetFormChoice(array('choices' => EmployeeDao::hydrateEmployeeEarnings(),'multiple'=>true),array("style"=>"height:100px"));
      $this->formWidgets['amount']   = new sfWidgetFormInputText();
        $this->formWidgets['earnings_date']   =  new sfWidgetFormDate(array());
          $this->formWidgets['active'] =new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','1'=>'Y','0'=> 'N'))); 
  
        
        //labels
      
$this->formWidgets["earnings_date"]->setOption( 'format',' %day% %month% %year%');
   $this->formWidgets['emp_number']->setLabel("Employee");
        $this->setWidgets($this->formWidgets);
 

        $this->formValidators['earning_id'] = new sfValidatorInteger();
    $this->formValidators['emp_number'] = new sfValidatorString();
$this->formValidators['amount'] = new sfValidatorNumber();
$this->formValidators['earnings_date'] = new sfValidatorDate();
$this->formValidators['active'] = new sfValidatorInteger();


        $this->widgetSchema->setNameFormat('employeeearnings[%s]');

        $this->setValidators($this->formValidators);
    }

}

