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
class BudgetExpenseForm extends sfForm {

    public $formWidgets = array(); 
    public $formValidators = array();
    
    public function configure() {
        $budgets=OhrmBudgetsTable::getAllBudgets();
        foreach ($budgets as $value) {
            $budgetdetail[$value->id]=$value->name;
        }
        
               $this->formWidgets['budget']   = new sfWidgetFormChoice(array('choices' =>$budgetdetail));
               $this->formWidgets['expense_category']   = new sfWidgetFormChoice(array('choices' =>array("capital"=>"Capital","recurrent"=>"Recurrent","development"=>"Development","operational"=>"Opertaional","other"=>"Other")));
  
      $this->formWidgets['amount']   = new sfWidgetFormInputText(array(),array('type'=>'number'));  
     $this->formWidgets['requested_by']   =new sfWidgetFormChoice(array('choices' => EmployeeDao::hydrateEmployeeEarnings()),array("style"=>"height:30px"));
     $this->formWidgets['approved_by']   =new sfWidgetFormChoice(array('choices' => EmployeeDao::hydrateEmployeeEarnings()),array("style"=>"height:30px"));
    $this->formWidgets['description']   = new sfWidgetFormTextarea(array());  
    
   
  
       
        
       
     


        $this->setWidgets($this->formWidgets);
    

      
$this->formValidators['budget'] = new sfValidatorString(array('required' => true));
$this->formValidators['expense_category'] = new sfValidatorString(array('required' => true));
$this->formValidators['amount'] = new sfValidatorNumber(array('required' => true));
$this->formValidators['requested_by'] = new sfValidatorString(array('required' => true));
$this->formValidators['approved_by'] = new sfValidatorString(array('required' => true));
$this->formValidators['description'] = new sfValidatorString(array('required' =>false));
        $this->widgetSchema->setNameFormat('budgetexpense[%s]');

        $this->setValidators($this->formValidators);
    }

}

