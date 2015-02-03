<?php

/**
 * Class Page
 *
 * Subsite Extension method:
 * @method string alternatePreviewLink
 */
class Page extends SiteTree {

    private static $db = array(
    );

    private static $has_one = array(
    );

    function Icon() {
        /** @var ElementLink $tag */
        $tag = DataObject::get_one('ElementLink', 'ElementLink.LinkToPageID = ' . Convert::raw2sql($this->ID));
        return $tag ? $tag->Icon() : false;
    }

    function alternateAbsoluteLink() {
        // Generate the existing absolute URL and replace the domain with the subsite domain.
        // This helps deal with Link() returning an absolute URL.
        $url = Director::absoluteURL($this->owner->Link());
        if($this->SubsiteID > 0) {
            $url = preg_replace('/\/\/[^\/]+\//', '//' .  $this->owner->Subsite()->domain() . '/', $url);
        } else {
            $url = preg_replace('/\/\/[^\/]+\//', '//' .  'www.blizzgame.ru' . '/', $url);
        }
        return $url;
    }
}

/**
 * Class Page_Controller
 *
 * @method string MenuTitle
 * @method static getFacebookLoginLink
 * @method  string getFacebookAppId
 * @method  mixed getFacebookSession
 * @method  getFacebookCallbackLink
 */
class Page_Controller extends ContentController {

    private static $allowed_actions = array (
    );

    public function subSiteListMenu() {
        return DataObject::get('Subsite', "", "ID ASC");
    }

    public function ajaxTitle() {
        return $this->MenuTitle();
    }

    public function init() {
        parent::init();
        Requirements::javascript($this->ThemeDir() .  'js/jquery.min.js');
    }
}
