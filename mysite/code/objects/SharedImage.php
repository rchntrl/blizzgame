<?php

/**
 * Class SharedImage
 *
 */
class SharedImage extends DataObject {

    private static $db = array(
        'External' => 'Varchar'
    );

    private static $has_one = array(
        'Image' => 'Image',
        'PageElement' => 'PageElement',
    );

    private static $summary_fields = array(
    );

    private static $default_sort = array(
    );

    public static $field_labels = array(
    );
}
