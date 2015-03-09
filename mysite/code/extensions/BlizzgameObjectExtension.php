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
        return $this->owner->CroppedImage(240, 370);
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
}
