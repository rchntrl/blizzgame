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
        Requirements::javascript(THEMES_DIR . '/foundation/bower_components/foundation/modernizr/modernizr.js');
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

        if (!Member::currentUser()) {
            return permission::check('EDIT_GALLERY') ? true : false;
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
