<?php

/**
 * Class BlizzgameNewsExtension
 *
 */
class BlizzgameNewsExtension extends DataExtension {

    static $has_one = array(
        'HolderPage' => 'NewsHolderPage'
    );

    public function onBeforeWrite() {
        $this->owner->HolderPage = NewsHolderPage::get()->first();
    }

    public function alternateAbsoluteLink() {
        return $this->owner->HolderPage()->alternateAbsoluteLink() . 'show/' . $this->owner->URLSegment;
    }
}
