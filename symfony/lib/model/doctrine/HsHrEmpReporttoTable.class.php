<?php

/**
 * HsHrEmpReporttoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HsHrEmpReporttoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object HsHrEmpReporttoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('HsHrEmpReportto');
    }
    
    public static function getEmployeeSupervisor($employeeId) {

        try {

            $q = Doctrine_Query::create()
                               ->from('HsHrEmpReportto')
                               ->where('erep_sub_emp_number = ?', trim($employeeId));
                                  
            $result = $q->fetchOne();
            
            if (!$result) {
                return null;
            }

            return $result;

        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd

    }
}