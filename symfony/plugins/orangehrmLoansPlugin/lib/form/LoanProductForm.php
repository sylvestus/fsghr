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
class LoanProductForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
    $this->formWidgets['name']  = new sfWidgetFormInputText();
      $this->formWidgets['short_name']   = new sfWidgetFormInputText();
    $this->formWidgets['formula']= new sfWidgetFormChoice(array('choices' => array('RB'=>'RB','SL'=> 'SL')));
       $this->formWidgets['interest_rate']   = new sfWidgetFormInputText();
       $this->formWidgets['amortization']   =new sfWidgetFormChoice(array('choices' => array('EI'=>'EI', 'EP'=>'EP')));
     


        $this->setWidgets($this->formWidgets);
    

        $this->formValidators['interest_rate'] = new sfValidatorNumber();
$this->formValidators['name'] = new sfValidatorString(array('required' => true));
$this->formValidators['short_name'] = new sfValidatorString(array('required' => true));
$this->formValidators['amortization'] = new sfValidatorString(array('required' => true));
$this->formValidators['formula'] = new sfValidatorString(array('required' => true));

        $this->widgetSchema->setNameFormat('loanproduct[%s]');

        $this->setValidators($this->formValidators);
    }

}

