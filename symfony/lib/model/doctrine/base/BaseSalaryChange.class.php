<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('SalaryChange', 'doctrine');

/**
 * BaseSalaryChange
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $employee_id
 * @property string $previous_salary
 * @property string $current_salary
 * @property string $payper
 * @property string $effected
 * @property string $effected_on
 * 
 * @method integer      getId()              Returns the current record's "id" value
 * @method integer      getEmployeeId()      Returns the current record's "employee_id" value
 * @method string       getPreviousSalary()  Returns the current record's "previous_salary" value
 * @method string       getCurrentSalary()   Returns the current record's "current_salary" value
 * @method string       getPayper()          Returns the current record's "payper" value
 * @method string       getEffected()        Returns the current record's "effected" value
 * @method string       getEffectedOn()      Returns the current record's "effected_on" value
 * @method SalaryChange setId()              Sets the current record's "id" value
 * @method SalaryChange setEmployeeId()      Sets the current record's "employee_id" value
 * @method SalaryChange setPreviousSalary()  Sets the current record's "previous_salary" value
 * @method SalaryChange setCurrentSalary()   Sets the current record's "current_salary" value
 * @method SalaryChange setPayper()          Sets the current record's "payper" value
 * @method SalaryChange setEffected()        Sets the current record's "effected" value
 * @method SalaryChange setEffectedOn()      Sets the current record's "effected_on" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSalaryChange extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('salary_change');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('employee_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('previous_salary', 'string', 20, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 20,
             ));
        $this->hasColumn('current_salary', 'string', 20, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 20,
             ));
        $this->hasColumn('payper', 'string', 10, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 10,
             ));
        $this->hasColumn('effected', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'default' => 'N',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('effected_on', 'string', 20, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}