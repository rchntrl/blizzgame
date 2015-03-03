<?php

/**
 * Class MainPage
 *
 * @property HomePageSettings Settings
 * @property Int SettingsID
 */
class MainPage extends HomePage {

    public function getHomePageConfig() {
        return DataObject::get_one('HomePageSettings', "\"HomePageSettings\".\"UseThisOne\" = 1 AND \"HomePageSettings\".\"UsedByID\" = " . $this->ID);
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'Content');

        $list = DataObject::get('HomePageSettings', "\"HomePageSettings\".\"UsedByID\" = " . $this->ID);

        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridField = new GridField("Settings", _t("MainPage.SETTINGS_CMS_TITLE", "Настройки"), $list, $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'Metadata');

        return $fields;
    }
}

/**
 * Class MainPage_Controller
 */
class MainPage_Controller extends HomePage_Controller {

    public function init() {
        parent::init();
        Requirements::css($this->ThemeDir() .  'css/hots.css');
    }

    /**
     * @return HomePageSettings
     */
    protected function getHomePageConfig() {
        return DataObject::get_one('HomePageSettings', "\"HomePageSettings\".\"UseThisOne\" = 1 AND \"HomePageSettings\".\"UsedByID\" = " . $this->ID);
    }

    public function allNews() {
        return DataObject::get('News', '"News"."Live" = 1', 'Created DESC', '')->limit(7);
    }

    public function OrbitNews() {
        return DataObject::get('News', '"News"."Live" = 1 AND "News"."ShowInCarousel" = 1', 'Created DESC', '')->limit($this->getHomePageConfig()->OrbitLimit);
    }

    public function LastArts() {
        return DataObject::get('GalleryImage', '', 'Created DESC', '')->limit(6);
    }
}
