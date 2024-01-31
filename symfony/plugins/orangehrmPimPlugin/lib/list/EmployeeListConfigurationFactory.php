<?php

class EmployeeListConfigurationFactory extends ohrmListConfigurationFactory {
    
    const LINK_NONE = 0;
    const LINK_ALL_EMPLOYEES = 1;    
    const LINK_ACTIVE_EMPLOYEES = 2;
    const LINK_DELETED_EMPLOYEES = 3;
    
    protected static $linkSetting = self::LINK_NONE;
    
    public function init() {
        sfContext::getInstance()->getConfiguration()->loadHelpers('OrangeDate');
        
        $header1 = new ListHeader();
        $header2 = new ListHeader();
        $header3 = new ListHeader();
        $header4 = new ListHeader();
        $header5 = new ListHeader();
        $header6 = new ListHeader();
        $header7 = new ListHeader();
          $header8 = new ListHeader();
           $header9 = new ListHeader();
        $header10 = new ListHeader();

        $header1->populateFromArray(array(
            'name' => 'Id',
            'width' => '5%',
            'isSortable' => true,
            'sortField' => 'employeeId',
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getEmployeeId'),
                'placeholderGetters' => array('id' => 'getEmpNumber'),
                'linkable' => $this->getLinkable(),
                'urlPattern' => public_path('index.php/pim/viewEmployee/empNumber/{id}'),
            ),
        ));

        $header2->populateFromArray(array(
            'name' => __('First (& Middle) Name'),
            'width' => '13%',
            'isSortable' => true,
            'sortField' => 'firstMiddleName',
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getFirstAndMiddleName'),
                'placeholderGetters' => array('id' => 'getEmpNumber'),
                'linkable' => $this->getLinkable(),
                'urlPattern' => public_path('index.php/pim/viewEmployee/empNumber/{id}'),
            ),
        ));

        $header3->populateFromArray(array(
            'name' => 'Last Name',
            'width' => '10%',
            'isSortable' => true,
            'sortField' => 'lastName',
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getFullLastName'),
                'placeholderGetters' => array('id' => 'getEmpNumber'),
                'linkable' => $this->getLinkable(),
                'urlPattern' => public_path('index.php/pim/viewEmployee/empNumber/{id}'),
            ),
        ));

        $header4->populateFromArray(array(
            'name' => 'Job Title',
            'width' => '20%',
            'isSortable' => true,
            'sortField' => 'jobTitle',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getJobTitleName')
        ));

        $header5->populateFromArray(array(
            'name' => 'Employment Status',
            'width' => '15%',
            'isSortable' => true,
            'sortField' => 'employeeStatus',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getEmployeeStatus')
        ));

        $header6->populateFromArray(array(
            'name' => 'Sub Unit',
            'width' => '15%',
            'isSortable' => true,
            'sortField' => 'subDivision',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getSubDivision')
        ));

        $header7->populateFromArray(array(
            'name' => 'Supervisor',
            'width' => '15%',
            'isSortable' => true,
            'sortField' => 'supervisor',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getSupervisorNames')
        ));
        
         $header8->populateFromArray(array(
            'name' => 'Joined Date',
            'width' => '15%',
            'isSortable' => true,
            'sortField' => 'joined_date',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getJoinedDate')
        ));
         $header9->populateFromArray(array(
            'name' => 'History',
            'width' => '10%',
            'isSortable' => true,
            'sortField' => 'employeeId',
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getFirstAndMiddleName'),
                'placeholderGetters' => array('id' => 'getEmpNumber'),
                'linkable' => $this->getLinkable(),
                'urlPattern' => public_path('index.php/pim/employeeHistory/empNumber/{id}'),
            ),
        ));
         
        $header10->populateFromArray(array(
            'name' => 'Terminated Date',
            'width' => '10%',
            'isSortable' => true,
            'sortField' => 'termination_id',
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getTerminationDate')
        ));
        $this->headers = array($header1, $header2, $header3, $header4, $header5, $header6, $header7,$header8,$header9,$header10);
    }
    
    public function getClassName() {
        return 'Employee';
    }
    
    public static function getLinkSetting() {
        return self::$linkSetting;
    }
    
    public static function setLinkSetting($setting) {
        self::$linkSetting = $setting;
    }
    
    public function getLinkable() {
        $linkable = false;
        
        if (self::$linkSetting == self::LINK_ALL_EMPLOYEES) {
            $linkable = true;            
        }
        
        return $linkable;
    }
}
