<?php

class offDaysAction extends baseLeaveAction {

   public function execute($request) {
$payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
 $date=  DateTime::createFromFormat("m/Y",$month);
 $year=$date->format("Y");
        
         $employeedao =new EmployeeDao();
        $allentitlements=array();
      
     $empNumber = $request->getParameter('empNumber');
        $isPaging = $request->getParameter('hdnAction') == 'search' ? 1 : $request->getParameter('pageNo', 1);

        $pageNumber = $isPaging;
     $noOfRecords = sfConfig::get('app_items_per_page');

        $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;

      

        $this->form = new EmployeeSearchForm($this->getFilters());
        if ($request->isMethod('post')) {
$post=$request->getPostParameters();

if($post["hdnAction"]=="reset"){ //if reset
    $this->form = new EmployeeSearchForm();
        $employees=EmployeeDao::getEmployees();
           foreach ($employees as $emp) {
                            $empno=$emp->getEmpNumber();
             if(is_numeric($empno)){

             $leaveentitlements= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($leaveentitlements)){
                 array_push($allentitlements,$leaveentitlements);
             }

             }
         }
}
else{
$searchparams=$post["empsearch"];

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                
                if($this->form->getValue('isSubmitted')=='yes'){
                    $employeedao=new EmployeeDao();
                    if($searchparams["employee_name"]["empId"]){
                        $empNumber=$searchparams["employee_name"]["empId"];
                //die($empNumber);
              $employees=  array(EmployeeDao::getEmployeeByNumber($empNumber)) ;
                   foreach ($employees as $emp) {
                            $empno=$emp->getEmpNumber();
             if(is_numeric($empno)){
             $employeentitlement= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($employeentitlement)){
                 array_push($allentitlements, $employeentitlement);
             }

             }
         }
       
                    } 
                    //search by department
                    elseif ($searchparams["sub_unit"] && !$searchparams["employee_name"]["empId"]) {
                        $dept=$searchparams["sub_unit"];
                        $empdao=new EmployeeDao();
                        
                        $employees=$empdao->getEmployeesByDepartment($dept);
                             foreach ($employees as $emp) {
                            $empno=$emp->getEmpNumber();
             if(is_numeric($empno)){
             $employeentitlement= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($employeentitlement)){
                 array_push($allentitlements, $employeentitlement);
             }

             }
         }
                }
                //search by location
                elseif ($searchparams["location"] && !$searchparams["employee_name"]["empId"]) {
                        $location=$searchparams["location"];
                     
                        $empdao=new EmployeeDao();
                        $employees=$empdao->getEmployeesByBranch($location);
                        foreach ($employees as $emp) {
                            $empno=$emp->getEmpNumber();
             if(is_numeric($empno)){
             $employeentitlement= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($employeentitlement)){
                 array_push($allentitlements, $employeentitlement);
             }

             }
         }
                }
                  
                    
                    
                }         
                
                $this->setFilters($this->form->getValues());
                
            } else {
                $this->setFilters(array());
            }

            $this->setPage(1);
        }
        }
        else{
        
       $employees= $employeedao->getEmployeeIdList(TRUE);
       
        foreach ($employees as $empno) {
             if(is_numeric($empno)){
             $employeentitlement= OhrmLeaveEntitlementTable::getEmployeeLeave($empno,$year);
             
             if(is_array($employeentitlement)){
                 array_push($allentitlements, $employeentitlement);
             }

             }
         }
        }
 
 
 
 
          $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
        
        
         $this->year=$year;

}

}