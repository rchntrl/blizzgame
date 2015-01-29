<?php

trait LastLinkSegmentProvider {
    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }

    /**
     * @return String
     */
    public function getURLPrefix() {
        return '/';
    }

    public function getPageHolder() {

    }
}
