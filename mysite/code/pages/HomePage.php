<?php

/**
 * Class HomePage
 *
 */
class HomePage extends SiteTree {

}

/**
 *
 * Class HomePage_Controller
 */
class HomePage_Controller  extends Page_Controller {

    private static $allowed_actions = array(

    );

    public function init() {
        parent::init();
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/jquery/dist/jquery.min.js');
        Requirements::javascript(THEMES_DIR . '/foundation/bower_components/foundation/modernizr/modernizr.js');
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/foundation/js/foundation.min.js');
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/foundation/js/foundation/foundation.topbar.js');
        Requirements::javascript(THEMES_DIR. '/foundation/javascript/app.js');
        Requirements::javascript(THEMES_DIR. '/foundation/javascript/init.js');
    }

    public function subSiteListMenu() {

        return DataObject::get('Subsite', "", "ID ASC");
    }

    public function allNews() {
        $filter = array(
            'Live' => 1,
        );
        $exclude = array(
            'PublishFrom:GreaterThan' => SS_Datetime::now()->Format('Y-m-d'),
        );
        /** @var DataList $allEntries */
        $allEntries = NewsHolderPage::get_one("NewsHolderPage")->Newsitems()
            ->limit(10)
            ->filter($filter)
            ->exclude($exclude)
        ;
        return $allEntries;
    }

    public function OrbitNews() {
        $filter = array(
            'Live' => 1,
            'ShowInCarousel' => 1
        );
        $exclude = array(
            'PublishFrom:GreaterThan' => SS_Datetime::now()->Format('Y-m-d'),
            'ImpressionID' => 0
        );
        /** @var DataList $allEntries */
        $allEntries = NewsHolderPage::get_one("NewsHolderPage")->Newsitems()
            ->limit(10)
            ->filter($filter)
            ->exclude($exclude)
        ;
        return $allEntries;
    }

    public function LastArts() {
        /**
         * @var GalleryPage $page
         */
        $page = GalleryPage::get()->first();
        return $page->GalleryImages()->limit(6);
    }
}
