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
class viewEmployeeTimesheetAction extends baseTimeAction {

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
		
        $month=$request->getParameter("id");   

//$conn=$this->getBiometricDeviceConnection();

/*if(!$conn){


    die("Connection to Biometric Database could not be established");

}

$date=date("d-m-Y");
$tsql = "SELECT DISTINCT IdEmpSlot,tFullName,tIdentification,dtEventReal,tDesc,CONVERT(varchar(10),tblEvents.dtEventReal,105) as dateentered FROM dbo.tblEvents join dbo.tblEmployees on tblEvents.IdEmpNum=tblEmployees.iEmployeeNum where tDesc like '%entry%' and CONVERT(varchar(10),tblEvents.dtEventReal,105)='$date' group by IdEmpSlot,tFullName,tIdentification,dtEventReal,tDesc order by tblEvents.dtEventReal DESC ";  
//$tsql = "DELETE FROM dbo.User_ WHERE EMPLOYEEID='5456776'";  
$getProducts = sqlsrv_query($conn, $tsql);  
if ($getProducts == FALSE)  
    die( print_r( sqlsrv_errors(), true)); 
$productCount = 0;  
$alltimes=array();
while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
{  
   array_push($alltimes,$row);  
    //echo("<br/>");  
    //$productCount++;  
} */ 		
 $this->alltimesheets= OhrmTimesheetTable::getAllTimesheets();
 $this->id=$interviewid;
       /*$this->pager = new sfDoctrinePager('OhrmTimesheet:', sfConfig::get('app_max_jobs_on_homepage'));
       if(isset($month)){
           $this->pager->setQuery(Doctrine::getTable('OhrmTimesheet')->createQuery('a')->where(" DATE_FORMAT(`start_date`,'%m-%Y') like '$month'")->andWhere(" DATE_FORMAT(`end_date`,'%m-%Y') like '$month'"));
       }
       else{
          
        $this->pager->setQuery(Doctrine::getTable('OhrmTimesheet')->createQuery('a')->orderBy("end_date DESC"));
       }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();	*/
  
  $this->timesheets=$alltimes;
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

