<?php

/**
 * Class StormHero Hero of the Storm
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property integer AccessLevel
 * @property string LastLinkSegment
 * @method Image Image()
 * @method Image Icon()
  */
class StormHero extends DataObject implements PermissionProvider {

    private static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        'Universe' => "Enum('Warcraft, Diablo, Starcraft, Overwatch, Other')",
        'AccessLevel' => 'Int',
        'Content' => 'HTMLText',
    );

    private static $has_one = array(
        'Image' => 'Image',
        'Icon' => 'Image',
    );

    private static $has_many = array(
        'Speech' => 'HeroSpeech',
        'Skins' => 'HeroSkin',
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
           'Title', 'TitleEN', 'TitleRU', 'LastLinkSegment', 'Link', 'Universe', 'AccessLevel', 'Content',
           'IconSrc'
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
        return $this->AccessLevel ? $this->TitleRU . ' (' . $this->AccessLevel . ')' : $this->TitleRU;
    }

    public function getClass() {
        return strtolower($this->LastLinkSegment);
    }

    public function getURLPrefix() {
        return '/nexus/';
    }

    public function getIconSrc() {
        return $this->Icon()->ID ? $this->Icon()->getURL() : SiteConfig::current_site_config()->DefaultElementImage()->getUrl();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->dataFieldByName('Icon')->setFolderName('NexusIcons/');
        return $fields;
    }

    public static function getHeroesField($name, $title) {
        $field = new DropdownField(
            $name,
            $title,
            DataObject::get('StormHero', null, 'TitleEN')->map('ID', 'TitleEN')->toArray()
        );
        $field ->setEmptyString(_t('HeroSpeech.SELECT_HERO', 'Укажите героя нексуса'));
        return $field;
    }
}
