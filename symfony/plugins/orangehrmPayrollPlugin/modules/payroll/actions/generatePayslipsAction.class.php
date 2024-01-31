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
class generatePayslipsAction extends payrollActions {

    private $moduleService;

    public function getModuleService() {

        if (!($this->moduleService instanceof ModuleService)) {
            $this->moduleService = new ModuleService();
        }

        return $this->moduleService;
    }

    public function setModuleService($moduleService) {
        $this->moduleService = $moduleService;
    }

    public function execute($request) {
           $allslips=array();
      $multi = $request->getParameter("multi");
      if($multi){
          $monthss=array();
          $empno=$request->getParameter("ids");
        $monthfrom=$request->getParameter("monthfrom");
 $monthto=$request->getParameter("monthto");
  $fromyear=$request->getParameter("fromyear");
   $toyear=$request->getParameter("toyear");
 if ($monthfrom > $monthto &&  ($fromyear ==$toyear)) {
            $this->getUser()->setFlash('error', __('FROM month is greater than TO Month'));

            $this->redirect('payroll/processPayroll');
        }
 
         if ($fromyear > $toyear ) {
            $this->getUser()->setFlash('error', __('FROM year is greater than TO year'));

            $this->redirect('payroll/processPayroll');
        }
 
 
 if($fromyear==$toyear){  //if in the same year
     $i=$monthfrom;
 while($i<=$monthto){
     if(strlen($i)==1){
         $i="0".$i;
     }
     $monthyear=$i."/".$fromyear;
     array_push($monthss, $monthyear);
     $i++;
 }
 }
 
 else{
         $i=$monthfrom;
 while($i<=12){
     if(strlen($i)==1){
         $i="0".$i;
     }
     $monthyear=$i."/".$fromyear;
     array_push($monthss, $monthyear);
     $i++;
 }
 $j=1;
  $k=$monthto;
  
  while($j<=$k){
      if(strlen($j)==1){
         $j="0".$j;
     }
     $monthyear=$j."/".$toyear;
     array_push($monthss, $monthyear);
     $j++;
 }
 }
        
      //die(print_r($monthss));
         foreach ($monthss as $pmonth) {
            $pmonth=  str_replace("/","-",$pmonth);
           
             $employeeslip= PayslipTable::getPayslipForMonth($empno, $pmonth);
            
             if(is_object($employeeslip)){
                
                 array_push($allslips, $employeeslip->getId());
             }

          
         }
         //die(print_r($allslips));
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allslips=$allslips;
         $this->months=$monthss;
        
      }

      else{
           $empnumbers = $request->getParameter("id");
 $month=$request->getParameter("month");

        $employees = explode(",", $empnumbers);
      
         foreach ($employees as $empno) {
             if(is_numeric($empno)){
             $employeeslip= PayslipTable::getPayslipForMonth($empno, $month);
            
             if(is_object($employeeslip)){
                
                 array_push($allslips, $employeeslip->getId());
             }

             }
         }
         $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->allslips=$allslips;
         $this->month=$month;
      }
    }

    protected function _checkAuthentication() {

        $user = $this->getUser()->getAttribute('user');

        if (!$user->isAdmin()) {
            $this->redirect('payroll/processPayroll');
        }
    }

    protected function _resetModulesSavedInSession() {

        $this->getUser()->getAttributeHolder()->remove('admin.disabledModules');
        $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
    }

}
