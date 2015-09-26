<?php

/**
 * Class HeroSkin
 * @property String TitleEN
 * @property String TitleRU
 * @property String Type
 * @method StormHero Hero()
 * @method Image Image()
 */
class HeroSkin extends DataObject {

    private static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'Type' => "Enum('Master, Epic, Legendary')",
        'Content' => 'HTMLText',
    );

    private static $has_one = array(
        'Hero' => 'StormHero',
        'Image' => 'Image',
        'Icon' => 'Image',
    );

    private static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU'
    );

    public static $api_access = array(
        'view' => array(
            'Title', 'TitleEN', 'TitleRU', 'Type',
            'Content', 'ImageSrc', 'IconSrc',
        )
    );

    public function canCreate($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canEdit($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canDelete($Member = null) {return (permission::check('DELETE_HERO')) ? true : false;}
    public function canView($member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->dataFieldByName('Image')->setFolderName('Nexus/Skins/');
        $fields->dataFieldByName('Icon')->setFolderName('Nexus/Icon/');
        return $fields;
    }

    public function getImageSrc() {
        return $this->Image()->ID ? $this->Image()->getURL() : null;
    }

    public static function getListField($name, $title) {
        $field = new DropdownField(
            $name,
            $title,
            DataObject::get('HeroSkin', null, 'TitleEN')->map('ID', 'TitleEN')->toArray()
        );
        $field->setEmptyString(_t('HeroSpeech.SELECT_SKIN', 'Укажите облик героя'));
        return $field;
    }
}
