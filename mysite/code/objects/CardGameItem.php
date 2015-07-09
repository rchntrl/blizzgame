<?php

/**
 * Class CardGameItem
 *
 * @property String TitleEN
 * @property String TitleRU
 * @property String CoverThumbnail
 * @property String PromoThumbnail
 * @method Image CoverCard
 * @method Image PromoCard
 * @method CardGamePage HolderPage
 * @method GalleryImage LinkToArt
 * @method PeopleFace Artist
 */
class CardGameItem extends DataObject implements PermissionProvider {

    private static  $singular_name = 'Game Card';

    private static  $plural_name = 'Game Cards';

    private static $db = array(
        'TitleEN' => 'Varchar',
        'TitleRU' => 'Varchar',
        'Order' => 'Int',
        'LastLinkSegment' => 'Varchar(255)',
        'Hearthstone' => 'Boolean',
        'Rules' => 'HTMLText', //
        'Flavor' => 'HTMLText', // Особенность
        'Comment' =>  "HTMLText",
        'Rarity' => "Enum('None, Free, Common, Uncommon, Rare, Epic, Legendary')",
        'Type' => "Enum('None, Ally, Armor, Boss, Hero, Item, Location, Main Hero, Quest, Spell, Weapon')",
        'Faction' => "Enum('None, Alliance, Horde, Neutral, Monster')",
        'Class' => "Enum('None, Warrior, Druid, Priest, Mage, Monk, Hunter, Paladin, Rogue, Death Knight, Warlock, Shaman')",
        'StrikeCost' => 'Int',
        'Cost' => 'Int',
        'Attack' => 'Int',
        'Health' => 'Int',
        'Defense' => 'Int',
        'Set' =>  "Varchar(255)",
        'CoverThumbnail' => "Varchar(255)",
        'PromoThumbnail' => "Varchar(255)",
    );

    private static $indexes = array(
        'ID_UniqueLastLinkSegment' => array(
            'type' => 'unique',
            'value' => 'LastLinkSegment'
        ),
        'Class' => true,
    );

    private static $has_one = array (
        'LinkToArt' => 'GalleryImage',
        'HolderPage' => 'CardGamePage',
        'CoverCard' => 'Image',
        'PromoCard' => 'Image',
        'Artist' => 'PeopleFace'
    );

    private static $summary_fields = array(
        'TitleEN', 'TitleRU', 'Thumbnail'
    );

    public function providePermissions() {
        return array(
            'CREATE_EDIT_CARD' => array(
                'name' => _t('StormHero.PERMISSION_CREATE_EDIT_DESCRIPTION', 'Create Card'),
                'category' => _t('Permissions.BLIZZGAME_CARDS', 'BlizzGame Cards'),
                'help' => _t('StormHero.PERMISSION_CREATE_EDIT_HELP', 'Permission required to create new card.')
            ),
            'DELETE_CARD' => array(
                'name' => _t('StormHero.PERMISSION_DELETE_DESCRIPTION', 'Edit Card'),
                'category' => _t('Permissions.BLIZZGAME_CARDS', 'BlizzGame Cards'),
                'help' => _t('StormHero.PERMISSION_DELETE_HELP', 'Permission required to delete existing card.')
            ),
        );
    }

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_CARD')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('EDIT_CARD')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_CARD')) ? true : false;}
    function canView($Member = null) {return true;}

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }

    public function getThumbnail() {
        return $this->CoverCard()->CMSThumbnail();
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        $this->CoverThumbnail = $this->CoverCard()->CroppedImage(240, 370)->getURL();
        $this->PromoThumbnail = $this->PromoCard()->CroppedImage(240, 370)->getURL();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'Flavor', 'Rules', 'Comment'
            ,'StrikeCost', 'Cost', 'Attack', 'Defense', 'Health'
            ,'Race', 'Faction', 'Set'
            ,'ArtistID', 'LinkToArtID', 'HolderPageID' 
            ,'CoverCard', 'PromoCard'
        ));
        $tabSet = new TabSet('BookTabSet',
            $this->getMainTab(),
            $this->getArtTab(),
            $this->getDescriptionTab()
        );
        $fields->addFieldsToTab('Root.Main', $tabSet);
        return $fields;
    }

    private function getMainTab() {
        return Tab::create(
            'MainFields',
            _t('CardGame.MAIN_TAB', 'Основное'),
            new NumericField('StrikeCost'),
            new NumericField('Cost'),
            new NumericField('Attack'),
            new NumericField('Health'),
            new NumericField('Defense')
        );
    }

    private function getArtTab() {
        return Tab::create(
            'ArtFields',
            _t('CardGame.ART_TAB', 'Рисунок'),
            new HasOnePickerField($this, 'ArtistID', 'Artist', $this->Artist()),
            new HasOnePickerField($this, 'LinkToArtID', 'Link to Art', $this->LinkToArt()),
            $this->getUploadField('CoverCard'),
            $this->getUploadField('PromoCard')
        );
    }

    private function getDescriptionTab() {
        return Tab::create(
            'Description',
            _t('CardGame.DESCRIPTION_TAB', 'Описание'),
            new NumericField('Set', 'Название Сета'),
            new HtmlEditorField('Rules', 'Правила'),
            new HtmlEditorField('Flavor', 'Особенность'),
            new HtmlEditorField('Comments', 'Комментарий')
        );
    }

    /**
     * @param $name
     * @param string $title
     * @return UploadField
     */
    protected function getUploadField($name, $title = null) {
        $field = new UploadField($name, $title);
        $field->setFolderName('CardGame/' . $this->HolderPage()->URLSegment);
        return $field;
    }
}
