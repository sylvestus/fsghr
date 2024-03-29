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
class MembershipService extends BaseService {

    private $membershipDao;

    public function __construct() {
        $this->membershipDao = new MembershipDao();
    }

    public function getMembershipDao() {
        return $this->membershipDao;
    }

    public function setMembershipDao(MembershipDao $MembershipDao) {
        $this->membershipDao = $MembershipDao;
    }

    public function getMembershipList() {
        return $this->membershipDao->getMembershipList();
    }

    public function getMembershipById($id) {
        return $this->membershipDao->getMembershipById($id);
    }

    public function deleteMemberships($membershipList) {
        return $this->membershipDao->deleteMemberships($membershipList);
    }

}

