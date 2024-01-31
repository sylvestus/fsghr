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

class WSUtilityService extends BaseService {

    const RESULT_FORMAT_JSON = 'json';

    protected $wsUtilityDao;

    /**
     *
     * @return WSUtilityDao 
     */
    public function getWSUtilityDao() {
        if (!($this->wsUtilityDao instanceof WSUtilityDao)) {
            $this->wsUtilityDao = new WSUtilityDao();
        }
        return $this->wsUtilityDao;
    }

    /**
     *
     * @param WSUtilityDao $webServiceUtilityDao 
     */
    public function setWSUtilityDao(WSUtilityDao $wsUtilityDao) {
        $this->wsUtilityDao = $wsUtilityDao;
    }

    /**
     *
     * @param mixed $result
     * @param string $format
     * @return mixed
     */
    public function format($result, $format) {
        if ($result instanceof Doctrine_Record || $result instanceof Doctrine_Collection) {
            return $this->getWSUtilityDao()->format($result, $format);
        } else {
            if ($format == WSHelper::FORMAT_JSON) {
                return json_encode($result);
            } else {
                // TODO: Implement other formatters
            }
        }
    }

}
