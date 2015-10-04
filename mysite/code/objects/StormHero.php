<?php

/**
 * Class StormHero Hero of the Storm
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property integer AccessLevel
 * @property string LastLinkSegment
 * @property HTMLText Content
 * @method Image Image()
 * @method Image Icon()
 * @method ManyManyList Tags() [HeroTag]
 * @method HasManyList Speech() [HeroSpeech]
 * @method HasManyList Skins() [HeroSkin]
 *
  */
class StormHero extends DataObject implements PermissionProvider {

    private static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'IdentityTitle'=> 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        'Universe' => "Enum('Warcraft, Diablo, Starcraft, Overwatch, Other')",
        'Role' => "Enum('Assassin, Specialist, Support, Warrior')",
        'AccessLevel' => 'Int',
        'Draft' => 'Boolean',
        'Trailer' => 'Varchar(255)',
        'Spotlight' => 'Varchar(255)',
        'Content' => 'Text',
    );

    private static $has_one = array(
        'Icon' => 'Image',
        'Image' => 'Image',
    );

    private static $has_many = array(
        'Speech' => 'HeroSpeech',
        'Skins' => 'HeroSkin',
    );

    private static $many_many = array(
        'Tags' => 'HeroTag',
    );

    private static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU'
    );

    private static $indexes = array(
        'ID_StormHero_LastLinkSegment' => array(
            'type' => 'unique',
            'value' => 'LastLinkSegment'
        ),
        'Universe' => true,
    );

    public static $api_access = array(
       'view' => array(
           'Title', 'TitleEN', 'TitleRU', 'IdentityTitle',
           'LastLinkSegment', 'AccessLevel', 'Draft',
           'Role', 'Universe', 'Trailer', 'Spotlight',
           'Content', 'IconSrc', 'Image'
       )
    );

    private static $default_sort = "\"AccessLevel\" ASC, \"TitleEN\" ASC";

    private static  $plural_name = 'Heroes of the Storm';

    private static  $singular_name = 'Hero of the Storm';

    public function providePermissions() {
        return array(
            'CREATE_EDIT_HERO' => array(
                'name' => _t('StormHero.PERMISSION_CREATE_EDIT_DESCRIPTION', 'Create objects of Nexus'),
                'category' => _t('Permissions.BLIZZGAME_HEROES', 'BlizzGame Nexus'),
                'help' => _t('StormHero.PERMISSION_CREATE_EDIT_HELP', 'Permission required to create new object of Nexus.')
            ),
            'DELETE_HERO' => array(
                'name' => _t('StormHero.PERMISSION_DELETE_DESCRIPTION', 'Edit objects of Nexus'),
                'category' => _t('Permissions.BLIZZGAME_HEROES', 'BlizzGame Nexus'),
                'help' => _t('StormHero.PERMISSION_DELETE_HELP', 'Permission required to delete existing object of Nexus.')
            ),
        );
    }

    public function canCreate($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canEdit($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canDelete($Member = null) {return (permission::check('DELETE_HERO')) ? true : false;}
    public function canView($member = null) {return true;}

    public function getTitle() {
        return $this->TitleRU;
    }

    public function getMetaDescription() {
        return $this->Content;
    }

    public function getTitleWithAccess() {
        return $this->AccessLevel ? $this->TitleRU . ' (' . $this->AccessLevel . ')' : $this->TitleRU;
    }

    public function getClass() {
        return strtolower($this->LastLinkSegment);
    }

    public function getURLPrefix() {
        return Director::baseURL() . 'nexus/';
    }

    public function getLink() {
        return $this->getURLPrefix() . $this->LastLinkSegment;
    }

    public function getIconSrc() {
        return $this->Icon()->ID ? $this->Icon()->getURL() : SiteConfig::current_site_config()->DefaultElementImage()->getUrl();
    }
    public function IntroSpeech() {
        return $this->Speech()->filter(array('type' => array('Question', 'Response')))->sort(array('ToID' => 'DESC', 'ToSeveralID' => 'Desc'));
    }

    public function BoastSpeech() {
        return $this->Speech()->filter(array('type' => 'Boast'));
    }

    public function PissedSpeech() {
        return $this->Speech()->filter(array('type' => 'Pissed'));
    }

    public function KillSpeech() {
        return $this->Speech()->filter(array('type' => 'WhenKill'));
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->dataFieldByName('Icon')->setFolderName('Nexus/Icons/');
        $fields->dataFieldByName('Image')->setFolderName('Nexus/Heroes/');
        return $fields;
    }

    public static function getHeroesField($name, $title) {
        $field = new DropdownField(
            $name,
            $title,
            DataObject::get('StormHero', null, 'TitleEN')->map('ID', 'TitleEN')->toArray()
        );
        $field->setEmptyString(_t('HeroSpeech.SELECT_HERO', 'Укажите героя нексуса'));
        return $field;
    }
}
