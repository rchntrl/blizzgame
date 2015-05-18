<?php

/**
 * Class CardGamePage
 *
 * @method SS_List Items()
 */
class CardGamePage extends Page {
    
    private static $has_many = array(
        'Items' => 'CardGameItem'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
        $gridField = new GridField('Cards', _t('CardGame.CARDGAME_CMS_TITLE', 'Cards'), $this->Items(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');
        return $fields;
    }
}

class CardGamePage_Controller extends Page_Controller {


}
