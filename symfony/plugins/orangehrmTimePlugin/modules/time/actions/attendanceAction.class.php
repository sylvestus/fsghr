<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class attendanceAction extends baseTimeAction {

    const NUM_PENDING_TIMESHEETS = 100;
    private $employeeNumber;
    private $timesheetService;

    public function getTimesheetService() {

        if (is_null($this->timesheetService)) {

            $this->timesheetService = new TimesheetService();
        }

        return $this->timesheetService;
    }

    public function execute($request) {
          
    
     $this->redirect('attendance/markRegister');  

   }
    
    public function getActionableTimesheets($employeeList) {
        $timesheetList = null;
        
        $accessFlowStateMachinService = new AccessFlowStateMachineService();
        $action = array(PluginWorkflowStateMachine::TIMESHEET_ACTION_APPROVE, PluginWorkflowStateMachine::TIMESHEET_ACTION_REJECT);
        $actionableStatesList = $accessFlowStateMachinService->getActionableStates(PluginWorkflowStateMachine::FLOW_TIME_TIMESHEET, AdminUserRoleDecorator::ADMIN_USER, $action);
        
        $empNumbers = array();
        
        foreach ($employeeList as $employee) {
            $empNumbers[] = $employee['empNumber'];
        }
        
        if ($actionableStatesList != null) {
            $timesheetList = $this->getTimesheetService()->getTimesheetListByEmployeeIdAndState($empNumbers, $actionableStatesList, self::NUM_PENDING_TIMESHEETS);
        }
        
        return $timesheetList;
    }    

}

