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
 * ViewJobDetailsAction
 */
class viewDocumentsAction extends basePimAction {

    public function execute($request) {
        
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $job = $request->getParameter('job');
        $empNumber = (isset($job['emp_number'])) ? $job['emp_number'] : $request->getParameter('empNumber');
        
        $this->activeEmploymentForm = new ActiveEmploymentForm( array(),array(),true);
        /*
         * TODO: $empNumber gets empty when uploaded file size exceeds PHP max upload size.
         * Check for a better solution.
         */
        if (empty($empNumber)) {
            $this->getUser()->setFlash('jobdetails.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            $this->redirect($request->getReferer());
        }
        
        $this->empNumber = $empNumber;
        
       

        }
  

}
