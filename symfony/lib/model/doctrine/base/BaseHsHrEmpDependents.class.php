<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('HsHrEmpDependents', 'doctrine');

/**
 * BaseHsHrEmpDependents
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property decimal $ed_seqno
 * @property string $ed_name
 * @property enum $ed_relationship_type
 * @property string $ed_relationship
 * @property date $ed_date_of_birth
 * @property HsHrEmployee $HsHrEmployee
 * 
 * @method integer           getEmpNumber()            Returns the current record's "emp_number" value
 * @method decimal           getEdSeqno()              Returns the current record's "ed_seqno" value
 * @method string            getEdName()               Returns the current record's "ed_name" value
 * @method enum              getEdRelationshipType()   Returns the current record's "ed_relationship_type" value
 * @method string            getEdRelationship()       Returns the current record's "ed_relationship" value
 * @method date              getEdDateOfBirth()        Returns the current record's "ed_date_of_birth" value
 * @method HsHrEmployee      getHsHrEmployee()         Returns the current record's "HsHrEmployee" value
 * @method HsHrEmpDependents setEmpNumber()            Sets the current record's "emp_number" value
 * @method HsHrEmpDependents setEdSeqno()              Sets the current record's "ed_seqno" value
 * @method HsHrEmpDependents setEdName()               Sets the current record's "ed_name" value
 * @method HsHrEmpDependents setEdRelationshipType()   Sets the current record's "ed_relationship_type" value
 * @method HsHrEmpDependents setEdRelationship()       Sets the current record's "ed_relationship" value
 * @method HsHrEmpDependents setEdDateOfBirth()        Sets the current record's "ed_date_of_birth" value
 * @method HsHrEmpDependents setHsHrEmployee()         Sets the current record's "HsHrEmployee" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHsHrEmpDependents extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_dependents');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ed_seqno', 'decimal', 2, array(
             'type' => 'decimal',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 2,
             ));
        $this->hasColumn('ed_name', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('ed_relationship_type', 'enum', 5, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'child',
              1 => 'other',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 5,
             ));
        $this->hasColumn('ed_relationship', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('ed_date_of_birth', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('HsHrEmployee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));
    }
}