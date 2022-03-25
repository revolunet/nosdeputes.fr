<?php

/**
 * BaseTitreLoi
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string                            $texteloi_id                              Type: string(16)
 * @property string                            $leveltype                                Type: string(16)
 * @property string                            $level1                                   Type: string(8)
 * @property string                            $level2                                   Type: string(8)
 * @property string                            $level3                                   Type: string(8)
 * @property string                            $level4                                   Type: string(8)
 * @property string                            $titre                                    Type: string(512)
 * @property string                            $expose                                   Type: string
 * @property int                               $parlementaire_id                         Type: integer
 * @property string                            $date                                     Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @property string                            $source                                   Type: string(128), unique
 * @property int                               $nb_articles                              Type: integer
 * @property int                               $titre_loi_id                             Type: integer
 * @property Parlementaire                     $Parlementaire                            
 * @property TitreLoi                          $TitreLoi                                 
 * @property Texteloi                          $Texteloi                                 
 * @property Doctrine_Collection|ArticleLoi[]  $Articles                                 
 * @property Doctrine_Collection|TitreLoi[]    $SousSections                             
 *  
 * @method string                              getTexteloiId()                           Type: string(16)
 * @method string                              getLeveltype()                            Type: string(16)
 * @method string                              getLevel1()                               Type: string(8)
 * @method string                              getLevel2()                               Type: string(8)
 * @method string                              getLevel3()                               Type: string(8)
 * @method string                              getLevel4()                               Type: string(8)
 * @method string                              getTitre()                                Type: string(512)
 * @method string                              getExpose()                               Type: string
 * @method int                                 getParlementaireId()                      Type: integer
 * @method string                              getDate()                                 Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @method string                              getSource()                               Type: string(128), unique
 * @method int                                 getNbArticles()                           Type: integer
 * @method int                                 getTitreLoiId()                           Type: integer
 * @method Parlementaire                       getParlementaire()                        
 * @method TitreLoi                            getTitreLoi()                             
 * @method Texteloi                            getTexteloi()                             
 * @method Doctrine_Collection|ArticleLoi[]    getArticles()                             
 * @method Doctrine_Collection|TitreLoi[]      getSousSections()                         
 *  
 * @method TitreLoi                            setTexteloiId(string $val)                Type: string(16)
 * @method TitreLoi                            setLeveltype(string $val)                 Type: string(16)
 * @method TitreLoi                            setLevel1(string $val)                    Type: string(8)
 * @method TitreLoi                            setLevel2(string $val)                    Type: string(8)
 * @method TitreLoi                            setLevel3(string $val)                    Type: string(8)
 * @method TitreLoi                            setLevel4(string $val)                    Type: string(8)
 * @method TitreLoi                            setTitre(string $val)                     Type: string(512)
 * @method TitreLoi                            setExpose(string $val)                    Type: string
 * @method TitreLoi                            setParlementaireId(int $val)              Type: integer
 * @method TitreLoi                            setDate(string $val)                      Type: date, Date in ISO-8601 format (YYYY-MM-DD)
 * @method TitreLoi                            setSource(string $val)                    Type: string(128), unique
 * @method TitreLoi                            setNbArticles(int $val)                   Type: integer
 * @method TitreLoi                            setTitreLoiId(int $val)                   Type: integer
 * @method TitreLoi                            setParlementaire(Parlementaire $val)      
 * @method TitreLoi                            setTitreLoi(TitreLoi $val)                
 * @method TitreLoi                            setTexteloi(Texteloi $val)                
 * @method TitreLoi                            setArticles(Doctrine_Collection $val)     
 * @method TitreLoi                            setSousSections(Doctrine_Collection $val) 
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTitreLoi extends ObjectCommentable
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('titre_loi');
        $this->hasColumn('texteloi_id', 'string', 16, array(
             'type' => 'string',
             'length' => 16,
             ));
        $this->hasColumn('leveltype', 'string', 16, array(
             'type' => 'string',
             'length' => 16,
             ));
        $this->hasColumn('level1', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('level2', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('level3', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('level4', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('titre', 'string', 512, array(
             'type' => 'string',
             'length' => 512,
             ));
        $this->hasColumn('expose', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('parlementaire_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('source', 'string', 128, array(
             'type' => 'string',
             'unique' => true,
             'length' => 128,
             ));
        $this->hasColumn('nb_articles', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('titre_loi_id', 'integer', null, array(
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

        $this->hasOne('TitreLoi', array(
             'local' => 'titre_loi_id',
             'foreign' => 'id'));

        $this->hasOne('Texteloi', array(
             'local' => 'texteloi_id',
             'foreign' => 'id'));

        $this->hasMany('ArticleLoi as Articles', array(
             'local' => 'id',
             'foreign' => 'titre_loi_id'));

        $this->hasMany('TitreLoi as SousSections', array(
             'local' => 'id',
             'foreign' => 'titre_loi_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}