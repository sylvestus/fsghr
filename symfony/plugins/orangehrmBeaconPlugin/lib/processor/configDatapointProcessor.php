<?php

/**
 * TechSavannaHRM Enterprise is a closed sourced comprehensive Human Resource Management (HRM)
 * System that captures all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM Inc is the owner of the patent, copyright, trade secrets, trademarks and any
 * other intellectual property rights which subsist in the Licensed Materials. TechSavannaHRM Inc
 * is the owner of the media / downloaded TechSavannaHRM Enterprise software files on which the
 * Licensed Materials are received. Title to the Licensed Materials and media shall remain
 * vested in TechSavannaHRM Inc. For the avoidance of doubt title and all intellectual property
 * rights to any design, new software, new protocol, new interface, enhancement, update,
 * derivative works, revised screen text or any other items that TechSavannaHRM Inc creates for
 * Customer shall remain vested in TechSavannaHRM Inc. Any rights not expressly granted herein are
 * reserved to TechSavannaHRM Inc.
 *
 * Please refer http://www.techsavanna.technology/Files/OrangeHRM_Commercial_License.pdf for the license which includes terms and conditions on using this software.
 *
 */
class configDatapointProcessor extends AbstractBaseProcessor {

    public function process($definition) {
        $beaconConfigService = new BeaconConfigurationService();
        if (!isset($definition)) {
            return null;
        }

        $result = null;
        try {
            $datapoint = new SimpleXMLElement($definition);
            if ($datapoint['type'] == "config") {
                $key = trim($datapoint->parameters->key."");
                $name = trim($datapoint->settings->name."");
                $value = null;
                if (isset($key)) {
                    $value = $beaconConfigService->getConfigValue($key);
                }
                $result = $value;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $result;
    }

//put your code here
}
