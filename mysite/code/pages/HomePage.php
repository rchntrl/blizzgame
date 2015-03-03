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
        //return DataObject::get('News', '"News"."NewsHolderPageID" = ' . $this->New .' AND "News"."ShowInCarousel" = 1 AND "News"."ImpressionID" <> 0', 'Created ASC', '')->limit(5);
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
