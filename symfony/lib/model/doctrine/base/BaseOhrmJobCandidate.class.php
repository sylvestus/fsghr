<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('OhrmJobCandidate', 'doctrine');

/**
 * BaseOhrmJobCandidate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $contact_number
 * @property integer $status
 * @property string $comment
 * @property integer $mode_of_application
 * @property date $date_of_application
 * @property integer $cv_file_id
 * @property string $cv_text_version
 * @property string $keywords
 * @property integer $added_person
 * @property HsHrEmployee $HsHrEmployee
 * @property Doctrine_Collection $OhrmJobCandidateAttachment
 * @property Doctrine_Collection $OhrmJobCandidateHistory
 * @property Doctrine_Collection $OhrmJobCandidateVacancy
 * @property Doctrine_Collection $OhrmJobInterview
 * 
 * @method integer             getId()                         Returns the current record's "id" value
 * @method string              getFirstName()                  Returns the current record's "first_name" value
 * @method string              getMiddleName()                 Returns the current record's "middle_name" value
 * @method string              getLastName()                   Returns the current record's "last_name" value
 * @method string              getEmail()                      Returns the current record's "email" value
 * @method string              getContactNumber()              Returns the current record's "contact_number" value
 * @method integer             getStatus()                     Returns the current record's "status" value
 * @method string              getComment()                    Returns the current record's "comment" value
 * @method integer             getModeOfApplication()          Returns the current record's "mode_of_application" value
 * @method date                getDateOfApplication()          Returns the current record's "date_of_application" value
 * @method integer             getCvFileId()                   Returns the current record's "cv_file_id" value
 * @method string              getCvTextVersion()              Returns the current record's "cv_text_version" value
 * @method string              getKeywords()                   Returns the current record's "keywords" value
 * @method integer             getAddedPerson()                Returns the current record's "added_person" value
 * @method HsHrEmployee        getHsHrEmployee()               Returns the current record's "HsHrEmployee" value
 * @method Doctrine_Collection getOhrmJobCandidateAttachment() Returns the current record's "OhrmJobCandidateAttachment" collection
 * @method Doctrine_Collection getOhrmJobCandidateHistory()    Returns the current record's "OhrmJobCandidateHistory" collection
 * @method Doctrine_Collection getOhrmJobCandidateVacancy()    Returns the current record's "OhrmJobCandidateVacancy" collection
 * @method Doctrine_Collection getOhrmJobInterview()           Returns the current record's "OhrmJobInterview" collection
 * @method OhrmJobCandidate    setId()                         Sets the current record's "id" value
 * @method OhrmJobCandidate    setFirstName()                  Sets the current record's "first_name" value
 * @method OhrmJobCandidate    setMiddleName()                 Sets the current record's "middle_name" value
 * @method OhrmJobCandidate    setLastName()                   Sets the current record's "last_name" value
 * @method OhrmJobCandidate    setEmail()                      Sets the current record's "email" value
 * @method OhrmJobCandidate    setContactNumber()              Sets the current record's "contact_number" value
 * @method OhrmJobCandidate    setStatus()                     Sets the current record's "status" value
 * @method OhrmJobCandidate    setComment()                    Sets the current record's "comment" value
 * @method OhrmJobCandidate    setModeOfApplication()          Sets the current record's "mode_of_application" value
 * @method OhrmJobCandidate    setDateOfApplication()          Sets the current record's "date_of_application" value
 * @method OhrmJobCandidate    setCvFileId()                   Sets the current record's "cv_file_id" value
 * @method OhrmJobCandidate    setCvTextVersion()              Sets the current record's "cv_text_version" value
 * @method OhrmJobCandidate    setKeywords()                   Sets the current record's "keywords" value
 * @method OhrmJobCandidate    setAddedPerson()                Sets the current record's "added_person" value
 * @method OhrmJobCandidate    setHsHrEmployee()               Sets the current record's "HsHrEmployee" value
 * @method OhrmJobCandidate    setOhrmJobCandidateAttachment() Sets the current record's "OhrmJobCandidateAttachment" collection
 * @method OhrmJobCandidate    setOhrmJobCandidateHistory()    Sets the current record's "OhrmJobCandidateHistory" collection
 * @method OhrmJobCandidate    setOhrmJobCandidateVacancy()    Sets the current record's "OhrmJobCandidateVacancy" collection
 * @method OhrmJobCandidate    setOhrmJobInterview()           Sets the current record's "OhrmJobInterview" collection
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOhrmJobCandidate extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_job_candidate');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('first_name', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('middle_name', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('last_name', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('contact_number', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('comment', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('mode_of_application', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('date_of_application', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('cv_file_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('cv_text_version', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('keywords', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('added_person', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('HsHrEmployee', array(
             'local' => 'added_person',
             'foreign' => 'emp_number'));

        $this->hasMany('OhrmJobCandidateAttachment', array(
             'local' => 'id',
             'foreign' => 'candidate_id'));

        $this->hasMany('OhrmJobCandidateHistory', array(
             'local' => 'id',
             'foreign' => 'candidate_id'));

        $this->hasMany('OhrmJobCandidateVacancy', array(
             'local' => 'id',
             'foreign' => 'candidate_id'));

        $this->hasMany('OhrmJobInterview', array(
             'local' => 'id',
             'foreign' => 'candidate_id'));
    }
}