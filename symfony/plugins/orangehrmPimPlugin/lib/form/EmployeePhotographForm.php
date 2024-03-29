<?php
/**
 * SavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 SavannaHRM Inc., http://www.orangehrm.com
 *
 * SavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * SavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class EmployeePhotographForm extends BaseForm {
    
    public $fullName;
    private $employeeService;
    private $widgets = array();

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if(is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }
    
    public function configure() {
        $this->photographPermissions = $this->getOption('photographPermissions');

        $empNumber = $this->getOption('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $this->fullName = $employee->getFullName();

        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => true)));
        
        if ($this->photographPermissions->canRead()) {

            $photographWidgets = $this->getPhotographWidgets();
            $photographValidators = $this->getPhotographValidators();

            if (!($this->photographPermissions->canUpdate()) ) {
                foreach ($photographWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $photographWidgets);
            $validators = array_merge($validators, $photographValidators);
        }
        $this->setWidgets($widgets);
        $this->setValidators($validators);
        
    }
    
    /**
     * Get form widgets
     * @return \sfWidgetFormInputFileEditable 
     */
    private function getPhotographWidgets() {
        $widgets = array(
            'photofile' => new sfWidgetFormInputFileEditable(array(
	            'edit_mode'=>false,
	            'with_delete' => false,
	            'file_src' => '')));
        return $widgets;
    }
    
    /**
     * Get validators
     * @return \sfValidatorFile 
     */
    private function getPhotographValidators() {
        $validators = array(
            'photofile' =>  new sfValidatorFile(
	        array(
	            'max_size' => 10000000,
	            'required' => true,
	        ))
        );
        return $validators;
    }
}
?>
