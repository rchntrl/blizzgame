<?php

/**
 * Class AttachedImageChapter
 */
class AttachedImageChapter extends Image {

    static $has_one = array (
        'Chapter' => 'Chapter'
    );

    function needResizePhoto($size) {
        return ($size < $this->getWidth()) ? true : false;
    }
}

/**
 * Class AttachedImageChapter
 *
 * @method Book Book()
 */
class Chapter extends DataObject
{
    static $db = array (
        'Title' => 'Varchar(255)',
        'Content' => 'HtmlText',
        'NumberSort' => 'Int'
    );

    static $has_one = array (
        'Book' => 'Book'
    );

    /*
    static $has_many = array (
        'AttachedImage' => 'AttachedImageChapter'
    );
    */

    public function Link() {
        return $this->Book()->lastLinkSegment . 'translate/' . $this->ID . '/';
    }

    public function LinkOrCurrent() {
        return ($_GET['url'] == $this->Link()) ? 'current' : 'link';
    }
}
