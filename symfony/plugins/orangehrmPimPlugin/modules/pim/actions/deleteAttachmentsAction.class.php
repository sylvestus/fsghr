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
 * Actions class for PIM module deleteAttachmentAction
 */
class deleteAttachmentsAction extends basePimAction {

    /**
     * Delete employee attachments
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function execute($request) {
        $this->form = new EmployeeAttachmentDeleteForm(array(), array(), true);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $empId = $request->getParameter('EmpID', false);
            if (!$empId) {
                throw new PIMServiceException("No Employee ID given");
            }
            
            if (!$this->IsActionAccessible($empId)) {
                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            }
            
            $attachmentsToDelete = $request->getParameter('chkattdel', array());
            if ($attachmentsToDelete) {
                $service = new EmployeeService();
                $service->deleteEmployeeAttachments($empId, $attachmentsToDelete);
                $this->getUser()->setFlash('listAttachmentPane.success', __(TopLevelMessages::DELETE_SUCCESS));
            }
        }

        $this->redirect($this->getRequest()->getReferer(). '#attachments');
    }

}
