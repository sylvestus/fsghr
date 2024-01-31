<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('StaffPayment', 'doctrine');

/**
 * BaseStaffPayment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $txn_id
 * @property integer $staff_id
 * @property decimal $amount
 * @property string $currency
 * @property string $note
 * @property timestamp $created
 * 
 * @method integer      getId()       Returns the current record's "id" value
 * @method string       getTxnId()    Returns the current record's "txn_id" value
 * @method integer      getStaffId()  Returns the current record's "staff_id" value
 * @method decimal      getAmount()   Returns the current record's "amount" value
 * @method string       getCurrency() Returns the current record's "currency" value
 * @method string       getNote()     Returns the current record's "note" value
 * @method timestamp    getCreated()  Returns the current record's "created" value
 * @method StaffPayment setId()       Sets the current record's "id" value
 * @method StaffPayment setTxnId()    Sets the current record's "txn_id" value
 * @method StaffPayment setStaffId()  Sets the current record's "staff_id" value
 * @method StaffPayment setAmount()   Sets the current record's "amount" value
 * @method StaffPayment setCurrency() Sets the current record's "currency" value
 * @method StaffPayment setNote()     Sets the current record's "note" value
 * @method StaffPayment setCreated()  Sets the current record's "created" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStaffPayment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('staff_payment');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('txn_id', 'string', 60, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 60,
             ));
        $this->hasColumn('staff_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('amount', 'decimal', 13, array(
             'type' => 'decimal',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 13,
             'scale' => '2',
             ));
        $this->hasColumn('currency', 'string', 6, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 6,
             ));
        $this->hasColumn('note', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('created', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0000-00-00 00:00:00',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}