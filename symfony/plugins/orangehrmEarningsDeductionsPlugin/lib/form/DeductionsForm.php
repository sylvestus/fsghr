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
class DeductionsForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
           
      
    $this->formWidgets['name']= new sfWidgetFormInputText();
     $this->formWidgets['insurance_relief']   = new sfWidgetFormChoice(array('expanded' => FALSE, 'choices' => array(1 => __("Yes"), 0 => __("No"))));
     $this->formWidgets['is_percentage']   = new sfWidgetFormChoice(array('expanded' => FALSE, 'choices' => array(1 => __("Yes"), 0 => __("No"))));
      $this->formWidgets['percentage']   = new sfWidgetFormInputText();
      
      
       
  
        
        //labels
      

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['name'] = new sfValidatorString();
        $this->formValidators['insurance_relief'] = new sfValidatorNumber();
$this->formValidators['is_percentage'] = new sfValidatorNumber();
$this->formValidators['percentage'] = new sfValidatorNumber(array("required"=>FALSE));



        $this->widgetSchema->setNameFormat('deductions[%s]');

        $this->setValidators($this->formValidators);
    }

}

