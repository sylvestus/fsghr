<?php

/*
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
 * PluginEmployee class file
 */

/**
 * Contains plugin level customizations of Employee class
 * @package    orangehrm
 * @subpackage model\pim\plugin
 */
abstract class PluginEmployee extends BaseEmployee {

    /**
     * Get First name and middle name
     * @return string 
     */
    public function getFirstAndMiddleName() {
        $name = $this->getFirstName();
        if ($this->getMiddleName() != '') {
            $name .= ' ' . $this->getMiddleName();
        }

        return $name;
    }

    /**
     * @ignore
     * @return type 
     */
    public function getFullLastName() {
        $terminationId = $this->getTerminationId();
        $name = (!empty($terminationId)) ? $this->getLastName() . " (" . __('Past Employee') . ")" : $this->getLastName();
        
        return $name;
    }

    /**
     * Get Job title name of an Employee
     * 
     * @return string 
     */
    public function getJobTitleName() {
        $jobTitle = $this->getJobTitle();
        $jobTitleName = '';
        if ($jobTitle instanceof JobTitle) {
            $jobTitleName = ($jobTitle->getIsDeleted() == JobTitle::DELETED) ? $jobTitle->getJobTitleName() . " (" . __("Deleted") . ")" : $jobTitle->getJobTitleName();
        }
        return $jobTitleName;
    }

}