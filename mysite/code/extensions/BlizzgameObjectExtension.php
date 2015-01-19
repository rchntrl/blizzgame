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
    }

    public function onBeforeWrite() {
        if ($this->owner->hasField('LastLinkSegment')) {
            if (empty($this->owner->LastLinkSegment)) {
                $this->owner->LastLinkSegment = singleton('SiteTree')->generateURLSegment($this->owner->TitleEN);
            }
        }
    }
}
