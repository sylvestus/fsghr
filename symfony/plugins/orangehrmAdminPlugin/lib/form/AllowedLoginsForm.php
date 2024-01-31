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
 *
 */
class AllowedLoginsForm extends BaseForm {

    private $user_id = null;
    private $systemUserService;
    public $edited = false;

    public function getSystemUserService() {
        $this->systemUserService = new SystemUserService();
        return $this->systemUserService;
    }

    public function configure() {

        $this->user_id = $this->getOption('user_id');
        $empNameStyle = array("class" => "formInputText inputFormatHint", "maxlength" => 200, "value" => __("Type for hints") . "...");
        if (!empty($this->user_id)) {
            $this->edited = true;
            $empNameStyle = array("class" => "formInputText", "maxlength" => 200);
        }
        $userRoleList = $this->getAssignableUserRoleList();
       
        $statusList = $this->getStatusList();

        $this->setWidgets(array(
            'user_id' => new sfWidgetFormInputHidden(),
          
                       'employee_id' => new ohrmWidgetEmployeeNameAutoFill(array(), $empNameStyle),
               
            'ip_address' => new sfWidgetFormInputText(array(), array("class" => "formInputText", "maxlength" => 40)),
            'mac_address' => new sfWidgetFormInputText(array(), array("class" => "formInputText", "maxlength" => 100)),
            'status' => new sfWidgetFormSelect(array('choices' => $statusList), array("class" => "formSelect", "maxlength" => 3)),
            
        ));

        $this->setValidators(array(
            'user_id' => new sfValidatorNumber(array('required' => false)),
            
            'employee_id' => new ohrmValidatorEmployeeNameAutoFill(),
            'ip_address' => new sfValidatorString(array('required' => true, 'max_length' => 40)),
            'mac_address' => new sfValidatorString(array('required' => true, 'max_length' => 40)),
           
            'status' => new sfValidatorString(array('required' => true, 'max_length' => 1)),
           
        ));


        $this->widgetSchema->setNameFormat('allowedLogins[%s]');

        if ($this->user_id != null) {
            $this->setDefaultValues($this->user_id);
        } else {
            $this->setDefault('userType', 2);
        }

        $this->getWidgetSchema()->setLabels($this->getFormLabels());

        

    }

    private function setDefaultValues($locationId) {

        $systemUser = $this->getSystemUserService()->getSystemUser($this->user_id);

        $this->setDefault('user_id', $systemUser->getId());
             $this->setDefault('employee_id', array('empName' => $systemUser->getEmployee()->getFullName(), 'empId' => $systemUser->getEmployee()->getEmpNumber()));
        
        $this->setDefault('status', $systemUser->getStatus());
    }

    /**
     * Get Pre Defined User Role List
     * 
     * @return array
     */
    private function getAssignableUserRoleList() {
        $list = array();
        $userRoles = $this->getSystemUserService()->getAssignableUserRoles();
        
        $accessibleRoleIds = UserRoleManagerFactory::getUserRoleManager()->getAccessibleEntityIds('UserRole');
        
        foreach ($userRoles as $userRole) {
            if (in_array($userRole->getId(), $accessibleRoleIds)) {
                $list[$userRole->getId()] = $userRole->getDisplayName();
            }
        }
        return $list;
    }

    private function getStatusList() {
        $list = array();
        $list[1] = __("Enabled");
        $list[0] = __("Disabled");

        return $list;
    }

  
    public function getEmployeeListAsJson() {

        $jsonArray = array();
        $employeeService = new EmployeeService();
        $employeeService->setEmployeeDao(new EmployeeDao());

        $employeeList = $employeeService->getEmployeeList();

        $employeeUnique = array();
        foreach ($employeeList as $employee) {
            $workShiftLength = 0;

            if (!isset($employeeUnique[$employee->getEmpNumber()])) {

                $name = $employee->getFullName();

                $employeeUnique[$employee->getEmpNumber()] = $name;
                $jsonArray[] = array('name' => $name, 'id' => $employee->getEmpNumber());
            }
        }

        $jsonString = json_encode($jsonArray);

        return $jsonString;
    }

    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $required = '<em> *</em>';
        $labels = array(
          
            'employee_id' => __('Employee Name') . $required,
              'status' => __('Status') . $required,
           
        );

        return $labels;
    }

}