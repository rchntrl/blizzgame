<?php/** * Class GalleryImage * * @property string Title Title of the Gallery Image * @property string Size * @property Integer MaxSize * @property string LastLinkSegment * @method PeopleFace Author() * @method Image Image() * @method GalleryPage GalleryPage() * @method ElementLink Tags() */class GalleryImage extends DataObject implements ObjectAsPageProvider {    const SMALL = 'small';    const MEDIUM = 'medium';    const LARGE = 'large';    const EXTRA_LARGE = 'extra-large';    public static $db = array(        'Title' => 'Varchar(280)',        'Size' => 'Varchar(20)',        'MaxSize' => "Int",        'LastLinkSegment' => 'Varchar(255)'    );    // One-to-one relationship with gallery page    public static $has_one = array(        'Author' => 'PeopleFace',        'Image' => 'Image',        'GalleryPage' => 'GalleryPage',    );    static $many_many = array(        'Tags' => 'ElementLink',    );    public static $indexes = array(        'ID_UniqueLastLinkSegment' => array(            'type' => 'unique',            'value' => 'LastLinkSegment'        ),        'Size' => true,    );    static $default_sort = 'Created DESC';    static $summary_fields = array(        'ID',        'Title',        'Author.TitleEN',        'Thumbnail',    );    public static $field_labels = array(        'Author.TitleEN' => 'Artist',    );    //Permissions    function canCreate($Member = null) {return (permission::check('CREATE_GALLERY')) ? true : false;}    function canEdit($Member = null) {return (permission::check('EDIT_GALLERY')) ? true : false;}    function canDelete($Member = null) {return (permission::check('DELETE_GALLERY')) ? true : false;}    function canView($Member = null) {return (permission::check('VIEW_GALLERY')) ? true : false;}    /**     * see BreadCrumbs method of BlizzgameObjectExtension     *     * @return GalleryPage     */    public function HolderPage() {        return $this->GalleryPage();    }    /**     * @param $url     * @return static     */    public static function get_by_url($url) {        $callerClass = get_class();        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");    }    public function getCMSFields() {        $fields = parent::getCMSFields();        $fields->dataFieldByName('Image')->setFolderName($this->GalleryPage()->GalFolder);        $fields->removeFieldsFromTab('Root', array('Tags'));        $fields->removeFieldsFromTab("Root.Main", array(            "GalleryPageID", 'Size', 'MaxSize'        ));        $fields->replaceField(            'AuthorID',            PeopleFace::getArtistField('AuthorID', 'Author')        );        $fields->addFieldToTab(            "Root.Main",            ElementLink::getMultipleField('Tags', 'Tags'),            'AuthorID'        );        return $fields;    }    public function onBeforeWrite() {        parent::onBeforeWrite();        $image = $this->Image();        if ($image->ID) {            $pathInfo = pathinfo($image->Name);            $this->LastLinkSegment = $pathInfo['filename'];            $maxSize = ($image->GetWidth() > $image->GetHeight()) ? $image->GetWidth() : $image->GetHeight();            $this->MaxSize = $maxSize;            switch (true) {                case $maxSize < 700:                    $this->Size = self::SMALL;                    break;                case $maxSize >= 700 and $maxSize < 1400:                    $this->Size = self::MEDIUM;                    break;                case $maxSize >= 1400 and $maxSize < 3000:                    $this->Size = self::LARGE;                    break;                case $maxSize >= 3000:                    $this->Size = self::EXTRA_LARGE;                    break;            }        }    }    // this function creates the thumbnail for the summary fields to use    public function getThumbnail() {        return $this->Image()->CMSThumbnail();    }    /**     * @return GalleryImage     */    public function Previous() {        $GalleryImage = DataObject::get_one('GalleryImage',            "\"GalleryImage\".\"GalleryPageID\" = " . $this->getField('GalleryPageID') . " AND \"GalleryImage\".\"ID\" > " . $this->ID,            true,            "Created ASC"        );        return $GalleryImage;    }    /**     * @return GalleryImage     */    public function Next() {        $GalleryImage = DataObject::get_one('GalleryImage',            "\"GalleryImage\".\"GalleryPageID\" = " . $this->getField('GalleryPageID') . " AND \"GalleryImage\".\"ID\" < " . $this->ID,            true,            "Created DESC"        );        return $GalleryImage;    }}