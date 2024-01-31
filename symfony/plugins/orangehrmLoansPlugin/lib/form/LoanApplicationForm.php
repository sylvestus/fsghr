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
class LoanApplicationForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
    $this->formWidgets['member_id']  = new sfWidgetFormInputHidden();
    $this->formWidgets['loanproduct_id']=new sfWidgetFormChoice(array('choices' => LoanProductsDao::hydrateLoanProducts()));
           
      
    $this->formWidgets['application_date']= new sfWidgetFormDate();
      $this->formWidgets['amount_applied']   = new sfWidgetFormInputText();  
        $this->formWidgets['period']   =  new sfWidgetFormInputHidden($options=array(),array("value"=>1));
              $this->formWidgets['monthly_principle']   = new sfWidgetFormInputText();  
        $this->formWidgets['repayment_duration']   = new sfWidgetFormInputText($options=array(),array("readonly"=>"readonly"));  
         $this->formWidgets['reason_applied']   = new sfWidgetFormTextarea(array());  
      
         $this->formWidgets["application_date"]->setOption( 'format',' %day% %month% %year%');
        //labels
        $this->formWidgets['loanproduct_id']->setLabel("Loan product");
$this->formWidgets['period']->setLabel("Loan Period (months)");
$this->formWidgets['repayment_duration']->setLabel("Repayment Duration  (months)");

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['member_id'] = new sfValidatorNumber();
$this->formValidators['loanproduct_id'] = new sfValidatorInteger(array('required' => TRUE));
$this->formValidators['application_date'] = new sfValidatorDate();
$this->formValidators['amount_applied'] = new sfValidatorNumber();
$this->formValidators['monthly_principle'] = new sfValidatorNumber();
$this->formValidators['period'] = new sfValidatorNumber();
$this->formValidators['repayment_duration'] = new sfValidatorNumber();
$this->formValidators['reason_applied'] = new sfValidatorString();

        $this->widgetSchema->setNameFormat('loanapplication[%s]');

        $this->setValidators($this->formValidators);
    }

}

