<?php

/**
 * BaseObjectRated
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property int          $rate             Type: integer
 *  
 * @method int            getRate()         Type: integer
 *  
 * @method ObjectRated    setRate(int $val) Type: integer
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseObjectRated extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('object_rated');
        $this->hasColumn('rate', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}