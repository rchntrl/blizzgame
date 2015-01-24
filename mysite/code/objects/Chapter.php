<?php

/**
 * Class AttachedImageChapter
 * @property String NumberSort
 * @method Image Image()
 * @method Chapter Chapter()
 */
class AttachedImageChapter extends DataObject {

    static $db = array(
        'NumberSort' => 'Int'
    );

    static $has_one = array(
        'Image' => 'Image',
        'Chapter' => 'Chapter'
    );

    static $summary_fields = array(
        'Image.Title',
        'Thumbnail',
    );

    static $default_sort = array(
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
class Chapter extends DataObject
{
    static $db = array (
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'NumberSort' => 'Int'
    );

    static $has_many = array(
        'AttachedImages' => 'AttachedImageChapter'
    );

    static $has_one = array (
        'Book' => 'Book'
    );

    static $default_sort = array(
        'NumberSort DESC',
        'Created DESC',
    );

    static $summary_fields = array(
        'ID',
        'Title',
        'NumberSort'
    );

    static $searchable_fields = array(
        'Title'
    );

    public function Link() {
        return $this->Book()->LastLinkSegment . 'translate/' . $this->ID . '/';
    }

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_BOOK')) ? true : false;}
    function canView($Member = null) {return (permission::check('VIEW_BOOK')) ? true : false;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', array('BookID', 'AttachedImages'));
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new GridFieldBulkManager());
        $bulkUpload = new GridFieldBulkUpload();
        $bulkUpload->setUfSetup('setFolderName', 'Attached-Images');
        $gridFieldConfig->addComponent($bulkUpload);
        $gridFieldConfig->removeComponentsByType('GridFieldPaginator');
        $gridFieldConfig->addComponent(new GridFieldPaginator(20));
        $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
        $gridField = new GridField(
            'AttachedImages',
            _t('Chapter.ATTACHED_IMAGES', 'Прикрепленные картинки'),
            $this->AttachedImages(),
            $gridFieldConfig
        );
        $fields->addFieldToTab('Root.AttachedImages', $gridField);
        return $fields;
    }
}
