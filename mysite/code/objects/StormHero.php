<?php

/**
 * Class StormHero Hero of the Storm
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property integer AccessLevel
 * @property string LastLinkSegment
 * @property Image Image
 */
class StormHero extends DataObject {

    static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        'AccessLevel' => 'Int',
        'Content' => 'HTMLText',
    );

    public static $has_one = array(
        'Image' => 'Image'
    );

    static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU'
    );

    static $default_sort = "\"AccessLevel\" ASC, \"TitleRU\" ASC";

    static  $plural_name = 'Heroes of the Storm';

    static  $singular_name = 'Hero of the Storm';

    public function getTitle() {
        return $this->AccessLevel ? $this->TitleRU . ' (' . $this->AccessLevel . ')' : $this->TitleRU;
    }

    public function getClass() {
        return strtolower($this->LastLinkSegment);
    }

    public function getURLPrefix() {
        return '/heroes/';
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
