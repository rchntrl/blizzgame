<?php

/**
 * Class Page
 *
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

class Page_Controller extends ContentController {

    private static $allowed_actions = array (
    );

    public function subSiteListMenu() {
        return DataObject::get('Subsite');
    }

    public function init() {
        parent::init();
        Requirements::javascript($this->ThemeDir() .  'bower_components/jquery/dist/jquery.min.js');

        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
    }
}
