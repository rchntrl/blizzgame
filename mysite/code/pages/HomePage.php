<?php

/**
 * Class HomePage
 *
 */
class HomePage extends SiteTree {

    private static $db = array(
    );

    private static $has_one = array(
    );
}

/**
 *
 * Class HomePage_Controller
 */
class HomePage_Controller  extends ContentController {

    static $allowed_actions = array(

    );

    public function subSiteListMenu() {

        return DataObject::get('Subsite', "", "ID ASC");
    }

    public function allNews() {
        $allEntries = News::get()->limit(10);
        return $allEntries;
    }
}
