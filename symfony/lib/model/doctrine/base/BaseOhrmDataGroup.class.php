<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('OhrmDataGroup', 'doctrine');

/**
 * BaseOhrmDataGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $can_read
 * @property integer $can_create
 * @property integer $can_update
 * @property integer $can_delete
 * @property Doctrine_Collection $OhrmDataGroupScreen
 * @property Doctrine_Collection $OhrmUserRoleDataGroup
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method string              getName()                  Returns the current record's "name" value
 * @method string              getDescription()           Returns the current record's "description" value
 * @method integer             getCanRead()               Returns the current record's "can_read" value
 * @method integer             getCanCreate()             Returns the current record's "can_create" value
 * @method integer             getCanUpdate()             Returns the current record's "can_update" value
 * @method integer             getCanDelete()             Returns the current record's "can_delete" value
 * @method Doctrine_Collection getOhrmDataGroupScreen()   Returns the current record's "OhrmDataGroupScreen" collection
 * @method Doctrine_Collection getOhrmUserRoleDataGroup() Returns the current record's "OhrmUserRoleDataGroup" collection
 * @method OhrmDataGroup       setId()                    Sets the current record's "id" value
 * @method OhrmDataGroup       setName()                  Sets the current record's "name" value
 * @method OhrmDataGroup       setDescription()           Sets the current record's "description" value
 * @method OhrmDataGroup       setCanRead()               Sets the current record's "can_read" value
 * @method OhrmDataGroup       setCanCreate()             Sets the current record's "can_create" value
 * @method OhrmDataGroup       setCanUpdate()             Sets the current record's "can_update" value
 * @method OhrmDataGroup       setCanDelete()             Sets the current record's "can_delete" value
 * @method OhrmDataGroup       setOhrmDataGroupScreen()   Sets the current record's "OhrmDataGroupScreen" collection
 * @method OhrmDataGroup       setOhrmUserRoleDataGroup() Sets the current record's "OhrmUserRoleDataGroup" collection
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOhrmDataGroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_data_group');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('can_read', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('can_create', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('can_update', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('can_delete', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('OhrmDataGroupScreen', array(
             'local' => 'id',
             'foreign' => 'data_group_id'));

        $this->hasMany('OhrmUserRoleDataGroup', array(
             'local' => 'id',
             'foreign' => 'data_group_id'));
    }
}