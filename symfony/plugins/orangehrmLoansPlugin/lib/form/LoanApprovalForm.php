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
class LoanApprovalForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
           
      
    $this->formWidgets['approval_date']= new sfWidgetFormDate($options=array());
      $this->formWidgets['amount_approved']   = new sfWidgetFormInputText();  
        $this->formWidgets['period']   = new sfWidgetFormInputText();  
          $this->formWidgets['interest_rate']   = new sfWidgetFormInputText($options,array("readonly"=>"readonly"));  
  
        
        //labels
      $this->formWidgets["approval_date"]->setOption( 'format',' %day% %month% %year%');
$this->formWidgets['period']->setLabel("Loan Period (months)");
$this->formWidgets['interest_rate']->setLabel("Interest Rate  (monthly)");

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['interest_rate'] = new sfValidatorNumber();

$this->formValidators['approval_date'] = new sfValidatorDate();
$this->formValidators['amount_approved'] = new sfValidatorNumber();
$this->formValidators['period'] =new sfValidatorNumber();


        $this->widgetSchema->setNameFormat('loanapproval[%s]');

        $this->setValidators($this->formValidators);
    }

}

