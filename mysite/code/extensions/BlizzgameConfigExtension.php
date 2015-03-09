<?php

/**
 * Add some settings to the siteconfig.
 *
 * @author Nurgazy
 * @method Image BackgroundImage()
 * @method Image DefaultElementImage() The default element link image.
 * @method Image LogoImage() The default logo image.
 */
class BlizzgameConfigExtension extends DataExtension {

    private static $db = array(
        'BackgroundVerticalPosition' => 'Int',
        'Races' => 'Varchar(255)',
        'Fractions' => 'Varchar(255)',
        'Classes' => 'Varchar(255)',
        'Characters' => 'Varchar(255)',
        'Professions' => 'Varchar(255)',
        'Talents' => 'Varchar(255)',
        'Items' => 'Varchar(255)',
        'Bestiary' => 'Varchar(255)',
    );

    private static $has_one = array(
        'LogoImage' => 'Image',
        'BackgroundImage' => 'Image',
        'DefaultElementImage' => 'Image',
        'DefaultBookCover' => 'Image',
    );

    private static $defaults = array(
        'BackgroundVerticalPosition' => 50
    );

    /** @var array $config_tabs the tabs available for the user to config. */
    private static $config_tabs = array(
        'HelpTab',
    );

    /** @var array $admin_tabs The Admin-specific tabs. */
    private static $admin_tabs = array(
        'ThemesTab',
        'TagsGroupTab',
    );

    /**
     * A foldername relative to /assets,
     * @config
     * @var string
     */
    private static $uploads_folder = "Themes";

    /**
     * Update the SiteConfig with the blizzgame settings.
     * The tabs are pushed into arrays, because it works better than adding them one by one.
     * @param FieldList $fields of current FieldList of SiteConfig
     */
    public function updateCMSFields(FieldList $fields) {
        /** Only allow authors or higher! */
        $fields->addFieldToTab(
            'Root',
            TabSet::create(
                'Blizzgamesettings',
                _t('BlizzgameConfigExtension.BLIZZGAMESETTINGS', 'Blizzgame settings')
            )
        );
        if(($this->owner->AllowAuthors && $this->owner->canEdit(Member::currentUser())) || Member::currentUser()->inGroup('administrators')){
            $userTabs = array();
            foreach(self::$config_tabs as $tab) {
                $userTabs[] = $this->$tab();
            }
            $fields->addFieldsToTab('Root.Blizzgamesettings', $userTabs);
        }
        else {
            $fields->addFieldToTab('Root.Blizzgamesettings', HeaderField::create('NoPermissions', _t('BlizzgameConfigExtension.PERMISSIONERROR', 'You do not have the permission to edit these settings')));
        }
        $list = PageConfig::get('PageConfig', "\"PageConfig\".\"SubsiteID\" = " . $this->owner->SubsiteID);
        $settingGridField = new GridField('PageConfig', _t("MainPage.PAGE_CONFIG_CMS_TITLE", "Настройки вида страниц книг и медиа"), $list, GridFieldConfig_RecordEditor::create());
        $fields->addFieldToTab('Root.Main', $settingGridField);
        if(Member::currentUser()->inGroup('administrators')){
            $adminTabs = array();
            foreach(self::$admin_tabs as $tab) {
                $adminTabs[] = $this->$tab();
            }
            $fields->addFieldsToTab('Root.Blizzgamesettings', $adminTabs, 'Help');
        }
    }

    /**
     * Setup the tabs for the user
     * All return a Tab.
     */
    protected function ThemesTab() {
       $logoImage = new UploadField('LogoImage', _t('BlizzgameConfigExtension.LOGOIMAGE', 'Лого сайта'));
       $backgroundImage = new UploadField('BackgroundImage', _t('BlizzgameConfigExtension.BACKGROUNDIMAGE', 'Фоновое изображение сайта'));
       $defaultElementImage =  new UploadField('DefaultElementImage', _t('BlizzgameConfigExtension.DEFAULTELEMENTIMAGE', 'Иконка тега по умолчанию'));
       $defaultBookCover =  new UploadField('DefaultBookCover', _t('BlizzgameConfigExtension.DEFAULTBOOKCOVER', 'Обложка книги по умолчанию'));
        return Tab::create(
            'Theme',
            _t('BlizzgameConfigExtension.THEMESETTINGS', 'Theme Settings'),
            $logoImage->setFolderName(self::$uploads_folder),
            //new NumericField('BackgroundVerticalPosition', 'BackgroundVerticalPosition'),
            $backgroundImage->setFolderName(self::$uploads_folder),
            $defaultElementImage->setFolderName(self::$uploads_folder),
            $defaultBookCover->setFolderName(self::$uploads_folder)
        );
    }

    protected function HelpTab() {
        return Tab::create(
            'Help',
            _t('BlizzgameConfigExtension.HELP', 'Help'),
            ReadonlyField::create('themehelp', _t('BlizzgameConfigExtension.THEMEHELP', 'Theme help'), _t('BlizzgameConfigExtension.NEWSHELPTEXT', 'In the theme settings tab, you can set logo, background, etc.'))
        );
    }

    protected function TagsGroupTab() {
        return Tab::create(
            'Tags',
            _t('BlizzgameConfigExtension.TAGSGROUP', 'Tags Group'),
            ElementLinkGroup::getDropdownField('Races', 'Races Group'),
            ElementLinkGroup::getDropdownField('Fractions', 'Fractions Group'),
            ElementLinkGroup::getDropdownField('Classes', 'Classes Group'),
            ElementLinkGroup::getDropdownField('Characters', 'Characters Group'),
            ElementLinkGroup::getDropdownField('Professions', 'Professions'),
            ElementLinkGroup::getDropdownField('Talents', 'Talents Group'),
            ElementLinkGroup::getDropdownField('Items', 'Items Group'),
            ElementLinkGroup::getDropdownField('Bestiary', 'Bestiary')
        );
    }
    /**
     * {@inheritdoc}
     */
    public function populateDefaults() {
        $this->owner->BackgroundVerticalPosition = 50;
    }
}
