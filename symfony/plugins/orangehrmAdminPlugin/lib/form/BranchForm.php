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
class BranchForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {

   
           
         $this->formWidgets['bank_id']=new sfWidgetFormChoice(array('choices' => Ohrm_BankTable::hydrateBanks())); 
    $this->formWidgets['branch_code']= new sfWidgetFormInputText();
    $this->formWidgets['branch_name']= new sfWidgetFormInputText();

    
        //labels
      

//$this->validatorSchema['yourfield'] = new sfValidatorPass();
        $this->setWidgets($this->formWidgets);
            $this->formValidators['branch_name'] = new sfValidatorString();
$this->formValidators['bank_id'] = new sfValidatorInteger();
        $this->formValidators['branch_code'] = new sfValidatorString();
 


        $this->widgetSchema->setNameFormat('bankbranch[%s]');

        $this->setValidators($this->formValidators);
    }

}

