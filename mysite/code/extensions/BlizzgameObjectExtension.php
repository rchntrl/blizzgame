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
            try {
                $urlPrefix = $this->owner->getURLPrefix();
            } catch(\Exception $ex) {
            }
            $linkField->setURLPrefix($urlPrefix);
            $fields->replaceField('LastLinkSegment', $linkField);
        }
        if ($this->owner instanceof Image) {
            /** @var GalleryImage $image */
            if ($image = GalleryImage::get_one('GalleryImage', '"GalleryImage"."ImageID" = ' . $this->owner->ID)) {
               $fields->addFieldToTab('Root.Main', new LiteralField(
                   'UsedInGallery',
                   SSViewer::execute_template('UsedInGallery', $image)
               ));
            }
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
                $url = $this->owner->TitleEN ?: $this->owner->Title;
                $this->owner->LastLinkSegment = singleton('SiteTree')->generateURLSegment($url);
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
     * @return Image
     */
    public function bookView() {
        if (!$this->owner instanceof Image) {
            throw new InvalidArgumentException(sprintf(
                'BlizzGameObjectExtension: Record of type %s does not extend Image',
                get_class($this->owner)
            ));
        }
        return $this->owner->CroppedImage(300, 462);
    }

    /**
     * @return Image
     */
    public function albumView() {
        if (!$this->owner instanceof Image) {
            throw new InvalidArgumentException(sprintf(
                'BlizzGameObjectExtension: Record of type %s does not extend Image',
                get_class($this->owner)
            ));
        }
        return $this->owner->CroppedImage(360, 250);
    }

    /**
     * @link http://www.silverstripe.org/community/forums/data-model-questions/show/6568
     * Convert this object to a JSON string. It will includes all the has_one objects recursively.
     * TODO: Including default values ???
     * @return string The data as a JSON string.
     */
    public function toJSON() {
        $array = array();
        foreach($this->owner->has_one() as $relationship => $class) {
            if (ClassInfo::exists($class)) {
                $component = $this->owner->getComponent($relationship);
                $array[$relationship] = $component->exists() ? $this->owner->obj($relationship)->toJSON() : null;
            }
        }
        $array = array_merge($array, $this->owner->toMap());
        return $array;
    }
}
