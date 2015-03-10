<?php

/**
 * Class PeopleFace
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property string Nick
 * @property string Writer
 * @property string LastLinkSegment
 * @property string PeopleFacePageID
 * @method PeopleFacePage PeopleFacePage()
 * @method SS_List GalleryImages()
 */
class PeopleFace extends DataObject implements ObjectAsPageProvider {

    const WRITER    = 'Writer';
    const ARTIST    = 'Artist';
    const COMPOSER  = 'Composer';
    const DEVELOPER = 'Developer';

    public static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'Nick' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        //'Categoria' => "Varchar(20)", //Enum('Автор,Художник,Композитор,Писатель,Разработчик')
        'Writer' => 'Boolean',
        'Artist' => 'Boolean',
        'Composer' => 'Boolean',
        'Developer' => 'Boolean',
        'Content' => 'HTMLText',
        'WebLink' => 'Varchar(255)',
    );

    public static $has_one = array (
        'Photo' => 'Image',
        'PeopleFacePage' => 'PeopleFacePage'
    );

    public static $has_many = array (
         'GalleryImages' => 'GalleryImage',
    );

    static $belongs_many_many = array(
        'Books' => 'Book',
        'PaintsCover' => 'Book',
        'PaintsPages' => 'Book',
    );

    public static $summary_fields = array (
        'ID', 'TitleEN', 'TitleRU', 'Nick'
    );

    static $singular_name = 'Blizz People';

    static $plural_name = 'Blizz Person';

    static $default_sort = 'TitleEN ASC';

    public function getTitle() {
        return $this->getField('TitleEN') . ($this->getField('Nick') ? ' (' . $this->getField('Nick') . ')' : '');
    }

    public function MenuTitle() {
        return $this->TitleEN;
    }

    /**
     * @return PeopleFacePage
     */
    public function HolderPage() {
        return $this->PeopleFacePage();
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        if (!$this->PeopleFacePage()->ID) {
            $this->PeopleFacePageID = PeopleFacePage::get_by_id("PeopleFacePage", 1533)->ID;
        }
    }

    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_TAG')) ? true : false;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'PeopleFacePageID'
        ));

        return $fields;
    }

    /**
     * @param String(Writer|Artist|Composer|Developer) $category
     * @return \DataList
     */
    public static function getOnly($category) {
        return DataObject::get('PeopleFace', "\"PeopleFace\".\"" . $category . "\" = 1");
    }

    public function Closest($limit  = 7) {
        return DataObject::get('PeopleFace',
            "\"PeopleFace\".\"HolderPageID\" = " . $this->getField('HolderPageID') .
            " AND \"PeopleFace\".\"NumberSort\" >= " . ($this->NumberSort - round($limit / 2)),
            "NumberSort ASC",
            "",
            $limit
        );
    }

    /**
     * get Artist Field
     * @param string $name
     * @param string $title
     * @return DropdownField
     */
    public static function getArtistField($name = 'AuthorID', $title = 'Author') {
        $artistField = new DropdownField(
            $name,
            _t('PeopleFace.ARTIST', $title),
            PeopleFace::getOnly(PeopleFace::ARTIST)->map('ID', 'Title')
        );
        $artistField->setEmptyString(_t('Gallery.SELECT_ARTIST', 'Выберите художника'));
        return $artistField;
    }

    /**
     * get Artist Field
     * @param string $name
     * @param string $title
     * @return DropdownField
     */
    public static function getWriterField($name = 'AuthorID', $title = 'Author') {
        $artistField = new DropdownField(
            $name,
            _t('PeopleFace.WRITER', $title),
            PeopleFace::getOnly(PeopleFace::WRITER)->map('ID', 'Title')
        );
        $artistField->setEmptyString(_t('Gallery.SELECT_WRITER', 'Выберите писателя'));
        return $artistField;
    }

    /**
     * @param string $name
     * @param string $title
     * @param string $category
     * @return DropdownField
     */
    public static function getMultipleField($name = 'Writers', $title = 'Writers', $category = PeopleFace::WRITER) {
        return new ListboxField(
            $name,
            $title,
            PeopleFace::getOnly($category)->map('ID', 'Title')->toArray(),
            '',
            8,
            true
        );
    }
}
