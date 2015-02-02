<?php

/**
 * Class Page
 *
 * Subsite Extension method:
 * @method string alternateAbsoluteLink
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
}

/**
 * Class Page_Controller
 *
 * @method string MenuTitle
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
