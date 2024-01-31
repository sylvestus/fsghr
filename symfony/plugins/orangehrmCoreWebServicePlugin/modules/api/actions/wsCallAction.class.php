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

class wsCallAction extends sfAction {
    
    private $logger = null;  
  
    protected function getWebServiceLogger() {  
        if (is_null($this->logger)) {  
            $this->logger = Logger::getLogger('core.webservices.log');  
        }  
  
        return($this->logger);  
    }

    public function execute($request) {
        $wsHelper = new WSHelper();
        $wsManager = new WSManager();
        
        $result = '';
        $status = 'INITIAL';
        $contentType = 'text/plain';

        try {
            $paramObj = $wsHelper->extractParamerts($request);
            $isMethodAvailable = $wsManager->isMethodAvailable($paramObj->getMethod());

            if ($isMethodAvailable) {
                $isAuthenticated = $wsManager->isAuthenticated($paramObj);
                $isAuthorized = $wsManager->isAuthorized($paramObj);

                if ($isAuthenticated && $isAuthorized) {
                    try {
                        $result = $wsManager->callMethod($paramObj);
                        $result = $wsHelper->formatResult($result, WSHelper::FORMAT_JSON);
                        $status = 'SUCCESS';
                        $contentType = 'text/json';
                    } catch (Exception $e) {
                        $logger = $this->getWebServiceLogger();
                        $logger->info('Uncaught Exception: ' . $e->getMessage());
                        $result = 'INTERNAL ERROR';
                        $status = 'ERROR';
                    }
                } else {
                    $result = 'NOT ALLOWED';
                    $status = 'ERROR';
                }
            } else {
                $result = 'INVALID REQUEST';
                $status = 'ERROR';
            }
        } catch (WebServiceException $e) {
            $result = $e->getCode() . ': ' . $e->getMessage();
            $status = 'ERROR'; 
        }

        $this->getResponse()->setContent($result);
        $this->getResponse()->setHttpHeader('Content-type', $contentType);
        $this->getResponse()->setHttpHeader('ohrm_ws_call_status', $status);

        return sfView::NONE;
    }

}
