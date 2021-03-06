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

    /**
     * @return bool|Image
     */
    function Icon() {
        /** @var ElementLink $tag */
        $tag = DataObject::get_one('ElementLink', 'ElementLink.LinkToPageID = ' . Convert::raw2sql($this->ID));
        return $tag ? $tag->Icon() : SiteConfig::current_site_config()->DefaultElementImage();
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

    /**
     * @param int $numWords
     * @param string $add
     * @return string
     */
    public function Summary($numWords = 26, $add = '...') {
        $content = Convert::html2raw($this->Content);
        $summary = explode(' ', $content, $numWords + 1);
        if(count($summary) <= $numWords - 1) {
            $summary = $content;
        } else {
            array_pop($summary);
            $summary = implode(' ', $summary) . $add;
        }
        return $summary;
    }

    public function isNew() {
        $now = SS_Datetime::now();
        $d1 = mktime(0, 0, 0, date('m', strtotime($this->LastEdited)), $now->DayOfMonth(), $now->Year());
        $d2 = mktime(0, 0, 0, date("m"), date("d") - 3, date("Y"));
        return ($d1 >= $d2) ? true : false;
    }

    public function breadcrumbsJSON($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        return htmlspecialchars(Convert::array2json($this->breadcrumbsMap($maxDepth, $unlinked, $stopAtPageType, $showHidden)));
    }

    public function breadcrumbsMap($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        $pages = array();
        $page = $this;
        $originalPage = $page;
        while(
            $page
            && (!$maxDepth || count($pages) < $maxDepth)
            && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
        ) {
            if($showHidden || $page->ShowInMenus || ($page->ID == $originalPage->ID)) {
                $pages[] = $page;
            }
            $page = $page->Parent;
        }
        $crumbs = [];
        /** @var SiteTree $crumb */
        foreach ($pages as $crumb) {
            $crumbs[] = array(
                'Title' => $crumb->Title,
                'Link' => $crumb->Link(),
                'Self' => $crumb->ID != $this->ID
            );
        }
        $crumbs[] = array(
            'Title' => SiteConfig::current_site_config()->Title,
            'Link' => Director::absoluteBaseURL(),
            'Self' => true,
        );
        return array_reverse($crumbs);
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
 * @method Browser getBrowser
 */
class Page_Controller extends ContentController {

    private static $allowed_actions = array (
    );

    public function subSiteListMenu() {
        return DataObject::get('Subsite', "", "ID ASC");
    }

    protected function metaTags() {
        return array(
            'metaDescription' => $this->MetaDescription,
            'metaKeywords' => $this->MetaKeywords,
            'title' => $this->MenuTitle(),
        );
    }

    public function init() {
        parent::init();
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/jquery/dist/jquery.min.js');
        Requirements::javascript(THEMES_DIR . '/foundation/bower_components/modernizr/modernizr.js');
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/foundation/js/foundation.min.js');
        Requirements::javascript(THEMES_DIR. '/foundation/bower_components/foundation/js/foundation/foundation.topbar.js');
        Requirements::javascript(THEMES_DIR. '/foundation/javascript/app.js');
        Requirements::javascript(THEMES_DIR. '/foundation/javascript/init.js');
    }

    /**
     * @return bool
     */
    public function angularSupport() {
        if ($this->getBrowser()->getName() == 'ie') {
            return $this->getBrowser()->getVersion() > 8.0;
        }
        if ($this->getBrowser()->getName() == 'opera') {
            return $this->getBrowser()->getVersion() >= 15;
        }

        return true;
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
