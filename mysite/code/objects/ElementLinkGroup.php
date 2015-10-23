<?php

class ElementLinkGroup extends  DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
    );

    private static $has_one = array (
        'Subsite' => 'Subsite'
    );

    private static $has_many = array(
        'ElementLinks'  => 'ElementLink'
    );

    private static $searchable_fields = array(
        'Title', 'SubsiteID'
    );

    private static $summary_fields = array (
        'ID', 'Title'
    );

    private static $field_labels = array(
        'Subsite.Title' => 'Subsite Title',
        'SubsiteID' => 'Subsite',
    );

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_TAG')) ? true : false;}
    function canView($Member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if(class_exists('Subsite')){
            $fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
        }
        return $fields;
    }

    public static function getDropdownField($name, $title) {
        $subsiteID = Subsite::currentSubsiteID();
        return new ListboxField(
            $name,
            $title,
            ElementLinkGroup::get('ElementLinkGroup', "\"ElementLinkGroup\".\"SubsiteID\" = '" . $subsiteID ."'")->map('ID', 'Title')->toArray(),
            '',     // value
            8,      // size
            true    // multiple
        );
    }
} 