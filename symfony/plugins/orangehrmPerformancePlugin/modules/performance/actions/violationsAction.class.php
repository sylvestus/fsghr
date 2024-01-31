<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2010 OrangeHRM Inc., http://www.orangehrm.com
 *
 * Please refer the file license/LICENSE.TXT for the license which includes terms and conditions on using this software.
 *
 * */
class violationsAction extends basePeformanceAction {

    public $performanceReviewService;
    private $pageNumber;

    public function getPageNumber() {
        return $this->pageNumber;
    }

    public function setPageNumber($pageNumber) {
        $this->pageNumber = $pageNumber;
    }

    /**
     *
     * @return \PerformanceReviewService 
     */
    public function getPerformanceReviewService() {
        if ($this->performanceReviewService == null) {
            return new PerformanceReviewService();
        } else {
            return $this->performanceReviewService;
        }
    }

    /**
     *
     * @param \PerformanceReviewService $performanceReviewService 
     */
    public function setPerformanceReviewService($performanceReviewService) {
        $this->performanceReviewService = $performanceReviewService;
    }

 public function execute($request){
   $this->pager = new sfDoctrinePager(OhrmViolationTypeTable::getInstance(), sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('OhrmViolationType')->createQuery('a')->where('a.id > ?',0)->orderBy('a.violation_type DESC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  
     $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $this->organisationinfo=$organizationinfo;
    }

    /**
     *
     * @param Doctrine_Collection $reviews 
     */
    protected function setListComponent($reviews, $reviewsCount) {
        $pageNumber = $this->getPageNumber();
        $configurationFactory = $this->getListConfigurationFactory();

        ohrmListComponent::setActivePlugin('orangehrmPerformancePlugin');
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($reviews);
        ohrmListComponent::setPageNumber($pageNumber);
        $numRecords = $reviewsCount;
        ohrmListComponent::setItemsPerPage(sfConfig::get('app_items_per_page'));
        ohrmListComponent::setNumberOfRecords($numRecords);
    }

    /**
     *
     * @return \SearchReviewListConfigurationFactory 
     */
    protected function getListConfigurationFactory() {
        return new MyPerformanceReviewListConfigurationFactory();
    }

    public function getReviewsCount($statusArray) {
        $serachParams ['employeeNumber'] = $this->getUser()->getEmployeeNumber();
        $serachParams ['status'] = $statusArray;
        $serachParams ['reviewerId'] = $this->getUser()->getEmployeeNumber();
        $serachParams['limit'] = null;
        return $this->getPerformanceReviewService()->getCountReviewList($serachParams);
    }

}
