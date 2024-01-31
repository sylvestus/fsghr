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
 * configPimAction
 *
 */
class confirmEmployeeAction extends basePimAction {

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
        //authentication
    $empNumber=$request->getParameter("empNumber");
$employeedao=new EmployeeDao();

$emp=$employeedao->getEmployee($empNumber);
$emp->setOnProbation(0);
$emp->save();
$this->employee=$emp;
    }

    /**
     *
     * @param type $post array of POST variables
     * @param type $postVar Post variable containing config value
     * @param type $configKey Key used in config table
     */
    private function _saveConfigValue($post, $postVar, $configKey) {

        $value = false;
        if (isset($post[$postVar]) && $post[$postVar] == 'on') {
            $value = true;
        }
        OrangeConfig::getInstance()->setAppConfValue($configKey, $value);
    }

}

?>
