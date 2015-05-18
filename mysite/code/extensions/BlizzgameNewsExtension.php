<?php

/**
 * Class BlizzgameNewsExtension
 *
 */
class BlizzgameNewsExtension extends DataExtension {

    private static $db = array(
        'ShowInCarousel' => "Boolean"
    );

    private static $has_one = array(
        'HolderPage' => 'NewsHolderPage'
    );

    public function HolderPage() {
        return $this->owner->HolderPage;
    }

    public function onBeforeWrite() {
        $this->owner->HolderPage = $this->owner->HolderPage ?: NewsHolderPage::get()->first();
        $this->owner->ShowInCarousel = $this->owner->ShowInCarousels ? $this->owner->ImpressionID <> 0 : false;
        /** @var News $news */
        $news = $this->owner;
        $page = SiteTree::get_by_id("NewsHolderPage", 1640);
        $this->owner->NewsHolderPages()->add($page);
        $page = null;
        foreach ($news->Tags() as $tag) {
            switch ($tag->Title) {
                case 'warcraft':
                    $page = SiteTree::get_by_id("NewsHolderPage", 1519);
                    break;
                case 'diablo':
                    $page = SiteTree::get_by_id("NewsHolderPage", 1639);
                    break;
                case 'starcraft':
                    $page = SiteTree::get_by_id("NewsHolderPage", 1522);
                    break;
            }
            if ($page) {
                $news->NewsHolderPages()->add($page);
                $page = null;
            }
        }
    }

    public function alternateAbsoluteLink() {
        if ($this->owner->Type == 'external') {
            return $this->owner->External;
        } elseif ($this->owner->Type == 'download') {
            return $this->owner->Download->Link;
        }
        return $this->owner->HolderPage()->alternateAbsoluteLink() . 'show/' . $this->owner->URLSegment;
    }

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new CheckboxField('ShowInCarousels', 'Show In Carousel', $this->owner->ShowInCarousel));
    }

    /**
     * @param int $maxDepth
     * @param bool $unlinked
     * @param bool $stopAtPageType
     * @param bool $showHidden
     * @return HTMLText
     */
    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        $pages = array();
        /** @var DataObject|null $object */
        $object = $this->owner;
        while($object instanceof DataObject) {
            $pages[] = $object;
            $object = method_exists(get_class($object), 'getParent') ? $object->getParent() : null;
        }
        /** @var Page_Controller $page */
        $page = $this->owner->HolderPage();
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
        $template = new SSViewer('BreadcrumbsTemplate');

        return $template->process($originalPage->customise(new ArrayData(array(
            'Pages' => new ArrayList(array_reverse($pages))
        ))));
    }
}
