<?php/** * Class GalleryImage * * @property string Title Title of the Gallery Image * @property string Size * @property Integer MaxSize * @property string LastLinkSegment * @method PeopleFace Author() * @method Image Image() * @method GalleryPage GalleryPage() * @method ManyManyList Tags() * @method ManyManyList NexusTags() */class GalleryImage extends DataObject implements ObjectAsPageProvider {    const SMALL = 'small';    const MEDIUM = 'medium';    const LARGE = 'large';    const EXTRA_LARGE = 'extra-large';    private static $db = array(        'Title' => 'Varchar(280)',        'IsOfficial' => 'Boolean',        'Size' => 'Varchar(20)',        'MaxSize' => "Int",        'LastLinkSegment' => 'Varchar(255)'    );    // One-to-one relationship with gallery page    private static $has_one = array(        'Author' => 'PeopleFace',        'Image' => 'Image',        'GalleryPage' => 'GalleryPage',    );    private static $many_many = array(        'Tags' => 'ElementLink',        'NexusTags' => 'StormHero',    );    private static $indexes = array(        'ID_UniqueLastLinkSegment' => array(            'type' => 'unique',            'value' => 'LastLinkSegment'        ),        'Size' => true,    );    private static $default_sort = 'Created DESC';    private static $summary_fields = array(        'ID',        'Title',        'Author.TitleEN',        'Thumbnail',    );    private static $searchable_fields = array(        'Title',    );    public static $field_labels = array(        'Author.TitleEN' => 'Artist',    );    private static $api_access = array(        'view' => array(            'Title', 'Size', 'LastLinkSegment',            'Link',            'PageSize', 'FrontEndThumbnail'        )    );    public function getLink() {        return $this->Link();    }    public function getFrontEndThumbnail() {        return $this->Image()->CroppedImage(290, 290) ? $this->Image()->CroppedImage(290, 290)->getURL() : '';    }    public function getPageSize() {        return $this->Image()->setRatioSize(1024, 3000) ? $this->Image()->CroppedImage(290, 290)->getURL() : '';    }    /**     * @return array     */    public function ElementLinks() {        $array = array();        /** @var ElementLink $val */        foreach ($this->Tags() as $key => $val) {            $array[$key] = $val->toMap();            $array[$key]['Icon'] = $val->IconID ? $val->Icon()->getURL() : SiteConfig::current_site_config()->DefaultElementImage()->GetUrl();            $array[$key]['Link'] = $this->HolderPage()->Link() . $this->LastLinkSegment;            $array[$key]['SummaryText'] = $val->LinkToPage() instanceof Page ? $val->LinkToPage()->Summary(20) : '';        }        return $array;    }    //Permissions    function canCreate($Member = null) {return (permission::check('CREATE_GALLERY')) ? true : false;}    function canEdit($Member = null) {return (permission::check('EDIT_GALLERY')) ? true : false;}    function canDelete($Member = null) {return (permission::check('DELETE_GALLERY')) ? true : false;}    public function canView($member = null) {return true;}    /**     *     * @return GalleryPage     */    public function HolderPage() {        return $this->GalleryPage();    }    /**     * @param $url     * @return static     */    public static function get_by_url($url) {        $callerClass = get_class();        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");    }    public function getCMSFields() {        $fields = parent::getCMSFields();        $fields->dataFieldByName('Image')->setFolderName($this->GalleryPage()->GalFolder);        $fields->removeFieldsFromTab('Root', array('Tags'));        $fields->removeFieldsFromTab("Root.Main", array(            "GalleryPageID", 'Size', 'MaxSize'        ));        $fields->replaceField(            'AuthorID',            PeopleFace::getArtistField('AuthorID', 'Author')        );        $fields->addFieldToTab(            "Root.Main",            ElementLink::getMultipleField('Tags', 'Tags'),            'AuthorID'        );        return $fields;    }    public function onBeforeWrite() {        parent::onBeforeWrite();        $image = $this->Image();        if ($image->ID) {            $pathInfo = pathinfo($image->Name);            $this->LastLinkSegment = $pathInfo['filename'];            $maxSize = ($image->GetWidth() > $image->GetHeight()) ? $image->GetWidth() : $image->GetHeight();            $this->MaxSize = $maxSize;            switch (true) {                case $maxSize < 700:                    $this->Size = self::SMALL;                    break;                case $maxSize >= 700 and $maxSize < 1400:                    $this->Size = self::MEDIUM;                    break;                case $maxSize >= 1400 and $maxSize < 3000:                    $this->Size = self::LARGE;                    break;                case $maxSize >= 3000:                    $this->Size = self::EXTRA_LARGE;                    break;            }        }    }    // this function creates the thumbnail for the summary fields to use    public function getThumbnail() {        return $this->Image()->CMSThumbnail();    }    /**     * @return GalleryImage     */    public function Previous() {        $GalleryImage = DataObject::get_one('GalleryImage',            "\"GalleryImage\".\"GalleryPageID\" = " . $this->getField('GalleryPageID') . " AND \"GalleryImage\".\"ID\" > " . $this->ID,            true,            "Created ASC"        );        return $GalleryImage;    }    /**     * @return GalleryImage     */    public function Next() {        $GalleryImage = DataObject::get_one('GalleryImage',            "\"GalleryImage\".\"GalleryPageID\" = " . $this->getField('GalleryPageID') . " AND \"GalleryImage\".\"ID\" < " . $this->ID,            true,            "Created DESC"        );        return $GalleryImage;    }}