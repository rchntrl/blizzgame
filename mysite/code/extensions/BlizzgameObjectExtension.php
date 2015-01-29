<?php

/**
 * Class BlizzgameObjectExtension
 */
class BlizzgameObjectExtension extends DataExtension {

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        if ($this->owner->hasField('TitleEN')) {
            $fields->dataFieldByName('TitleEN')->setTitle(_t('BlizzgameObject.TitleEN', 'Название (анг)'));
            $fields->dataFieldByName('TitleRU')->setTitle(_t('BlizzgameObject.TitleRU', 'Название (рус)'));
        }
        if ($this->owner->hasField('LastLinkSegment')) {
            $linkField = new SiteTreeURLSegmentField('LastLinkSegment', 'URL Link');
            $urlPrefix = '/';
            if (method_exists(get_class($this->owner), 'getURLPrefix')) {
                $urlPrefix = $this->owner->getURLPrefix();
            }
            $linkField->setURLPrefix($urlPrefix);
            $fields->replaceField('LastLinkSegment', $linkField);
        }
    }

    public function updateFieldLabels(&$labels) {
        if ($this->owner->hasField('TitleEN')) {
            $labels['TitleEN'] = _t('BlizzgameObject.TitleEN', 'Название (анг)');
            $labels['TitleRU'] = _t('BlizzgameObject.TitleRU', 'Название (рус)');
        }
    }

    public function onBeforeWrite() {
        if ($this->owner->hasField('LastLinkSegment')) {
            if (empty($this->owner->LastLinkSegment)) {
                $this->owner->LastLinkSegment = singleton('SiteTree')->generateURLSegment($this->owner->TitleEN);
            }
        }
    }

    public function MenuTitle() {
        if ($this->owner->hasField('TitleRU')) {
            return $this->owner->getField('TitleRU');
        }
        return $this->owner->getTitle();
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
