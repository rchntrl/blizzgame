<?php

/**
 * Class BlizzgameNewsExtension
 *
 */
class BlizzgameNewsExtension extends DataExtension {

    static $db = array(
        'ShowInCarousel' => "Boolean"
    );

    static $has_one = array(
        'HolderPage' => 'NewsHolderPage'
    );

    public function onBeforeWrite() {
        $this->owner->HolderPage = $this->owner->HolderPage ?: NewsHolderPage::get()->first();
        $this->owner->ShowInCarousel = $this->owner->ShowInCarousels ? $this->owner->ImpressionID <> 0 : false;
    }

    public function alternateAbsoluteLink() {
        return $this->owner->HolderPage()->alternateAbsoluteLink() . 'show/' . $this->owner->URLSegment;
    }

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new CheckboxField('ShowInCarousels', 'Show In Carousel', $this->owner->ShowInCarousel));
    }
}
