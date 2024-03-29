<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Groups', 'doctrine');

/**
 * BaseGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $grp_id
 * @property integer $project_id
 * @property string $grp_name
 * @property enum $is_meeting
 * @property enum $one_member
 * 
 * @method integer getGrpId()      Returns the current record's "grp_id" value
 * @method integer getProjectId()  Returns the current record's "project_id" value
 * @method string  getGrpName()    Returns the current record's "grp_name" value
 * @method enum    getIsMeeting()  Returns the current record's "is_meeting" value
 * @method enum    getOneMember()  Returns the current record's "one_member" value
 * @method Groups  setGrpId()      Sets the current record's "grp_id" value
 * @method Groups  setProjectId()  Sets the current record's "project_id" value
 * @method Groups  setGrpName()    Sets the current record's "grp_name" value
 * @method Groups  setIsMeeting()  Sets the current record's "is_meeting" value
 * @method Groups  setOneMember()  Sets the current record's "one_member" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroups extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('groups');
        $this->hasColumn('grp_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('project_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('grp_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('is_meeting', 'enum', 1, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Y',
              1 => 'N',
             ),
             'primary' => false,
             'default' => 'Y',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('one_member', 'enum', 1, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Y',
              1 => 'N',
             ),
             'primary' => false,
             'default' => 'N',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}