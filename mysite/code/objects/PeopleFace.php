<?php

/**
 * Class PeopleFace
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property string Nick
 * @property string Writer
 * @property string LastLinkSegment
 */
class PeopleFace extends DataObject {

	public static $db = array (
		'TitleEN' => 'Varchar(255)',
		'TitleRU' => 'Varchar(255)',
		'Nick' => 'Varchar(255)',
		//'Categoria' => "Varchar(20)", //Enum('Автор,Художник,Композитор,Писатель,Разработчик')
        'Writer' => 'Boolean',
        'Artist' => 'Boolean',
        'Composer' => 'Boolean',
        'Developer' => 'Boolean',
		'Content' => 'HTMLText',
		'WebLink' => 'Varchar(255)',
		'LastLinkSegment' => 'Varchar(255)',
	);

    public static $has_one = array (
		'Photo' => 'Image',
		'PeopleFacePage' => 'PeopleFacePage'
	);

    public static $has_many = array (
        //'Comments'	  => 'Comment',
    );

    public static $summary_fields = array (
        'ID', 'TitleEN', 'TitleRU', 'Nick'
    );

   	static $default_sort = 'TitleEN ASC';

    public function getTitle() {
        return $this->getField('TitleEN') . ($this->getField('Nick') ? ' (' . $this->getField('Nick') . ')' : '');
    }

    /**
     * @param String(Writer|Artist|Composer|Developer) $category
     * @return \DataList
     */
    static function getOnly($category) {
        return DataObject::get('PeopleFace', "\"PeopleFace\".\"" . $category . "\" = 1");
    }
}
