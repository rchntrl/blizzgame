<?php

/**
 * Class ChronicleItem
 *
 * @method ChroniclePage HolderPage
 */
class ChronicleItem extends DataObject {

    static $db = array (
        'Title' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar',
        'Content' => 'HTMLText',
        'ShortText' => 'Text',
        'NumberSort' => 'Int',
        //'ProvideComments' => "Int(1)",
        'Races' => 'Varchar(255)',
        'Fractions' => 'Varchar(255)',
        'Heroes' => 'Varchar(255)',
        'Places' => 'Varchar(255)',
        'Monsters' => 'Varchar(255)',
        'Items' => 'Varchar(255)',
    );

    static $has_one = array (
        'HolderPage' => 'ChroniclePage'
    );

    static $default_sort = 'NumberSort ASC';

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'Fractions', 'Races', 'Heroes',
            'Monsters', 'Places', 'Items',
            'HolderPageID'
        ));
        $fields->addFieldsToTab('Root', $this->getElementLinksTab());
        return $fields;
    }

    protected function getElementLinksTab() {
        return Tab::create(
            'Tags',
            _t('Book.TAGSTAB', 'Тэги'),
            ElementLink::getMultipleField('Fractions', 'Фракции', ElementLink::FRACTIONS),
            ElementLink::getMultipleField('Races', 'Расы', ElementLink::RACES),
            ElementLink::getMultipleField('Heroes', 'Персонажи', ElementLink::HEROES),
            ElementLink::getMultipleField('Monsters', 'Бестиарий', ElementLink::MONSTERS),
            ElementLink::getMultipleField('Places', 'Места', ElementLink::PLACES),
            ElementLink::getMultipleField('Items', 'Предметы и артефакты', ElementLink::ITEMS)
        );
    }

    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }
}
