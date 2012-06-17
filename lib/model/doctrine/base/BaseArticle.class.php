<?php

/**
 * BaseArticle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string                         $titre                                    Type: string(254)
 * @property string                         $corps                                    Type: string
 * @property string                         $user_corps                               Type: string
 * @property string                         $categorie                                Type: string(128)
 * @property int                            $citoyen_id                               Type: integer
 * @property int                            $article_id                               Type: integer
 * @property string                         $link                                     Type: string(255)
 * @property string                         $status                                   Type: enum, default "brouillon", Possible values (PUBLIC, BROUILLON, OFFLINE)
 * @property int                            $object_id                                Type: integer
 * @property Citoyen                        $Citoyen                                  
 * @property Article                        $Article                                  
 * @property Doctrine_Collection|Article[]  $SousArticles                             
 *  
 * @method string                           getTitre()                                Type: string(254)
 * @method string                           getCorps()                                Type: string
 * @method string                           getUserCorps()                            Type: string
 * @method string                           getCategorie()                            Type: string(128)
 * @method int                              getCitoyenId()                            Type: integer
 * @method int                              getArticleId()                            Type: integer
 * @method string                           getLink()                                 Type: string(255)
 * @method string                           getStatus()                               Type: enum, default "brouillon", Possible values (PUBLIC, BROUILLON, OFFLINE)
 * @method int                              getObjectId()                             Type: integer
 * @method Citoyen                          getCitoyen()                              
 * @method Article                          getArticle()                              
 * @method Doctrine_Collection|Article[]    getSousArticles()                         
 *  
 * @method Article                          setTitre(string $val)                     Type: string(254)
 * @method Article                          setCorps(string $val)                     Type: string
 * @method Article                          setUserCorps(string $val)                 Type: string
 * @method Article                          setCategorie(string $val)                 Type: string(128)
 * @method Article                          setCitoyenId(int $val)                    Type: integer
 * @method Article                          setArticleId(int $val)                    Type: integer
 * @method Article                          setLink(string $val)                      Type: string(255)
 * @method Article                          setStatus(string $val)                    Type: enum, default "brouillon", Possible values (PUBLIC, BROUILLON, OFFLINE)
 * @method Article                          setObjectId(int $val)                     Type: integer
 * @method Article                          setCitoyen(Citoyen $val)                  
 * @method Article                          setArticle(Article $val)                  
 * @method Article                          setSousArticles(Doctrine_Collection $val) 
 *  
 * @package    cpc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArticle extends ObjectCommentable
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('article');
        $this->hasColumn('titre', 'string', 254, array(
             'type' => 'string',
             'length' => 254,
             ));
        $this->hasColumn('corps', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('user_corps', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('categorie', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('citoyen_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('article_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('link', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'public',
              1 => 'brouillon',
              2 => 'offline',
             ),
             'default' => 'brouillon',
             ));
        $this->hasColumn('object_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('icategories', array(
             'fields' => 
             array(
              0 => 'categorie',
             ),
             ));
        $this->index('iobject', array(
             'fields' => 
             array(
              0 => 'categorie',
              1 => 'object_id',
             ),
             'unique' => true,
             ));
        $this->index('ititre', array(
             'fields' => 
             array(
              0 => 'categorie',
              1 => 'titre(200)',
             ),
             ));
        $this->index('ititrecitoyen', array(
             'fields' => 
             array(
              0 => 'categorie',
              1 => 'titre(200)',
              2 => 'citoyen_id',
             ),
             ));
        $this->index('iarticle', array(
             'fields' => 
             array(
              0 => 'article_id',
             ),
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

        $this->hasOne('Article', array(
             'local' => 'article_id',
             'foreign' => 'id'));

        $this->hasMany('Article as SousArticles', array(
             'local' => 'id',
             'foreign' => 'article_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $versionable0 = new Doctrine_Template_Versionable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'titre',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($versionable0);
        $this->actAs($sluggable0);
    }
}