<?php

/**
 * BaseSeance
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string                              $date                                      Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @property int                                 $numero_semaine                            Type: integer
 * @property int                                 $annee                                     Type: integer
 * @property string                              $type                                      Type: enum, Possible values (COMMISSION, HEMICYCLE)
 * @property string                              $moment                                    Type: string(255)
 * @property int                                 $organisme_id                              Type: integer
 * @property bool                                $tagged                                    Type: boolean
 * @property string                              $session                                   Type: string(10)
 * @property Organisme                           $Organisme                                 
 * @property Doctrine_Collection|Scrutin[]       $Scrutins                                  
 * @property Doctrine_Collection|Presence[]      $Presences                                 
 * @property Doctrine_Collection|Intervention[]  $Interventions                             
 *  
 * @method string                                getDate()                                  Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @method int                                   getNumeroSemaine()                         Type: integer
 * @method int                                   getAnnee()                                 Type: integer
 * @method string                                getType()                                  Type: enum, Possible values (COMMISSION, HEMICYCLE)
 * @method string                                getMoment()                                Type: string(255)
 * @method int                                   getOrganismeId()                           Type: integer
 * @method bool                                  getTagged()                                Type: boolean
 * @method string                                getSession()                               Type: string(10)
 * @method Organisme                             getOrganisme()                             
 * @method Doctrine_Collection|Scrutin[]         getScrutins()                              
 * @method Doctrine_Collection|Presence[]        getPresences()                             
 * @method Doctrine_Collection|Intervention[]    getInterventions()                         
 *  
 * @method Seance                                setDate(string $val)                       Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @method Seance                                setNumeroSemaine(int $val)                 Type: integer
 * @method Seance                                setAnnee(int $val)                         Type: integer
 * @method Seance                                setType(string $val)                       Type: enum, Possible values (COMMISSION, HEMICYCLE)
 * @method Seance                                setMoment(string $val)                     Type: string(255)
 * @method Seance                                setOrganismeId(int $val)                   Type: integer
 * @method Seance                                setTagged(bool $val)                       Type: boolean
 * @method Seance                                setSession(string $val)                    Type: string(10)
 * @method Seance                                setOrganisme(Organisme $val)               
 * @method Seance                                setScrutins(Doctrine_Collection $val)      
 * @method Seance                                setPresences(Doctrine_Collection $val)     
 * @method Seance                                setInterventions(Doctrine_Collection $val) 
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSeance extends ObjectCommentable
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('seance');
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('numero_semaine', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('annee', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'commission',
              1 => 'hemicycle',
             ),
             ));
        $this->hasColumn('moment', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('organisme_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('tagged', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('session', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));


        $this->index('uniq_index', array(
             'fields' => 
             array(
              0 => 'organisme_id',
              1 => 'date',
              2 => 'moment',
             ),
             'type' => 'unique',
             ));
        $this->index('index_session', array(
             'fields' => 
             array(
              0 => 'session',
             ),
             ));
        $this->index('index_semaine', array(
             'fields' => 
             array(
              0 => 'annee',
              1 => 'numero_semaine',
             ),
             ));
        $this->index('index_annee', array(
             'fields' => 
             array(
              0 => 'annee',
             ),
             ));
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Organisme', array(
             'local' => 'organisme_id',
             'foreign' => 'id'));

        $this->hasMany('Scrutin as Scrutins', array(
             'local' => 'id',
             'foreign' => 'seance_id'));

        $this->hasMany('Presence as Presences', array(
             'local' => 'id',
             'foreign' => 'seance_id'));

        $this->hasMany('Intervention as Interventions', array(
             'local' => 'id',
             'foreign' => 'seance_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}