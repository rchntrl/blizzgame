<?php

/**
 * Class Book
 *
 * @property string TitleEN
 * @property string TitleRU
 * @method BooksHolderPage HolderPage()
 * @method Image Cover()
 * @method DataList Chapters()
 * @method DataList Authors()
 * @method DataList PaintsPage()
 * @method DataList PaintsCover()
 * @property Date DateSaleEN
 * @property String LastLinkSegment
 * @property String Category
 * @property String Places
 * @property String Events
 * @property String Races
 * @property String Fractions
 * @property String Heroes
 * @property String Monsters
 * @property String Items
 * @property String TextDescription
 * @property String TextContent
 */
class Book extends DataObject {

    private static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'CountPage' => 'Int',
        'PublisherEN' => 'Varchar(255)',
        'DateSaleEN' => 'Date',
        'PublisherRU' => 'Varchar(255)',
        'DateSaleRU' => 'Date',
        'Category' => "Enum('Book,Comics,Manga,Tale,Magazine')",
        'TextContent' => 'HTMLText',
        'TextDescription' => 'HTMLText',
        'LastLinkSegment' => 'Varchar(100)',
        'Races' => 'Text',
        'Heroes' => 'Text',
        'Fractions' => 'Text',
        'Places' => 'Text',
        'Monsters' => 'Text',
        'Items' => 'Text',
        'Events' => 'Text',
        'TranslatedBy' => 'Varchar(255)',
        'Author' => 'Varchar(255)'
    );

    private static $indexes = array(
        'ID_UniqueLastLinkSegment' => array(
            'type' => 'unique',
            'value' => 'LastLinkSegment'
        )
    );

    private static $has_one = array(
        'Cover' => 'Image',
        'Preview' => 'Image',
        'HolderPage' => 'BooksHolderPage'
    );

    private static $has_many = array(
        'AttachedImages' => 'AttachedImageChapter',
        'Chapters' => 'Chapter',
    );

    private static $many_many = array(
        'Authors' => 'PeopleFace',
        'PaintsPage' => 'PeopleFace',
        'PaintsCover' => 'PeopleFace',
    );

    private static $default_sort = 'DateSaleEN DESC';

    private static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU', 'Author'
    );

    private static $searchable_fields = array(
        'HolderPage.SubsiteID',
        'HolderPageID',
        'Category',
        'TitleEN',
        'TitleRU',
    );

    private static $field_labels = array(
        'HolderPage.SubsiteID' => 'Subsite',
        'HolderPage.Subsite.Title' => 'Subsite',
    );

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }

    public function Image() {
        return $this->Cover();
    }

    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_BOOK')) ? true : false;}
    function canView($Member = null) {return true;}

    public function getCMSFields() {
        $cmsFields = parent::getCMSFields();
        $cmsFields->removeByName(array(
            'Heroes', 'Monsters',
            'Fractions', 'Races', 'Places', 'Events',
            'Items','HolderPageID'
        ));
        $cmsFields->removeByName(array(
            'PublisherEN','PublisherRU', 'DateSaleEN', 'DateSaleRU',
            'CountPage', 'TextContent', 'TextDescription',
            'TranslatedBy', 'Author', 'Authors', 'PaintsCover', 'PaintsPage',
            'Cover', 'Preview', 'DateSaleRU', 'HolderPageID'
        ), true);
        $cmsFields->removeFieldsFromTab('Root', array('Authors', 'PaintsCover', 'PaintsPage'));
        $tabSet = new TabSet('BookTabSet',
            $this->getMainTab(),
            $this->getDescriptionTab(),
            $this->getExtraTab()
        );
        $cmsFields->addFieldsToTab('Root.Main', $tabSet);
        $cmsFields->addFieldsToTab('Root', $this->getElementLinksTab(), 'Chapters');
        if ($cmsFields->dataFieldByName('Chapters')) {
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig = $cmsFields->dataFieldByName('Chapters')->getConfig();
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('NumberSort'));
            $cmsFields->dataFieldByName('Chapters')->setConfig($gridFieldConfig);
        }
        if ($cmsFields->dataFieldByName('AttachedImages')) {
            $gridFieldConfig = $cmsFields->dataFieldByName('AttachedImages')->getConfig();
            $bulkUpload = new GridFieldBulkUpload();
            $bulkUpload->setUfSetup('setFolderName', 'Attached-Images/' . SiteConfig::current_site_config()->Title . '/' . $this->LastLinkSegment);
            $gridFieldConfig->addComponent($bulkUpload);
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('NumberSort'));
            $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
            $cmsFields->dataFieldByName('AttachedImages')->setConfig($gridFieldConfig);
        }
        return $cmsFields;
    }

    protected function getMainTab() {
        $coverField = new UploadField('Cover', _t('Book.COVER', 'Обложка'));
        $previewField = new UploadField('Preview', _t('Book.PREVIEW', 'Обложка 2'));
        $folderName = 'BookCovers/' . Subsite::currentSubsite()->getField('Title');
        $coverField->setFolderName($folderName);
        $previewField->setFolderName($folderName);
        return Tab::create(
            'MainFields',
            _t('Book.MAIN_TAB', 'Основное'),
            PeopleFace::getMultipleField('Authors', _t('Book.AUTHORS', 'Авторы (книга отобразится на странице автора)'), PeopleFace::WRITER),
            new TextField('Author', 'Авторы (если нет в базе. Текст отобразится на странице книги)'),
            PeopleFace::getMultipleField('PaintsCover', _t('Book.PAINTS_COVER', 'Художники обложки'), PeopleFace::ARTIST),
            PeopleFace::getMultipleField('PaintsPage', _t('Book.PAINTS_PAGE', 'Художники страниц'), PeopleFace::ARTIST),
            $coverField,
            $previewField
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
            new HtmlEditorField('TextContent', 'Сюжет (Рецензия)'),
            new HtmlEditorField('TextDescription', 'Описание')
        );
    }

    protected function getElementLinksTab() {
        return Tab::create(
            'Tags',
            _t('Book.TAGSTAB', 'Тэги'),
            ElementLink::getMultipleField('Heroes', 'Персонажи', ElementLink::HEROES),
            ElementLink::getMultipleField('Monsters', 'Бестиарий', ElementLink::MONSTERS),
            ElementLink::getMultipleField('Fractions', 'Фракции', ElementLink::FRACTIONS),
            ElementLink::getMultipleField('Races', 'Расы', ElementLink::RACES),
            ElementLink::getMultipleField('Places', 'Места', ElementLink::PLACES),
            ElementLink::getMultipleField('Events', 'События и праздники', ElementLink::EVENTS),
            ElementLink::getMultipleField('Items', 'Предметы и артефакты', ElementLink::ITEMS)
        );
    }

    public function link() {
        return $this->HolderPage()->Link() . $this->LastLinkSegment;
    }

    /**
     * @return Book
     */
    public function Previous() {
        $Book = DataObject::get_one('Book',
            "\"Book\".\"HolderPageID\" = " . $this->getField('HolderPageID') . " AND \"Book\".\"DateSaleEN\" > '" . $this->DateSaleEN . "'",
            true,
            "DateSaleEN ASC"
        );
        return $Book;
    }

    /**
     * @return Book
     */
    public function Next() {
        $Book = DataObject::get_one('Book',
            "\"Book\".\"HolderPageID\" = " . $this->getField('HolderPageID') . " AND \"Book\".\"DateSaleEN\" < '" . $this->DateSaleEN . "'",
            true,
            "DateSaleEN DESC"
        );
        return $Book;
    }

    /**
     * @param int $limit
     * @return SS_List
     */
    public function Closest($limit  = 9) {
        /** @var Book $prevBook */
        $prevBook =  DataObject::get('Book',
            "\"Book\".\"HolderPageID\" = " . $this->getField('HolderPageID') . " AND \"Book\".\"DateSaleEN\" > '" . $this->DateSaleEN . "'",
            "DateSaleEN ASC",
            "",
            round($limit / 2)
        )->last();
        if (!$prevBook) {
            $prevBook = $this;
        }
        return DataObject::get('Book',
            "\"Book\".\"HolderPageID\" = " . $prevBook->getField('HolderPageID') . " AND \"Book\".\"DateSaleEN\" <= '" . $prevBook->DateSaleEN . "'",
            "DateSaleEN DESC",
            "",
            $limit
        );
    }
}
