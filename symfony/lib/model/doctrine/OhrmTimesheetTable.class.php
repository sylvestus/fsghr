<?php

/**
 * OhrmTimesheetTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OhrmTimesheetTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object OhrmTimesheetTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('OhrmTimesheet');
    }
    
    public static function getAllTimesheets($start="",$end=""){
        $timesheets=  self::getInstance()->findAll();
        return $timesheets;
    }
    
}