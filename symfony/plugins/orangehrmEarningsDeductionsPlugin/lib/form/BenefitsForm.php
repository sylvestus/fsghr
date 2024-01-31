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
class BenefitsForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
           
      
    $this->formWidgets['name']= new sfWidgetFormInputText();
      $this->formWidgets['taxable']   = new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','1'=>'Y','0'=> 'N')));
        $this->formWidgets['is_recurring']   = new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','1'=>'Y','0'=> 'N')));
         $this->formWidgets['calculation_type']   = new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','fixed'=>'Fixed','salarypercentage'=> 'Percentage Of Salary','daysinyear'=>'Days in Year')));
         $this->formWidgets['monthly_rate']= new sfWidgetFormInputText();
         $this->formWidgets['active']   =new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','1'=>'Y','0'=> 'N'))); 
  
        
        //labels
      

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['name'] = new sfValidatorString();
  $this->formValidators['calculation_type'] = new sfValidatorString();
    $this->formValidators['monthly_rate'] = new sfValidatorNumber();
$this->formValidators['taxable'] = new sfValidatorInteger();
$this->formValidators['is_recurring'] = new sfValidatorInteger();
$this->formValidators['active'] = new sfValidatorInteger();


        $this->widgetSchema->setNameFormat('benefits[%s]');

        $this->setValidators($this->formValidators);
    }

}

