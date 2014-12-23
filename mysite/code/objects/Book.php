<?php

/**
 * Class BookComicManga
 *
 * @author nurgazy
 *
 * @method BooksHolderPage HolderPage()
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
        //'Categoria' => "Enum('Книга,Комикс,Манга,Рассказ,Журнал')",
        'Category' => "Enum('Book,Comics,Manga,Tale,Magazine')",
        'TextContent' => 'HtmlText',
        'TextDescription' => 'Text',
        'LinkURL' => 'Varchar(100)',
        'Races' => 'Text',
        'Heroes' => 'Text',
        'Fractions' => 'Text',
        'Places' => 'Text',
        'Monsters' => 'Text',
        'Items' => 'Text',
        'Hollidays' => 'Text',
        'TranslatedBy' => 'Varchar(255)',
        'Author' => 'Varchar(255)',
        'DateNews' => 'Date',
    );

    public static $has_one = array(
        'Cover' => 'Image',
        //'Preview' => 'File',
        'HolderPage' => 'BooksHolderPage'
    );

    public static $many_many = array(
        'Authors' => 'PeopleFace',
        'PaintsPage' => 'PeopleFace',
        'PaintsCover' => 'PeopleFace',
        //'Tags' => 'Tag'
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
        'HolderPage.SubsiteID' => 'Subsite',
        'HolderPage.Subsite.Title' => 'Subsite',
    );

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->replaceField(
            'Heroes',
            new TagField(
                'Heroes',
                'Heroes',
                null,
                'PeopleFace',
                'TitleEN'
            )
        );
        $fields->replaceField(
            'Fractions',
            new TagField(
                'Fractions',
                'Fractions',
                null,
                'ElementLink',
                'TitleEN'
            )
        );

        return $fields;
    }

}
