<?php

/**
 * Class ElementLink
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property Image Icon
 * @property ElementLinkGroup ElementLinkGroup
 * @property string LastLinkSegment
 */
class ElementLink extends DataObject
{
    private static $db = array (
		'TitleEN' => 'Varchar(255)',
		'TitleRU' => 'Varchar(255)',
		'LinkURL' => 'Varchar(255)',
		'LinkURL2' => 'Int',
		'OverTitleEN' => 'Varchar(255)',
		'OverTitleRU' => 'Varchar(255)',
		'LastLinkSegment' => 'Varchar(255)'
	);

    private static $has_one = array (
		'Icon' => 'Image',
        'Subsite' => 'Subsite',
		'ElementLinkGroup' => 'ElementLinkGroup'
	);

    private static $searchable_fields = array(
        'SubsiteID', 'ElementLinkGroupID'
    );

    private static $summary_fields = array (
        'ID', 'TitleEN', 'TitleRU', 'ElementLinkGroup.Title'
    );

    private static $field_labels = array(
        'ElementLinkGroup.Title' => 'Group Title',
        'SubsiteID' => 'Subsite',
        'ElementLinkGroupID' => 'Group'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if(class_exists('Subsite')){
            $fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
        }
        return $fields;
    }
	
	function  Thumbnail() {
		$Image = $this->Icon;
		if ( $Image ) {
			return $Image->CroppedImage(30,30);
		} else {
			return null;
		}
	}

    public function getTitle() {
        return $this->getField('TitleEN');
    }
}
