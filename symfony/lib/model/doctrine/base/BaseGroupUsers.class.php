<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('GroupUsers', 'doctrine');

/**
 * BaseGroupUsers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $gu_id
 * @property integer $grp_id
 * @property integer $id
 * @property integer $hierarchy
 * 
 * @method integer    getGuId()      Returns the current record's "gu_id" value
 * @method integer    getGrpId()     Returns the current record's "grp_id" value
 * @method integer    getId()        Returns the current record's "id" value
 * @method integer    getHierarchy() Returns the current record's "hierarchy" value
 * @method GroupUsers setGuId()      Sets the current record's "gu_id" value
 * @method GroupUsers setGrpId()     Sets the current record's "grp_id" value
 * @method GroupUsers setId()        Sets the current record's "id" value
 * @method GroupUsers setHierarchy() Sets the current record's "hierarchy" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroupUsers extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('group_users');
        $this->hasColumn('gu_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('grp_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('hierarchy', 'integer', 4, array(
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