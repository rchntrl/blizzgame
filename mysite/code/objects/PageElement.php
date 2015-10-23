<?php

/**
 * Class PageElement
 * @property String Name
 * @property String Title
 * @property Int Order
 */
class PageElement extends DataObject {

    private static $db = array(
        'Name' => 'Varchar',
        'Title' => 'Varchar',
        'SortOrder' => 'Int',
        'Content' => 'HTMLText',
    );

    private static $has_one = array (
        'Chronicle' => 'ChronicleItem',
    );

    private static $has_many = array (
        'Speech' => 'ChronicleSpeech',
        'Images' => 'SharedImage',
    );

    private static $default_sort = "\"SortOrder\" ASC";

    public function getTitle() {
        return $this->Name;
    }

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_CHRONICLE')) ? true : false;}
    function canView($Member = null) {return true;}
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if ($fields->dataFieldByName('Speech')) {
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig = $fields->dataFieldByName('Speech')->getConfig();
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $fields->dataFieldByName('Speech')->setConfig($gridFieldConfig);
        }
        if ($fields->dataFieldByName('Images')) {
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig = $fields->dataFieldByName('Images')->getConfig();
            $bulkUpload = new GridFieldBulkUpload();
            $bulkUpload->setUfSetup('setFolderName', 'page-elements/' . SiteConfig::current_site_config()->Title . '/' . $this->Name);
            $gridFieldConfig->addComponent($bulkUpload);
            $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
            $fields->dataFieldByName('Images')->setConfig($gridFieldConfig);
        }
        return $fields;
    }
}
