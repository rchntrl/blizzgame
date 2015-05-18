<?php

/**
 * Class CalendarRelease
 *
 * @property Date Created
 * @property Date LastEdited
 * @property Date Date
 * @property Date DateEnd
 * @property Int Year
 */
class CalendarRelease extends DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Date' => 'Date',
        'DateEnd' => 'Date',
        'LinkTo' => 'Varchar(255)',
        'Year' => 'Int',
        'Type' => "Enum('Product,Event','Product')",
    );

    private static $default_sort = 'Date DESC';

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        $this->Year = $this->Date->Year();
    }

    function IsProduct() {
        return ('Product' == $this->Type) ? true : false;
    }

    function IsToday() {
        return $this->Date->IsToday();
    }

    function inFuture() {
        return $this->Date->InFuture();
    }

    function DateCheckNew() {
        return (
            mktime(0, 0, 0, date('m', strtotime($this->Created)), $this->Created->DayOfMonth(), $this->Created->Year())
            >=
            mktime(0, 0, 0, date("m"), date("d") - 3, date("Y"))
        ) ? true : false;
    }

    function DateCheckUpdate() {
        return (
            !$this->DateCheckNew() &&
            mktime(0, 0, 0, date('m', strtotime($this->LastEdited)), $this->LastEdited->DayOfMonth(), $this->LastEdited->Year())
            >= mktime(0, 0, 0, date("m"), date("d") - 3, date("Y"))
        ) ? true : false;
    }
}
