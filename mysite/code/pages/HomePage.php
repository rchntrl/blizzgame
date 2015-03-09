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

    static $allowed_actions = array(

    );

    public function init() {
        parent::init();
        if (Member::currentUser() && !Member::currentUser()->Nickname) {
            $this->redirect('http://www.blizzgame.ru/forummemberprofile/edit/' . Member::currentUserID());
        }
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
