<?php

/**
 * Add some settings to the siteconfig.
 *
 * @author Nurgazy
 * @method Image BackgroundImage()
 * @method Image DefaultElementImage() The default element link image.
 * @method Image LogoImage() The default logo image.
 * @todo Work this out a bit better.
 */
class BlizzgameConfigExtension extends DataExtension {

    private static $db = array(
    );

    private static $has_one = array(
        'LogoImage' => 'Image',
        'BackgroundImage' => 'Image',
        'DefaultElementImage' => 'Image',
    );

    private static $defaults = array(
    );

    /** @var array $config_tabs the tabs available for the user to config. */
    private static $config_tabs = array(
        'HelpTab',
    );

    /** @var array $admin_tabs The Admin-specific tabs. */
    private static $admin_tabs = array(
        'ThemesTab'
    );

    /**
     * A foldername relative to /assets,
     * where all uploaded files are stored by default.
     * Can be overwritten in db using NewsRootFolder
     *
     * @config
     * @var string
     */
    private static $uploads_folder = "Themes";

    /**
     * Update the SiteConfig with the news-settings.
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
       $logoImage = new UploadField('LogoImage', _t('BlizzgameConfigExtension.LOGOIMAGE', 'Logo image for frontend'));
       $backgroundImage = new UploadField('BackgroundImage', _t('BlizzgameConfigExtension.BACKGROUNDIMAGE', 'Background image for frontend'));
       $defaultElementImage =  new UploadField('DefaultElementImage', _t('BlizzgameConfigExtension.DEFAULTELEMENTIMAGE', 'Default element image for frontend'));
        /** theme settings */
        return Tab::create(
            'Theme',
            _t('BlizzgameConfigExtension.THEMESETTINGS', 'Theme Settings'),
            $logoImage->setFolderName(self::$uploads_folder),
            $backgroundImage->setFolderName(self::$uploads_folder),
            $defaultElementImage->setFolderName(self::$uploads_folder)
        );
    }

    protected function HelpTab() {
        return Tab::create(
            'Help',
            _t('BlizzgameConfigExtension.HELP', 'Help'),
            ReadonlyField::create('themehelp', _t('BlizzgameConfigExtension.THEMEHELP', 'Theme help'), _t('BlizzgameConfigExtension.NEWSHELPTEXT', 'In the theme settings tab, you can set logo, background, etc.'))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function populateDefaults(){

    }
}
