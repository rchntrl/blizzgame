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

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if(class_exists('Subsite')){
            $fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
        }
        return $fields;
    }
} 