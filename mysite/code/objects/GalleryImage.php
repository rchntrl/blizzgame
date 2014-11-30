<?php/** * Class GalleryImage * * @property string Title Title of the Gallery Image * @property string Size * @property Integer MaxSize * @property string LastLinkSegment * @method PeopleFace Author() * @method Image Image() * @method ElementLink Tags() */class GalleryImage extends DataObject {    public static $db = array(        'Title' => 'Varchar(280)',        'Size' => 'Varchar(20)',        'MaxSize' => "Int",        'LastLinkSegment' => 'Varchar(255)'    );    // One-to-one relationship with gallery page    public static $has_one = array(        'Author' =>	'PeopleFace',        'Image' => 'Image',        'GalleryPage' => 'GalleryPage',    );    static $many_many = array(        'Tags' => 'ElementLink',    );    public static $indexes = array(        'ID_UniqueLastLinkSegment' => array(            'type' => 'unique',            'value' => 'LastLinkSegment'        )    );    public static $summary_fields = array(        'Title',        'Author.TitleEN',        'Thumbnail',    );    public static $field_labels = array(        'Author.TitleEN' => 'Artist',    );    public function fieldLabels() {        return array_merge(self::$field_labels,            array(                'Author.TitleEN' => _t('Gallery.Author', 'Artist'),            )        );    }    //Permissions    function canEdit($Member = null){        return (permission::check('EDIT_GALLERY')) ? true : false;    }    function canCreate($Member = null){        return (permission::check('EDIT_GALLERY')) ? true : false;    }    function canDelete($Member = null){       return (permission::check('DELETE_GALLERY')) ? true : false;    }    public function getCMSFields() {        $fields = parent::getCMSFields();        $fields->removeFieldFromTab("Root.Main","GalleryPageID");        $fields->removeFieldFromTab("Root.Main","SortOrder");        $fields->replaceField(            'AuthorID',            new DropdownField(                'AuthorID',                'Author',                PeopleFace::getOnly('Artist')->map('ID', 'TitleEN')            )        );        // todo make tag input with ajax         $fields->addFieldToTab(            "Root.Main",            new ListboxField(                'Tags',                'Tags',                DataObject::get('ElementLink', "\"ElementLink\".\"SubsiteID\" =" . Subsite::currentSubsiteID(), 'TitleEn', '', 500)->map('ID', 'TitleEN')->toArray(),                '',     // value                8,      // size                true    // multiple            ),            'AuthorID'        );/**/        return $fields;    }    public function onBeforeWrite() {        $image = $this->Image();        if ($image->ID) {            $pathInfo = pathinfo($image->Name);            $this->LastLinkSegment = $pathInfo['filename'];            $maxSize = ($image->GetWidth() > $image->GetHeight()) ? $image->GetWidth() : $image->GetHeight();            $this->MaxSize = $maxSize;            switch (true) {                case $maxSize < 700:                    $this->Size = 'small';                    break;                case $maxSize >= 700 and $maxSize < 1400:                    $this->Size = 'medium';                    break;                case $maxSize >= 1400 and $maxSize < 3000:                    $this->Size = 'large';                    break;                case $maxSize >= 3000:                    $this->Size = 'extra-large';                    break;            }        }        parent::onBeforeWrite();    }    // Add validation    public function validate() {        $result = parent::validate();        $charCount = strlen($this->Title);        $description = 'You should have less than 280 characters in the description. You have';        if($charCount > 280) {            $result->error($description . ' ' . $charCount);        }        return $result;    }    // this function creates the thumbnail for the summary fields to use    public function getThumbnail() {        return $this->Image()->CMSThumbnail();    }}