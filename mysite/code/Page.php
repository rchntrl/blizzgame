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
        return preg_replace('/blizzgame\/|index.php\//', '', $url);
    }

    public function LatestMembers() {
        return Member::get_one('Member', '', true, 'ID DESC');
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
        if (Member::currentUser() && !Member::currentUser()->Nickname) {
            $this->redirect('http://www.blizzgame.ru/forummemberprofile/edit/' . Member::currentUserID());
        }
    }

    public function isForumBreadcrumbs($text) {
        return preg_match('/»/', $text);
    }
    /**
     * @param $text
     * @return array
     */
    public function fixForumBreadcrumb($text) {
        $pages = new ArrayList();
        foreach (explode("» ", $text) as $val) {
            if ($val != ' ') {
                $pages->push(new ArrayData(array('Text' => $val)));
            }
        }
        return $pages;
    }

    /**
     * @param DataObject $object
     * @param string $template
     * @param string $layout
     * @return HTMLText
     */
    public function renderDataObject(DataObject $object, $template, $layout = null) {
        $ssv = new SSViewer($template);
        if (!$layout) {
            $layout = get_class($object);
        }
        $ssv->setTemplateFile('Layout', $layout);
        return $this->customise($object)->renderWith($ssv);
    }
}
