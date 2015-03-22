<?php

/**
 * Class ChroniclePage
 *
 * @method SS_List ChronicleItems
 */
class ChroniclePage extends Page {

    static $has_many = array (
        'ChronicleItems' => 'ChronicleItem'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        //$gridFieldConfig->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
        $gridFieldConfig->addComponent(new GridFieldOrderableRows('NumberSort'));
        $gridFieldConfig->addComponent(new GridFieldAddExistingSearchButton());
        $gridField = new GridField("ChronicleItems", _t("ChronicleItem.MULTIPLE_CMS_TITLE", "Chronicle Items"), $this->ChronicleItems(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');

        return $fields;
    }
}


class ChroniclePage_Controller extends Page_Controller {

    static $allowed_actions = array(
        'view',
    );

    static $url_handlers = array(
        '$ID!' => 'view',
    );

    public function view() {
        $face = ChronicleItem::get_by_url($this->urlParams['ID']);
        if (!$face) {
            $this->httpError(404);
        }

        $ssv = new SSViewer('Page');
        $ssv->setTemplateFile('Layout', 'ChronicleItem');
        return $this->customise($face)->renderWith($ssv);
    }
}
