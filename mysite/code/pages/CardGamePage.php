<?php

/**
 * Class CardGamePage
 *
 * @method HasManyList Items()
 */
class CardGamePage extends Page {
    
    private static $has_many = array(
        'Items' => 'CardGameItem'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
        $gridFieldConfig->addComponent(new GridFieldOrderableRows('Order'));
        $gridField = new GridField('Cards', _t('CardGame.CARDGAME_CMS_TITLE', 'Cards'), $this->Items(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');
        return $fields;
    }
}

class CardGamePage_Controller extends Page_Controller {

    private static $allowed_actions = array(
        'view',
        'ng',
    );

    private static $url_handlers = array(
        'ng/$ID!' => 'ng',
        '$ID!' => 'view',
    );

    public function init() {
        parent::init();
        Requirements::themedCSS('card-game');
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular/angular.min.js");
        Requirements::javascript("https://code.angularjs.org/1.2.20/angular-route.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation-tpls.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/javascript/cardgame.js");
    }

    public function ng() {
        $action = $this->urlParams['ID'];
        switch ($action) {
            case 'card-list':
                break;
            case 'template':
                $id = $this->request->getVar('ID');
                $this->response->setBody($this->renderWith($id));
                break;
            case 'update':
                $items = CardGameItem::get("CardGameItem", "DAY(NOW()) > DAY(CardGameItem.LastEdited)")->limit(15);
                /** @var CardGameItem $item */
                foreach($items as $item) {
                    $item->write();
                }
                $this->response->setBody(json_encode(
                    array('count' => CardGameItem::get("CardGameItem", "DAY(NOW()) > DAY(CardGameItem.LastEdited)")->count())
                ));
                break;
        }
        //$this->response->addHeader("Content-Type", "application/json");
        return $this->getResponse();
    }
}
