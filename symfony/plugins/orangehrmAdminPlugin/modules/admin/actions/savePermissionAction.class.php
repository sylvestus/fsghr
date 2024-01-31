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
class savePermissionAction extends baseAdminAction {

    /**
     * @param sfForm $form
     * @return
     */


    public function execute($request) {

        /* For highlighting corresponding menu item */
       

        if ($request->isMethod('post')) {
            $ohrmuserscreenid=$request->getParameter('id');
                  $ohrmuserscreenid=$request->getParameter('id');
                  $permission=$request->getParameter('permission');
                    $status=$request->getParameter('status');
                    $userrolescreen=OhrmUserRoleScreenTable::UpdateUserRoleScreen($ohrmuserscreenid, $permission, $status);
                    
                    die($ohrmuserscreenid." ".$permission." ".$status);
            }
         else {
            // check permissions
           die("no data posted");            
        }
    }

}

?>
