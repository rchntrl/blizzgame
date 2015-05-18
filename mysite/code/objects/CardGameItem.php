<?php

/**
 * Class CardGameItem
 *
 * @property String TitleEN
 * @property String TitleRU
 * @method Image CoverCard
 * @method CardGamePage HolderPage
 */
class CardGameItem extends DataObject {

    private static $db = array(
        'TitleEN' => 'Varchar',
        'TitleRU' => 'Varchar',
        'Order' => 'Int',
        'Hearthstone' => 'Boolean',
        /*'Rarity' => "Enum('Обычные,Необычные,Редкие,Эпические,Легендарные')",
        'Type' => "Enum('None,Босс,Броня,Задание,Герой,Главный герой,Способность,Союзник,Предмет,Оружие,Местность','None')",
        'Faction' => "Enum('None,Альянс,Орда,Серебряный Авангард,Нейтральный,Плеть,Монстры','Нейтральный')",
        'Race' => "Varchar(255)",
        'Class' => "Varchar(255)",
        'Profession' => "Varchar(255)",
        'Talent' => "Varchar(255)",
        'Rules' => 'HTMLText',
        'Flavor' => 'HTMLText',
        'Cost' => 'Int',
        'StrikeCost' => 'Int',
        'Health' => 'Int',
        'ATK' => 'Int',
        'ATKType' => "Enum('None,Урон от ближнего боя,Урон от дальнего боя,Магический,Огненный,Природный,Святой,Ледяной,Теневой','None')",
        'Defence' => 'Int',
        'Artist' => "Varchar(255)",
        'LootCard' =>  "HTMLText",
        'SetName' =>  "Varchar(255)",
        'Tags' => "Varchar(255)",
        'ClassRestriction' => "Varchar(255)",*/
    );

    private static $has_one = array (
        'LinkToArt' => 'GalleryImage',
        'HolderPage' => 'CardGamePage',
        'CoverCard' => 'Image',
        'PromoCard' => 'Image',
    );

    private static $summary_fields = array(
        'TitleEN', 'TitleRU', 'Thumbnail'
    );

    public function getThumbnail() {
        return $this->CoverCard()->CMSThumbnail();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'Race', 'Class', 'Profession', 'Faction', 'Artist',
            'LinkToArt', 'HolderPage',
        ));

        $fields->replaceField('CoverCard', $this->getUploadField('CoverCard'));
        $fields->replaceField('PromoCard', $this->getUploadField('PromoCard'));

        return $fields;
    }

    /**
     * @param $name
     * @param string $title
     * @param string $folderName
     * @return UploadField
     */
    protected function getUploadField($name, $title = null) {
        $field = new UploadField($name, $title);
        $field->setFolderName('CardGame/' . $this->HolderPage()->MenuTitle);
        return $field;
    }
}
