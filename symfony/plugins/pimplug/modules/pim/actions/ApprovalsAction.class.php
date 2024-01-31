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
class ApprovalsAction extends baseAdminAction {

    private $customerService;

    public function getCustomerService() {
        if (is_null($this->customerService)) {
            $this->customerService = new CustomerService();
            $this->customerService->setCustomerDao(new CustomerDao());
        }
        return $this->customerService;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
      
        $trails=AuditTrailTable::getApprovedRejectedAuditTrail(0,5000);
       // die(print_r($trails));
        $this->trails=$trails;  
      
    }

    /**
     *
     * @param <type> $customerList
     * @param <type> $noOfRecords
     * @param <type> $pageNumber
     */
    private function _setListComponent($customerList, $noOfRecords, $pageNumber, $permissions) {
        $runtimeDefinitions = array();
        $buttons = array();

        if ($permissions->canCreate()) {
            $buttons['Add'] = array('label' => 'Add');
        }

        if (!$permissions->canDelete()) {
            $runtimeDefinitions['hasSelectableRows'] = false;
        } else if ($permissions->canDelete()) {
            $buttons['Delete'] = array('label' => 'Delete',
                'type' => 'submit',
                'data-toggle' => 'modal',
                'data-target' => '#deleteConfModal',
                'class' => 'delete');
        }
        $isLinkable = false;
        if($permissions->canUpdate()){
            $isLinkable = true;
        }

        $runtimeDefinitions['buttons'] = $buttons;
   
        $configurationFactory = new CustomerHeaderFactory();
        $configurationFactory->setIsLinkable($isLinkable);
        $configurationFactory->setRuntimeDefinitions($runtimeDefinitions);
        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($customerList);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords($this->getCustomerService()->getCustomerCount());
    }

}

