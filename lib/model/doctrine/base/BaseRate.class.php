<?php

/**
 * BaseRate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string   $object_type               Type: string(50)
 * @property int      $object_id                 Type: integer
 * @property int      $rate                      Type: integer
 * @property int      $citoyen_id                Type: integer
 * @property Citoyen  $Citoyen                   
 *  
 * @method string     getObjectType()            Type: string(50)
 * @method int        getObjectId()              Type: integer
 * @method int        getRate()                  Type: integer
 * @method int        getCitoyenId()             Type: integer
 * @method Citoyen    getCitoyen()               
 *  
 * @method Rate       setObjectType(string $val) Type: string(50)
 * @method Rate       setObjectId(int $val)      Type: integer
 * @method Rate       setRate(int $val)          Type: integer
 * @method Rate       setCitoyenId(int $val)     Type: integer
 * @method Rate       setCitoyen(Citoyen $val)   
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRate extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('rate');
        $this->hasColumn('object_type', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('object_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('rate', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('citoyen_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('unique', array(
             'fields' => 
             array(
              0 => 'object_type',
              1 => 'object_id',
              2 => 'citoyen_id',
             ),
             'type' => 'unique',
             ));
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Citoyen', array(
             'local' => 'citoyen_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}