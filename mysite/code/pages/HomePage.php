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
class HomePage_Controller  extends ContentController {

    static $allowed_actions = array(

    );

    public function subSiteListMenu() {

        return DataObject::get('Subsite', "", "ID ASC");
    }

    public function allNews() {
        $allEntries = NewsHolderPage::get()->first()->Newsitems()->limit(7);
        return $allEntries;
    }

    public function OrbitNews() {
        return DataObject::get('News', '"News"."ShowInCarousel" = 1 AND "News"."ImpressionID" <> 0', 'Created ASC', '')->limit(5);
    }

    public function LastArts() {
        /**
         * @var GalleryPage $page
         */
        $page = GalleryPage::get()->first();
        return $page->GalleryImages()->limit(8);
    }
}
