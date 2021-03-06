<?php

/**
 * Class ChronicleItem
 *
 * @method ChroniclePage HolderPage
 * @property Int NumberSort
 */
class ChronicleItem extends DataObject implements PermissionProvider {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar',
        'Content' => 'HTMLText',
        'ShortText' => 'Text',
        'NumberSort' => 'Int',
        'Races' => 'Varchar(255)',
        'Fractions' => 'Varchar(255)',
        'Heroes' => 'Varchar(255)',
        'Places' => 'Varchar(255)',
        'Monsters' => 'Varchar(255)',
        'Items' => 'Varchar(255)',
    );

    private static $has_one = array (
        'MenuImage' => 'Image',
        'HolderPage' => 'ChroniclePage'
    );

    private static $has_many = array (
        'Elements' => 'PageElement',
    );

    private static $default_sort = 'NumberSort ASC';

    public function providePermissions()
    {
        return array(
            'CREATE_EDIT_CHRONICLE' => array(
                'name' => _t('ChronicleItem.PERMISSION_CREATE_EDIT_DESCRIPTION', 'Create&Edit Chronicle'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('ChronicleItem.PERMISSION_CREATE_EDIT_HELP', 'Permission required to create/edit new Chronicle.')
            ),
            'DELETE_CHRONICLE' => array(
                'name' => _t('ChronicleItem.PERMISSION_DELETE_DESCRIPTION', 'Delete Chronicle'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('ChronicleItem.PERMISSION_DELETE_HELP', 'Permission required to delete existing Chronicle.')
            ),
        );
    }

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_CHRONICLE')) ? true : false;}
    function canView($Member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'Fractions', 'Races', 'Heroes',
            'Monsters', 'Places', 'Items',
            'HolderPageID'
        ));
        /** @var UploadField $uploadField */
        $uploadField = $fields->dataFieldByName('MenuImage');
        $uploadField->setFolderName('Chronicles/' . Subsite::currentSubsiteID() . '/MenuItems/');
        $fields->addFieldsToTab('Root', $this->getElementLinksTab());
        if ($fields->dataFieldByName('Elements')) {
            /** @var GridFieldConfig $gridFieldConfig */
            $gridFieldConfig = $fields->dataFieldByName('Elements')->getConfig();
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $fields->dataFieldByName('Elements')->setConfig($gridFieldConfig);
        }
        return $fields;
    }

    protected function getElementLinksTab() {
        return Tab::create(
            'Tags',
            _t('ChronicleItem.TAGSTAB', 'Тэги'),
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

    /**
     * @param int $limit
     * @return SS_List
     */
    public function Closest($limit  = 7) {
        return DataObject::get('ChronicleItem',
            "\"ChronicleItem\".\"HolderPageID\" = " . $this->getField('HolderPageID') .
            " AND \"ChronicleItem\".\"NumberSort\" >= " . ($this->NumberSort - round($limit / 2)),
            "NumberSort ASC",
            "",
            $limit
        );
    }
}
