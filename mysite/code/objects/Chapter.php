<?php

/**
 * Class AttachedImageChapter
 * @property String NumberSort
 * @method Image Image()
 * @method Chapter Chapter()
 */
class AttachedImageChapter extends DataObject {

    private static $db = array(
        'NumberSort' => 'Int'
    );

    private static $has_one = array(
        'Image' => 'Image',
        'Chapter' => 'Chapter'
    );

    private static $summary_fields = array(
        'Image.Title',
        'Thumbnail',
    );

    private static $default_sort = array(
        'NumberSort DESC',
        'Created DESC',
    );

    public static $field_labels = array(
        'Image.Title' => 'Title',
    );

    function needResize($size) {
        return ($size < $this->Image()->getWidth()) ? true : false;
    }

    public function getThumbnail() {
        return $this->Image()->CMSThumbnail();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->makeFieldReadonly('ChapterID');
        return $fields;
    }
}

/**
 * Class AttachedImageChapter
 *
 * @property String Title
 * @property String Content HTML content
 * @property String NumberSort
 * @method DataList AttachedImages()
 * @method Book Book()
 */
class Chapter extends DataObject implements ObjectAsPageProvider {
    private static $db = array (
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'NumberSort' => 'Int'
    );

    private static $has_many = array(
        'AttachedImages' => 'AttachedImageChapter'
    );

    private static $has_one = array (
        'Book' => 'Book'
    );

    private static $default_sort = array(
        'NumberSort ASC',
        'Created ASC',
    );

    private static $summary_fields = array(
        'ID',
        'Title',
        'NumberSort'
    );

    private static $searchable_fields = array(
        'Title'
    );

    public function metaTitle() {
        return $this->Book()->TitleRU . '. ' . $this->Title;
    }

    public function Link() {
        return $this->Book()->Link() . '/translate/' . $this->ID . '/';
    }

    public function HolderPage() {
        return $this->Book()->HolderPage();
    }

    public function getParent() {
        return $this->Book();
    }

    public function Next() {
        return DataObject::get_one('Chapter',
            "\"Chapter\".\"BookID\" = " . $this->getField('BookID') . " AND \"Chapter\".\"NumberSort\" = " . ($this->getField('NumberSort') + 1)
        );
    }

    public function Previous() {
        return DataObject::get_one('Chapter',
            "\"Chapter\".\"BookID\" = " . $this->getField('BookID') . " AND \"Chapter\".\"NumberSort\" = " . ($this->getField('NumberSort') - 1)
        );
    }

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_BOOK')) ? true : false;}
    function canView($Member = null) {return (permission::check('VIEW_BOOK')) ? true : false;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', array('BookID'));
        if ($fields->dataFieldByName('AttachedImages')) {
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig = $fields->dataFieldByName('AttachedImages')->getConfig();
            $gridFieldConfig->addComponent(new GridFieldBulkManager());
            $bulkUpload = new GridFieldBulkUpload();
            $bulkUpload->setUfSetup('setFolderName', 'Attached-Images/' . SiteConfig::current_site_config()->Title);
            $gridFieldConfig->addComponent($bulkUpload);
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('NumberSort'));
            $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
            $fields->dataFieldByName('AttachedImages')->setConfig($gridFieldConfig);
        }
        return $fields;
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        $this->Link();
    }
}
