<?php

/**
 * Class Book
 *
 * @author nurgazy
 *
 * @method BooksHolderPage HolderPage()
 * @property String LastLinkSegment
 * @property String Category
 * @property String Places
 * @property String Events
 * @property String Races
 * @property String Fractions
 * @property String Heroes
 * @property String Monsters
 * @property String Items
 */

class Book extends DataObject {

    public static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'CountPage' => 'Int',
        'PublisherEN' => 'Varchar(255)',
        'DateSaleEN' => 'Date',
        'PublisherRU' => 'Varchar(255)',
        'DateSaleRU' => 'Date',
        //'Categoria' "Enum('Книга,Комикс,Манга,Рассказ,Журнал')",
        'Category' => "Enum('Book,Comics,Manga,Tale,Magazine')",
        'TextContent' => 'HtmlText',
        'TextDescription' => 'HtmlText',
        'LastLinkSegment' => 'Varchar(100)',
        'Races' => 'Text',
        'Heroes' => 'Text',
        'Fractions' => 'Text',
        'Places' => 'Text',
        'Monsters' => 'Text',
        'Items' => 'Text',
        'Events' => 'Text',
        'TranslatedBy' => 'Varchar(255)',
        'Author' => 'Varchar(255)',
        'DateNews' => 'Date',
    );

    public static $indexes = array(
        'ID_UniqueLastLinkSegment' => array(
            'type' => 'unique',
            'value' => 'LastLinkSegment'
        )
    );

    public static $has_one = array(
        'Cover' => 'Image',
        //'Preview' => 'Image',
        'HolderPage' => 'BooksHolderPage'
    );

    public static $has_many = array(
        'Chapters' => 'Chapter'
    );

    public static $many_many = array(
        'Authors' => 'PeopleFace',
        'PaintsPage' => 'PeopleFace',
        'PaintsCover' => 'PeopleFace',
    );

    static $summary_fields = array(
        'ID', 'Title', 'HolderPage.Subsite.Title'
    );

    static $searchable_fields = array(
        'HolderPage.SubsiteID',
        'HolderPageID',
        'Category',
    );

    private static $field_labels = array(
        'TittleEN' => 'Название на английском',
        'TitleRU' => 'Название на русском',
        'HolderPage.SubsiteID' => 'Subsite',
        'HolderPage.Subsite.Title' => 'Subsite',
    );

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }

    public function getCMSFields() {
        $cmsFields = parent::getCMSFields();
        $cmsFields->removeByName(array(
            'Heroes', 'Monsters',
            'Fractions', 'Races', 'Places', 'Events',
            'Items','HolderPageID'
        ));
        $cmsFields->removeByName(array(
            'PublisherEN','PublisherRU', 'DateSaleEN', 'DateSaleRU',
            'CountPage', 'TextContent', 'TextDescription', 'LastLinkSegment',
            'TranslatedBy', 'Author', 'Authors', 'PaintsCover', 'PaintsPage',
            'Cover', 'DateSaleRU', 'HolderPageID'
        ), true);
        $cmsFields->removeFieldsFromTab('Root', array('Authors', 'PaintsCover', 'PaintsPage'));
        $tabSet = new TabSet('BookTabSet',
            $this->getMainTab(),
            $this->getDescriptionTab(),
            $this->getExtraTab()
        );
        $cmsFields->addFieldsToTab('Root.Main', $tabSet);
        $cmsFields->addFieldsToTab('Root', $this->getElementLinksTab(), 'Chapters');
        return $cmsFields;
    }

    protected function getMainTab() {
        //var_dump($this->Category);
        return Tab::create(
            'MainFields',
            _t('Book.MAIN_TAB', 'Основное'),
            //new TextField('TitleEN'),
           // new TextField('TitleRU'),
            //new TextField('DateNews'),
            //new DropdownField('Category', 'Категория'),
            PeopleFace::getMultipleField('Authors', 'Authors', 'Writers'),
            new TextField('Author', 'Автор (если нет в базе)'),
            PeopleFace::getMultipleField('PaintsCover', 'Художники обложки', 'Artist'),
            PeopleFace::getMultipleField('PaintsPage', 'Художники страниц', 'Artist'),
            new UploadField('Cover')
        );
    }

    protected function getExtraTab() {
        return Tab::create(
            'ExtraFields',
            _t('Book.EXTRA_TAB', 'Дополнительно'),
            new TextField('CountPage', 'Количество страниц'),
            new TextField('PublisherEN', 'Издатель (анг)'),
            new DateField('DateSaleEN', 'Дата издания оригинала'),
            new TextField('PublisherRU', 'Издатель (рус)'),
            new DateField('DateSaleRU', 'Дата издания на русском'),
            new TextField('TranslatedBy', 'Переводчики')
        );
    }

    protected function getDescriptionTab() {
        return Tab::create(
            'Description',
            _t('Book.DESCRIPTION_TAB', 'Описание'),
            new HtmlEditorField('TextContent'),
            new HtmlEditorField('TextDescription')
        );
    }

    protected function getElementLinksTab() {
        return Tab::create(
            'Tags',
            _t('Book.TAGSTAB', 'Tags'),
            ElementLink::getMultipleField('Heroes', 'Персонажи', ElementLink::HEROES),
            ElementLink::getMultipleField('Monsters', 'Бестиарий', ElementLink::MONSTERS),
            ElementLink::getMultipleField('Fractions', 'Фракции', ElementLink::FRACTIONS),
            ElementLink::getMultipleField('Races', 'Races', ElementLink::RACES),
            ElementLink::getMultipleField('Places', 'Места', ElementLink::PLACES),
            ElementLink::getMultipleField('Events', 'События и праздники', ElementLink::EVENTS),
            ElementLink::getMultipleField('Items', 'Предметы и артефакты', ElementLink::ITEMS)
        );
    }

    public function link() {
        return $this->HolderPage()->Link() . $this->LastLinkSegment;
    }
}
