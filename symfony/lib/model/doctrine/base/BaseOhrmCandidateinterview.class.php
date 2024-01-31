<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('OhrmCandidateinterview', 'doctrine');

/**
 * BaseOhrmCandidateinterview
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $question_id
 * @property integer $response_weight
 * @property string $remark
 * @property integer $interview_id
 * 
 * @method integer                getId()              Returns the current record's "id" value
 * @method integer                getQuestionId()      Returns the current record's "question_id" value
 * @method integer                getResponseWeight()  Returns the current record's "response_weight" value
 * @method string                 getRemark()          Returns the current record's "remark" value
 * @method integer                getInterviewId()     Returns the current record's "interview_id" value
 * @method OhrmCandidateinterview setId()              Sets the current record's "id" value
 * @method OhrmCandidateinterview setQuestionId()      Sets the current record's "question_id" value
 * @method OhrmCandidateinterview setResponseWeight()  Sets the current record's "response_weight" value
 * @method OhrmCandidateinterview setRemark()          Sets the current record's "remark" value
 * @method OhrmCandidateinterview setInterviewId()     Sets the current record's "interview_id" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOhrmCandidateinterview extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_candidateinterview');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('question_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('response_weight', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('remark', 'string', 500, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 500,
             ));
        $this->hasColumn('interview_id', 'integer', 4, array(
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