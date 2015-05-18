<?php

/**
 * Class ObjectAsPageExtension
 *
 * Don't use for children objects of the object which already use this extension
 */
class ObjectAsPageExtension extends DataExtension {

    /**
     * @return string
     */
    public function Link() {
        return $this->owner->HolderPage()->Link() . $this->owner->LastLinkSegment;
    }

    public function AbsoluteLink() {
        return $this->owner->HolderPage()->alternateAbsoluteLink() . $this->owner->LastLinkSegment;
    }

    public function alternateAbsoluteLink() {
        return $this->owner->HolderPage()->alternateAbsoluteLink() . $this->owner->LastLinkSegment;
    }

    public function toMap() {
        $map = $this->getOwner()->toMap();
        $map['Link'] = $this->Link();
        return $map;
    }

    /**
     * @return String
     */
    public function getURLPrefix() {
        return $this->owner->HolderPage()->alternateAbsoluteLink();
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
