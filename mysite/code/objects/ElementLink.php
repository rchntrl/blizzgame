<?php

/**
 * Class ElementLink
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property string LastLinkSegment
 * @method Image Icon()
 * @method Subsite Subsite()
 * @method ElementLinkGroup ElementLinkGroup()
 */
class ElementLink extends DataObject
{
    private static $db = array (
		'TitleEN' => 'Varchar(255)',
		'TitleRU' => 'Varchar(255)',
		'LinkURL' => 'Varchar(255)',
		'LinkURL2' => 'Int', // link to Page
		'LastLinkSegment' => 'Varchar(255)'
	);

    private static $has_one = array (
        'ElementLinkGroup' => 'ElementLinkGroup',
        'Subsite' => 'Subsite',
		'Icon' => 'Image',
	);

    private static $searchable_fields = array(
        'SubsiteID', 'ElementLinkGroupID'
    );

    private static $summary_fields = array (
        'ID', 'Title', 'ElementLinkGroup.Title'
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
        $fields->replaceField('LinkURL2',
            new TreeDropdownField("LinkURL2", "Link Page", 'Page', 'ID', 'TreeTitle')
        );
        $fields->dataFieldByName('LinkURL')->setReadonly(true);
        $fields->dataFieldByName('LastLinkSegment')->setReadonly(true);
        return $fields;
    }
	
	function  Thumbnail() {
		$Image = $this->Icon();
		if ( $Image ) {
			return $Image->CroppedImage(30,30);
		} else {
			return null;
		}
	}

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }
}
