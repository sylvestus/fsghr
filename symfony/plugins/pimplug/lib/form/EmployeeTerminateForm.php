<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeTerminateForm
 *
 * @author orangehrm
 */
class EmployeeTerminateForm extends BaseForm {

    private $employeeService;
    private $terminationReasonConfigurationService;
    
    private $allowActivate;
    private $allowTerminate;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }
    
    public function getTerminationReasonConfigurationService() {

        if (is_null($this->terminationReasonConfigurationService)) {
            $this->terminationReasonConfigurationService = new TerminationReasonConfigurationService();
        }
        
        return $this->terminationReasonConfigurationService;
        
    }

    public function setTerminationReasonConfigurationService(TerminationReasonConfigurationService $terminationReasonConfigurationService) {
        $this->terminationReasonConfigurationService = $terminationReasonConfigurationService;
    }    

    public function configure() {

        $employee = $this->getOption('employee');

        $this->allowActivate = $this->getOption('allowActivate');
        $this->allowTerminate = $this->getOption('allowTerminate');
        
        $empTerminatedId = $employee->termination_id;

        $terminateReasons = $this->__getTerminationReasons();

        //creating widgets
        $widgets = array(
            'date' => new ohrmWidgetDatePicker(array(), array('id' => 'terminate_date')),
            'payment_date' => new ohrmWidgetDatePicker(array(), array('id' => 'payment_date','value'=>date('Y-m-d'))),
            'reason' => new sfWidgetFormSelect(array('choices' => $terminateReasons)),
            'note' => new sfWidgetFormTextArea(),
            'pending_leave'=>new sfWidgetFormInput(),
            'pending_leave_amount'=>new sfWidgetFormInput(),
            'one_month_pay'=>new sfWidgetFormInput(),
             'service_benefits'=>new sfWidgetFormInput(),
            'service_benefits'=>new sfWidgetFormInput(),
            'service_benefits_amount'=>new sfWidgetFormInput(),
            'notifice_payment'=>new sfWidgetFormInput(),
            'salary_advance'=>new sfWidgetFormInput(),
            'company_loan'=>new sfWidgetFormInput(),
            'overtime_for_months'=>new sfWidgetFormInput(),
            'overtime_amount'=>new sfWidgetFormInput(),
               'fileApprove'=>new sfWidgetFormInputFile(array('label'=> __('Approval File'))),
        );

        if ((!$this->allowTerminate) && (!$this->allowActivate)) {
            foreach ($widgets as $widget) {
                $widget->setAttribute('disabled', 'disabled');
            }
        }
        
        $this->setWidgets($widgets);
        
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();

        //Setting validators
        $this->setValidators(array(
            'date' => new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => true),
                    array('invalid' => 'Date format should be ' . $inputDatePattern)),
            'payment_date' => new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => true),
                    array('invalid' => 'Date format should be ' . $inputDatePattern)),
            'pending_leave'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'pending_leave_amount'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'one_month_pay'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
             'service_benefits'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'service_benefits'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'service_benefits_amount'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'notifice_payment'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'salary_advance'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'company_loan'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'overtime_for_months'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'overtime_amount'=>new sfValidatorString(array('required' => false, 'max_length' => 20, 'trim' => true)),
            'reason' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys($terminateReasons))),
            'note' => new sfValidatorString(array('required' => false, 'max_length' => 250, 'trim' => true)),
             'fileApprove' => new sfValidatorFile(array('required' =>true))
        ));

        $this->setDefault('date', set_datepicker_date_format(date('Y-m-d')));
        $this->setDefault('reason', 1);

        if (!empty($empTerminatedId)){
            $employeeTerminationRecord = $employee->getEmployeeTerminationRecord();
            $this->setDefault('date', set_datepicker_date_format($employeeTerminationRecord->getTerminationDate()));
            $this->setDefault('reason', $employeeTerminationRecord->getReasonId());
            $this->setDefault('note', $employeeTerminationRecord->getNote());
                  $this->setDefault('payment_date', $employeeTerminationRecord->getPaymentUpto());
        }
        
        $this->widgetSchema->setNameFormat('terminate[%s]');
    }

    public function terminateEmployement($empNumber, $terminatedId) {
        $date = $this->getValue('date');
        $reasonId = $this->getValue('reason');
        $note = $this->getValue('note');
        $overtime_for_months=$this->getValue('overtime_for_months');
          $overtime_amount=$this->getValue('overtime_amount');
           
              $pending_leave=$this->getValue('pending_leave');
                $pending_leave_amount=$this->getValue('pending_leave_amount');
                  $one_month_pay=(int)$this->getValue('one_month_pay');
                    $service_benefit_years=$this->getValue('service_benefit_years');
                      $service_benefit_amount=$this->getValue('service_benefit_amount');
                      $notifice_payment=$this->getValue('notifice_payment');
                       $salary_advance=$this->getValue('salary_advance');
                        $company_loan=$this->getValue('company_loan');
                        
                      
        if(!empty($terminatedId)){
            $employeeTerminationRecord = $this->getEmployeeService()->getEmployeeTerminationRecord($terminatedId);
        }else{
            $employeeTerminationRecord = new EmployeeTerminationRecord();
        }
        $employeeTerminationRecord->setTerminationDate($date);
        $employeeTerminationRecord->setReasonId($reasonId);
        $employeeTerminationRecord->setEmpNumber($empNumber);
        $employeeTerminationRecord->setNote($note);
        $employeeTerminationRecord->setOvertimeForMonths($overtime_for_months);
        $employeeTerminationRecord->setPaymentUpto($this->getValue('payment_date'));
        $employeeTerminationRecord->setOvertimeAmount($overtime_amount);
        $employeeTerminationRecord->setPendingLeave($pending_leave);
        $employeeTerminationRecord->setPendingLeaveAmount($pending_leave_amount);
        $employeeTerminationRecord->setOneMonthPay($one_month_pay);
        $employeeTerminationRecord->setServiceBenefitYears($service_benefit_years);
        $employeeTerminationRecord->setServiceBenefitAmount($service_benefit_amount);
        $employeeTerminationRecord->setNotificePayment($notifice_payment);
        $employeeTerminationRecord->setSalaryAdvance($salary_advance);
        $employeeTerminationRecord->setCompanyLoan($company_loan);

        $this->getEmployeeService()->terminateEmployment($employeeTerminationRecord);
        return $employeeTerminationRecord;
        
    }

    public function __getTerminationReasons() {
        $list = array();
        $terminateReasons = $this->getTerminationReasonConfigurationService()->getTerminationReasonList();
        foreach ($terminateReasons as $terminateReason) {
            $list[$terminateReason->getId()] = $terminateReason->getName();
        }
        return $list;
    }

}
