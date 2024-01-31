<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Payment', 'doctrine');

/**
 * BasePayment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $amount
 * @property string $description
 * @property string $date
 * @property string $payment
 * @property string $files
 * @property integer $user_id
 * @property timestamp $time
 * 
 * @method integer   getId()          Returns the current record's "id" value
 * @method integer   getAmount()      Returns the current record's "amount" value
 * @method string    getDescription() Returns the current record's "description" value
 * @method string    getDate()        Returns the current record's "date" value
 * @method string    getPayment()     Returns the current record's "payment" value
 * @method string    getFiles()       Returns the current record's "files" value
 * @method integer   getUserId()      Returns the current record's "user_id" value
 * @method timestamp getTime()        Returns the current record's "time" value
 * @method Payment   setId()          Sets the current record's "id" value
 * @method Payment   setAmount()      Sets the current record's "amount" value
 * @method Payment   setDescription() Sets the current record's "description" value
 * @method Payment   setDate()        Sets the current record's "date" value
 * @method Payment   setPayment()     Sets the current record's "payment" value
 * @method Payment   setFiles()       Sets the current record's "files" value
 * @method Payment   setUserId()      Sets the current record's "user_id" value
 * @method Payment   setTime()        Sets the current record's "time" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePayment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('payment');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('amount', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('date', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('payment', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('files', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('time', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}