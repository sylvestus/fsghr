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

/**
 * Actions class for PIM module dependents
 */
class terminationlistAction extends basePimAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $this->showBackButton = true;

        $dependentParams = $request->getParameter('dependent');
        $empNumber = (isset($dependentParams['empNumber'])) ? $dependentParams['empNumber'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        $this->dependentPermissions = $this->getDataGroupPermissions('dependents', $empNumber);

        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        //hiding the back button if its self ESS view
        if ($loggedInEmpNum == $empNumber) {
            $this->showBackButton = false;
        }

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
           $limit=$request->getParameter('limit');
            $page=$request->getParameter('page');
        $dates="ALL DATES";
    if ($this->getRequest()->isMethod('get')) {
    $offset=$request->getParameter('start');
         
            if(!$page){$page=1;} if(!$limit){$limit=500;} if(!$offset){$offset=0;}
          if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate')){
              
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("termination",$request->getParameter('location'),$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
         $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
             }
			  else if($request->getParameter('location')&& !$request->getParameter('fromdate') || !$request->getParameter('todate')){
              
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("termination",$request->getParameter('location'),"2016-01-01",date("Y-m-d"),$offset, $limit);
         $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $dates="ALL DATES";
             }
             else if(!$request->getParameter('location')&&$request->getParameter('fromdate')){
                 $location="All Locations";
           $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("termination",NULL,$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
       
         $dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
                   
             }
          else{
              $location="All Locations";
             $this->employees =  AuditTrailTable::getTrailByModule("termination",$offset, $limit);
          }
             $this->page=$page;
    }
    else{
        $offset=0;$limit=500;
        if($request->getParameter('location')&&$request->getParameter('fromdate')&&$request->getParameter('todate')){
             $this->employees =  AuditTrailTable::getTrailByModuleLocationTime("termination",$request->getParameter('location'),$request->getParameter('fromdate'),$request->getParameter('todate'),$offset, $limit);
            $locationdao=new LocationDao();
         $locationdetails=$locationdao->getLocationById($request->getParameter('location'));
         $location=$locationdetails->name;
         $this->dates=date("d/m/Y",strtotime($request->getParameter('fromdate')))." TO ".date("d/m/Y",strtotime($request->getParameter('todate')));
             } else{
         $this->employees =  AuditTrailTable::getTrailByModule("termination",$offset, $limit);
        $location="All Locations";
        
          }
         $this->page="Page 1";
    }
    
    $this->locationd=$location;
        $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
         $this->dates=$dates;
      // die(print_r($this->employees));
    }

}
