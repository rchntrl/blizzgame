<?php

/**
 * Class HeroTag
 * @property string TitleEN
 * @property string TitleRU
 * @property string LastLinkSegment
 * @method Image Icon()
 */
class HeroTag extends DataObject {

    private static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
    );

    private static $has_one = array(
        'Icon' => 'Image',
    );

    private static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU'
    );

    public static $api_access = array(
        'view' => array(
            'Title', 'TitleEN', 'TitleRU',
            'LastLinkSegment', 'Icon'
        )
    );

    public function canCreate($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canEdit($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canDelete($Member = null) {return (permission::check('DELETE_HERO')) ? true : false;}
    public function canView($member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->dataFieldByName('Icon')->setFolderName('Nexus/Tags/');
        return $fields;
    }

    public function getTitle() {
        return $this->TitleRU;
    }

    public static function getListField($name, $title) {
        $field = new DropdownField(
            $name,
            $title,
            DataObject::get('HeroTag', null, 'TitleEN')->map('ID', 'TitleEN')->toArray()
        );
        $field->setEmptyString(_t('HeroSpeech.SELECT_HERO', 'Укажите признак героев нексуса'));
        return $field;
    }
}
