<?php

/**
 * Class CardGamePage
 *
 * @method HasManyList Items()
 */
class CardGamePage extends Page {

    private static $has_one = array(
        'Image' => 'Image',
    );

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
        $uploadField = new UploadField('Image', 'Image');
        $uploadField->setFolderName('CardGame/' . $this->URLSegment);
        $fields->addFieldToTab('Root.Main', $uploadField, 'Cards');
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
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-resource/angular-resource.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-new-router/dist/router.es5.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation-tpls.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/javascript/cardgame.js");
    }

   public function view() {
       /** @var CardGameItem $object */
        $object = null;
        if($this->urlParams['ID']) {
            $id = $this->urlParams['ID'];
            if (is_numeric($id)) {
                $object = DataObject::get_by_id("CardGameItem", $id);
            } else {
                $object = DataObject::get_one('CardGameItem', "\"CardGameItem\".\"LastLinkSegment\" = '" . $id ."'");
            }

            if (!$object->ID) {
                $this->httpError(404);
            }
        } else {
            $this->httpError(404);
        }

        return $this->customise(array(
            'MetaTitle' => $object->getTitle(),
            'MetaDescription' => $object->getMetaDescription(),
        ));
   }
}
