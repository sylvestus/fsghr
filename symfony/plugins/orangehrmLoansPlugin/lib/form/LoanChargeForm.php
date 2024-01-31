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
class LoanChargeForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
        public $formValidators1 = array();
    
    public function configure() {
    $this->formWidgets['name']  = new sfWidgetFormInputText();
     ;
    $this->formWidgets['category']= new sfWidgetFormChoice(array('choices' => array(''=>'Select Category','loan'=>'Loan','member'=> 'Member')));

       $this->formWidgets['calculation_method']   =new sfWidgetFormChoice(array('choices' => array( ''=>'Select Method','flat'=>'Flat', 'percent'=>'Percent','formula'=>'Formula')));
     $this->formWidgets['percentage_of']   =new sfWidgetFormChoice(array('choices' => array(''=>'Select Option','transactionAmount'=>'Transaction Amount', 'loan'=>'Loan')));
   $this->formWidgets['amount']   = new sfWidgetFormInputText();
     $this->formWidgets['fee']   = new sfWidgetFormInputCheckbox(array(),array("value"=>1));
     $this->formWidgets['payment_method']   = new sfWidgetFormInputHidden();
//        $this->formWidgets['created_at']   = new sfWidgetFormInputHidden();
//           $this->formWidgets['updated_at']   = new sfWidgetFormInputHidden();

  
        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['name'] = new sfValidatorString(array('required' => true));
$this->formValidators['category'] = new sfValidatorString(array('required' => true));
$this->formValidators['calculation_method'] = new sfValidatorString(array('required' => true));
$this->formValidators['percentage_of'] = new sfValidatorString(array('required' => true));
$this->formValidators['amount'] = new sfValidatorInteger(array('required' => true));
$this->formValidators['fee'] = new sfValidatorInteger(array('required' => false));
$this->formValidators['payment_method'] = new sfValidatorString(array('required' => FALSE));
$this->formValidators['created_at'] = new sfValidatorString(array('required' =>FALSE));
$this->formValidators['updated_at'] = new sfValidatorString(array('required' =>FALSE));

$loancharges=  new OhrmLoanCharges();

$this->widgetSchema['fee']->setDefault($loancharges->getFee());
$this->widgetSchema['payment_method']->setDefault($loancharges->getPaymentMethod());
//$this->widgetSchema['created_at']->setDefault($loancharges->getCreatedAt());
//$this->widgetSchema['updated_at']->setDefault($loancharges->getUpdatedAt());


        $this->widgetSchema->setNameFormat('loancharges[%s]');
   $this->widgetSchema->setLabel("fee","Is fee?");
  
   //defaults

   
        $this->setValidators($this->formValidators);
    }

}

