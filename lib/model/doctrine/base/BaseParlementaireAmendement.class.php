<?php

/**
 * BaseParlementaireAmendement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property int                      $parlementaire_id                           Type: integer
 * @property string                   $parlementaire_groupe_acronyme              Type: string(16)
 * @property string                   $amendement_id                              Type: string(36)
 * @property int                      $numero_signataire                          Type: integer
 * @property Parlementaire            $Parlementaire                              
 * @property Amendement               $Amendement                                 
 *  
 * @method int                        getParlementaireId()                        Type: integer
 * @method string                     getParlementaireGroupeAcronyme()            Type: string(16)
 * @method string                     getAmendementId()                           Type: string(36)
 * @method int                        getNumeroSignataire()                       Type: integer
 * @method Parlementaire              getParlementaire()                          
 * @method Amendement                 getAmendement()                             
 *  
 * @method ParlementaireAmendement    setParlementaireId(int $val)                Type: integer
 * @method ParlementaireAmendement    setParlementaireGroupeAcronyme(string $val) Type: string(16)
 * @method ParlementaireAmendement    setAmendementId(string $val)                Type: string(36)
 * @method ParlementaireAmendement    setNumeroSignataire(int $val)               Type: integer
 * @method ParlementaireAmendement    setParlementaire(Parlementaire $val)        
 * @method ParlementaireAmendement    setAmendement(Amendement $val)              
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseParlementaireAmendement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('parlementaire_amendement');
        $this->hasColumn('parlementaire_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('parlementaire_groupe_acronyme', 'string', 16, array(
             'type' => 'string',
             'length' => 16,
             ));
        $this->hasColumn('amendement_id', 'string', 36, array(
             'type' => 'string',
             'length' => 36,
             ));
        $this->hasColumn('numero_signataire', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Parlementaire', array(
             'local' => 'parlementaire_id',
             'foreign' => 'id'));

        $this->hasOne('Amendement', array(
             'local' => 'amendement_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}