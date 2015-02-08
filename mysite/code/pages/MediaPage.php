<?php

/***
 * Class MediaPage
 * @method SS_List MediaItems
 */
class MediaPage extends Page {

    static $has_many = array (
        'MediaItems' => 'Media'
    );

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
class MediaPage_Controller extends Page_Controller {

    static $allowed_actions = array(
        'view',
    );

    static $url_handlers = array(
        '$ID!' => 'view',
    );

    public function view() {
        $media = Media::get_by_url($this->urlParams['ID']);
        if (!$media) {
            $this->httpError(404);
        }

        $ssv = new SSViewer('Page');
        $ssv->setTemplateFile('Layout', 'Media');
        return $this->customise($media)->renderWith($ssv);
    }
}
