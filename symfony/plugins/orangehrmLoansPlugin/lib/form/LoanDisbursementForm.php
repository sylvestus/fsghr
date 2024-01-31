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
class LoanDisbursementForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
           
      
    $this->formWidgets['disbursal_date']= new sfWidgetFormDate($options=array());
      $this->formWidgets['amount_disbursed']   = new sfWidgetFormInputText();  
        $this->formWidgets['repayment_start']   =new sfWidgetFormDate($options=array()); 
        $this->formWidgets['payment_mode']   =new sfWidgetFormChoice(array("choices"=>array(""=>"SELECT PAYMENT MODE","cash"=>"CASH","cheque"=>"CHEQUE")));
 
  
        
        //labels
      
$this->formWidgets['repayment_start']->setLabel("Repayment Start Date");
  $this->formWidgets["repayment_start"]->setOption( 'format',' %day% %month% %year%');
    $this->formWidgets["disbursal_date"]->setOption( 'format',' %day% %month% %year%');

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
    


$this->formValidators['repayment_start'] = new sfValidatorDate();
$this->formValidators['disbursal_date'] = new sfValidatorDate();
$this->formValidators['amount_disbursed'] = new sfValidatorNumber();
$this->formValidators['payment_mode'] = new sfValidatorString();
$this->formValidators['cheque_date'] = new sfValidatorString(array("required"=>FALSE));
$this->formValidators['cheque_no'] = new sfValidatorString(array("required"=>FALSE));
$this->formValidators['cheque_details'] = new sfValidatorString(array("required"=>FALSE));


        $this->widgetSchema->setNameFormat('loandisbursal[%s]');

        $this->setValidators($this->formValidators);
    }

}

