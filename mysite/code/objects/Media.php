<?php

/**
 * Class Media
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property String LastLinkSegment
 * @property String Format
 * @property String Duration
 * @property String Content
 * @property String PublisherEN
 * @property String DateSaleEN
 */
class Media extends DataObject {

    static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        'Format' => 'Varchar(255)',
        'Duration' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'PublisherEN' => 'Varchar(255)',
        'DateSaleEN' => 'Date',
        'Category' => "Enum('soundtrack,behind-the-scenes-dvd')",
    );

    static $has_one = array (
        'Cover' => 'Image',
        'HolderPage' => 'MediaPage'
    );

    static $many_many = array(
        'Authors' => 'PeopleFace'
    );

    static $summary_fields = array(
        'ID', 'Title', 'DateSaleEN'
    );

    static $default_sort = 'DateSaleEN DESC';

    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }
}
