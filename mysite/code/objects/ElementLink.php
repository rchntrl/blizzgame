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
    const PLACES    = 1;
    const EVENTS    = 2;
    const RACES     = 3;
    const FRACTIONS = 4;
    const HEROES    = 5;
    const MONSTERS  = 6;
    const ITEMS     = 7;

    private static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LinkURL' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)'
    );

    private static $has_one = array (
        'ElementLinkGroup' => 'ElementLinkGroup',
        'LinkToPage' => 'SiteTree',
        'Subsite' => 'Subsite',
        'Icon' => 'Image',
    );

    private static $searchable_fields = array(
        'TitleEN', 'TitleRU', 'ElementLinkGroupID'
    );

    private static $summary_fields = array (
        'ID', 'Title', 'ElementLinkGroup.Title'
    );

    private static $field_labels = array(
        'ElementLinkGroup.Title' => 'Group Title',
        'SubsiteID' => 'Subsite',
        'ElementLinkGroupID' => 'Group'
    );

    public function providePermissions() {
        return array(
            "CREATE_EDIT_TAG" => "View/Edit Tags (Authors, Element Links)",
            "DELETE_TAG" => "Delete Tags (Authors, Element Links)",
            "VIEW_TAG" => "View Tags (Authors, Element Links)",
        );
    }

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_TAG')) ? true : false;}
    function canView($Member = null) {return (permission::check('VIEW_TAG')) ? true : false;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if (class_exists('Subsite')) {
            $fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
        }
        $fields->replaceField('LinkToPageID',
            new TreeDropdownField("LinkToPageID", "Link To Page", 'Page', 'ID', 'TreeTitle')
        );
        $fields->dataFieldByName('LinkURL')->setReadonly(true);
        return $fields;
    }

    function Thumbnail() {
        $Image = $this->Icon();
        return $Image ? $Image->CroppedImage(30, 30) : null;
    }

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }

    /**
     * todo make tag input with ajax
     * @param string $name
     * @param string $title
     * @param int $filterByGroup
     * @return ListboxField
     */
    public static function getMultipleField($name, $title, $filterByGroup = null) {
        $subsiteID = Subsite::currentSubsiteID();
        $groupID = null;
        $fractions = array(976, 1774, 0);
        $races = array(1292, 0, 0);
        $places = array(977, 1773, 0);
        $heroes = array(975, 1771, 0);
        $monsters = array(978, 1772, 0);
        $items = array(979, 1943, 0);
        $evens = array(980, 0, 0);
        switch ($filterByGroup) {
            case ElementLink::FRACTIONS:
                $groupID = $fractions[$subsiteID-1];
                break;
            case ElementLink::HEROES:
                $groupID = $heroes[$subsiteID-1];
                break;
            case ElementLink::PLACES:
                $groupID = $places[$subsiteID-1];
                break;
            case ElementLink::EVENTS:
                $groupID = $evens[$subsiteID-1];
                break;
            case ElementLink::MONSTERS:
                $groupID = $monsters[$subsiteID-1];
                break;
            case ElementLink::RACES:
                $groupID = $races[$subsiteID-1];
                break;
            case ElementLink::ITEMS:
                $groupID = $items[$subsiteID-1];
                break;
        }

        $filter = array("\"ElementLink\".\"SubsiteID\" =" . $subsiteID);
        if ($groupID) {
            $filter[] = "\"ElementLink\".\"ElementLinkGroupID\" = " . $groupID;
            $title = _t('ElementLink.GROUP_' . $groupID, $title);
        }
        $tagsField = new ListboxField(
            $name,
            $title,
            DataObject::get('ElementLink', $filter, 'TitleEN')->map('ID', 'TitleEN')->toArray(),
            '',     // value
            8,      // size
            true    // multiple
        );
        return $tagsField;
    }
}
