<?php

/**
 * Class AttachedImageChapter
 * @method Image Image()
 * @method Chapter Chapter()
 */
class AttachedImageChapter extends DataObject {

    static $has_one = array (
        'Image' => 'Image',
        'Chapter' => 'Chapter'
    );

    static $summary_fields = array(
        'Image.Title',
        'Thumbnail',
    );

    public static $field_labels = array(
        'Image.Title' => 'Title',
    );

    function needResizePhoto($size) {
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
 * @method DataList AttachedImages()
 * @method Book Book()
 */
class Chapter extends DataObject
{
    static $db = array (
        'Title' => 'Varchar(255)',
        'Content' => 'HtmlText',
        'NumberSort' => 'Int'
    );

    static $has_many = array(
        'AttachedImages' => 'AttachedImageChapter'
    );

    static $has_one = array (
        'Book' => 'Book'
    );

    private static $default_sort = 'NumberSort ASC';

    static $summary_fields = array(
        'ID',
        'Title',
        'NumberSort'
    );

    static $searchable_fields = array(
        'Title'
    );

    public function Link() {
        return $this->Book()->lastLinkSegment . 'translate/' . $this->ID . '/';
    }

    public function LinkOrCurrent() {
        return ($_GET['url'] == $this->Link()) ? 'current' : 'link';
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', array('BookID', 'AttachedImages'));
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new GridFieldBulkManager());
        $bulkUpload = new GridFieldBulkUpload();
        $bulkUpload->setUfSetup('setFolderName', 'Attached-Images');
        $gridFieldConfig->addComponent($bulkUpload);
        $gridFieldConfig->removeComponentsByType('GridFieldPaginator'); // Remove default paginator
        $gridFieldConfig->addComponent(new GridFieldPaginator(20)); // Add custom paginator
        $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton'); // We only use bulk upload button
        $gridField = new GridField(
            'AttachedImages',
            _t('Chapter.ATTACHED_IMAGES', 'Attached Images'),
            $this->AttachedImages(),
            $gridFieldConfig
        );
        $fields->addFieldToTab('Root.AttachedImages', $gridField);
        return $fields;
    }
}
