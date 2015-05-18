<?php

/**
 * Class Media
 *
 * @property string TitleEN
 * @property string TitleRU
 * @property String LastLinkSegment
 * @property String Format
 * @property String Duration
 * @property String Content
 * @property String PublisherEN
 * @property String DateSaleEN
 */
class Media extends DataObject implements PermissionProvider {

    private static $db = array (
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'LastLinkSegment' => 'Varchar(255)',
        'Format' => 'Varchar(255)',
        'Duration' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'PublisherEN' => 'Varchar(255)',
        'DateSaleEN' => 'Date',
        'Category' => "Enum('soundtrack,behind-the-scenes-dvd')",
    );

    private static $has_one = array (
        'Cover' => 'Image',
        'HolderPage' => 'MediaPage'
    );

    private static $many_many = array(
        'Authors' => 'PeopleFace'
    );

    private static $summary_fields = array(
        'ID', 'Title', 'DateSaleEN'
    );

    private static $default_sort = 'DateSaleEN DESC';

    public function providePermissions()
    {
        return array(
            'CREATE_EDIT_MEDIA' => array(
                'name' => _t('Media.PERMISSION_CREATE_EDIT_DESCRIPTION', 'Create&Edit Media'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Media.PERMISSION_CREATE_EDIT_HELP', 'Permission required to Create&Edit Media.')
            ),
            'DELETE_MEDIA' => array(
                'name' => _t('Media.PERMISSION_DELETE_DESCRIPTION', 'Delete Media'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Media.PERMISSION_DELETE_HELP', 'Permission required to delete existing Media.')
            ),
            'VIEW_MEDIA' => array(
                'name' => _t('Media.PERMISSION_VIEW_DESCRIPTION', 'View Media'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Media.PERMISSION_VIEW_HELP', 'Permission required to view existing Media.')
            ),
        );
    }

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_MEDIA')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_MEDIA')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_MEDIA')) ? true : false;}
    function canView($Member = null) {return (permission::check('VIEW_MEDIA')) ? true : false;}

    /**
     * @param $url
     * @return static
     */
    public static function get_by_url($url) {
        $callerClass = get_class();
        return DataObject::get_one($callerClass, "\"" . $callerClass . "\".\"LastLinkSegment\" = '" . $url ."'");
    }

    public function getTitle() {
        return $this->getField('TitleRU') . ' (' . $this->getField('TitleEN') . ')';
    }
}
