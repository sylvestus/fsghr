<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Agenda', 'doctrine');

/**
 * BaseAgenda
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $agn_id
 * @property string $agn_no
 * @property string $agn_title
 * @property string $agn_desc
 * @property integer $mtn_id
 * 
 * @method integer getAgnId()     Returns the current record's "agn_id" value
 * @method string  getAgnNo()     Returns the current record's "agn_no" value
 * @method string  getAgnTitle()  Returns the current record's "agn_title" value
 * @method string  getAgnDesc()   Returns the current record's "agn_desc" value
 * @method integer getMtnId()     Returns the current record's "mtn_id" value
 * @method Agenda  setAgnId()     Sets the current record's "agn_id" value
 * @method Agenda  setAgnNo()     Sets the current record's "agn_no" value
 * @method Agenda  setAgnTitle()  Sets the current record's "agn_title" value
 * @method Agenda  setAgnDesc()   Sets the current record's "agn_desc" value
 * @method Agenda  setMtnId()     Sets the current record's "mtn_id" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAgenda extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('agenda');
        $this->hasColumn('agn_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('agn_no', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('agn_title', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('agn_desc', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('mtn_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}