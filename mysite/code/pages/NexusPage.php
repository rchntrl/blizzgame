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
        Requirements::themedCSS('nexus');
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular/angular.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-resource/angular-resource.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-route/angular-route.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation.min.js");
        //Requirements::javascript(THEMES_DIR . "/foundation/bower_components/angular-foundation/mm-foundation-tpls.min.js");
        Requirements::javascript(THEMES_DIR . "/foundation/javascript/nexus.js");
    }
}
