<?php

class NexusPage extends Page {

}

class NexusPage_Controller extends Page_Controller {
    private static $allowed_actions = array(
        'view',
    );

    private static $url_handlers = array(
        '$ID!' => 'view',
    );

    public function init() {
        parent::init();
        Requirements::themedCSS('hots');
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular/angular.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-resource/angular-resource.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-route/angular-route.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation-tpls.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/javascript/jquery.scrollTo.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/javascript/jquery.localScroll.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/javascript/nexus.js");
    }

    public function view() {
        /** @var StormHero $object */
        $object = null;
        if($this->urlParams['ID']) {
            $id = $this->urlParams['ID'];
            if (is_numeric($id)) {
                $object = DataObject::get_by_id("StormHero", $id);
            } else {
                $object = DataObject::get_one('StormHero', "\"StormHero\".\"LastLinkSegment\" = '" . $id ."'");
            }

            if (!$object->ID) {
                $this->httpError(404);
            }
        } else {
            $this->httpError(404);
        }
        return $this->customise(array(
            // Title будет хранить название страницы,а не объекта. Эта хитрость нужна для маршрутизации angular
            'MetaTitle' => $object->getTitle(),
            'MetaDescription' => $object->getMetaDescription(),
            'Hero' => $object,
        ));
    }

    public function Heroes() {
        return StormHero::get()->filter(array('Draft' => false))->sort('TitleRU');
    }
}
