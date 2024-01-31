<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of baseTimeAction
 *
 * @author nirmal
 */
abstract class baseTimeAction extends sfAction {

    public function getDataGroupPermissions($dataGroups, $empNumber = null) {
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

        $entities = array();
        $self = false;
        if (isset($empNumber)) {
            $entities = array('Employee' => $empNumber);
            if ($empNumber == $loggedInEmpNum) {
                $self = true;
            }
        }

        return $this->getContext()->getUserRoleManager()->getDataGroupPermissions($dataGroups, array(), array(), $self, $entities);
    }
    
    /**
     * Get resulting state when given action is performed on the given timesheet
     * 
     * @param Timesheet $timesheet
     * @param int $action Action
     * @param bool $self true if operating on own timesheet
     * @return string
     */
    protected function getResultingState($timesheet, $action, $self) {
        
        $resultingState = $timesheet->getState();
        
        $excludeRoles = array();
        $includeRoles = array();
        $entities = array('Employee' => $timesheet->getEmployeeId());

        if ($self) {
            $includeRoles[] = 'ESS';
        }
        
        $userRoleManager = $this->getContext()->getUserRoleManager();
        $allowedActions = $userRoleManager->getAllowedActions(PluginWorkflowStateMachine::FLOW_TIME_TIMESHEET, 
                $timesheet->getState(), $excludeRoles, $includeRoles, $entities);

        if (isset($allowedActions[$action])) {
            $resultingState = $allowedActions[$action]->getResultingState();
        }         
        
        return $resultingState;
    }    
	
	public function getBiometricDeviceConnection(){
/*try {
    $conn = new PDO("sqlsrv:server = tcp:vdrs6q2l4b.database.windows.net,1433; Database =swype_test", "terrasof", "Terra2012.");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}*/									


// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "biometric", "pwd" => "trymenot#", "Database" => "AxTrax1", "LoginTimeout" => 30, "Encrypt" => 0, "TrustServerCertificate" => 1);
$serverName ="SHILLOAHSERVER\VERITRAX,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo) or die( print_r( sqlsrv_errors(), true));
return $conn;

}
	
	

}

