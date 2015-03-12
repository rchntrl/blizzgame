<?php

/***
 * Class MediaPage
 * @method SS_List MediaItems
 */
class MediaPage extends Page {

    static $has_many = array (
        'MediaItems' => 'Media'
    );

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_MEDIA')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_MEDIA')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_MEDIA')) ? true : false;}

    /**
     * @return PageConfig
     */
    public function getPageConfig() {
        return PageConfig::get_one('PageConfig', '"PageConfig"."UsedByID" = ' . $this->ID);
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridField = new GridField("MediaItems", _t("Media.MULTIPLE_CMS_TITLE", "Media"), $this->MediaItems(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');

        return $fields;
    }
}

/**
 * Class MediaPage_Controller
 */
class MediaPage_Controller extends Page_Controller
{

    static $allowed_actions = array(
        'view',
    );

    static $url_handlers = array(
        '$ID!' => 'view',
    );

    public function view()
    {
        $media = Media::get_by_url($this->urlParams['ID']);
        if (!$media) {
            $this->httpError(404);
        }

        return $this->renderDataObject($media, 'Page', 'Media');
    }

    /**
     * @param int $itemsPerPage
     * @param SQLQuery|null $query
     * @return null|PaginatedList
     */
    public function getPaginatedPages($itemsPerPage = 12)
    {
        $pages = new PaginatedList($this->MediaItems(), $this->request);
        $pages->setLimitItems($itemsPerPage);
        return $pages;
    }
}
