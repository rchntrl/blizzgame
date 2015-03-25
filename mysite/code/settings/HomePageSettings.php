<?php

/**
 * Class HomePageSettings
 *
 * @property String Title
 * @property String UsedByID
 * @property Boolean UseThisOne
 * @property Int OrbitLimit
 * @property String HeroesRotation
 * @property HTMLText HeroesSaleText
 */
class HomePageSettings extends DataObject {

    static $db = array(
        'Title' => 'Varchar(255)',
        "UseThisOne" => "Boolean",
        'HeroesRotation' => 'Varchar(255)',
        'HeroesSaleText' => 'HTMLText',
        'HearthStoneText' => 'HTMLText',
        'OrbitLimit' => 'Int',
    );

    static $has_one = array(
        'UsedBy' => 'HomePage',
        'HeroesBackground' => 'Image',
        'HearthBackground' => 'Image',
    );

    static $summary_fields = array(
        "Title" => "Title",
        "UseThisOneNice" => "Use this configuration set"
    );

    /**
     * Standard SS Variable
     * @var Array
     */
    private static $casting = array(
        "UseThisOneNice" => "Varchar"
    );

    /**
     * Standard SS variable
     * @var String
     */
    private static $default_sort = "\"UseThisOne\" DESC, \"Created\" ASC";

    private static $admin_tabs = array(
        'HOTSTab',
        'HearthStoneTab',
        'OverWatchTab',
    );

    /**
     *
     * Casted Variable
     * @return String
     */
    public function UseThisOneNice() {
        return $this->UseThisOne ? "YES" : "NO";
    }

    public function HeroesRotation() {
        return StormHero::get()->filter('ID', explode(',', $this->HeroesRotation));
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName(array(
            'HeroesRotation',
            'HeroesBackground',
            'HearthBackground',
        ));

        if (Member::currentUser()->inGroup('administrators')) {
            /** @var TabSet $tabSet */
            $tabSet = TabSet::create(
                'MainPageSettings',
                _t('MainPage.SETTINGS', 'Main Page Settings')
            );
            foreach(self::$admin_tabs as $tab) {
                $tabSet->push($this->$tab());
            }

            $fields->addFieldToTab('Root.Main', $tabSet);
            $fields->addFieldsToTab('Root.Main.MainPageSettings.HeroesOfTheStorm', array(
                $fields->dataFieldByName('HeroesSaleText')
            ));
            $fields->addFieldsToTab('Root.Main.MainPageSettings.HearthStone', array(
                $fields->dataFieldByName('HearthStoneText')
            ));
        }

        return $fields;
    }

    /**
     * @param $name
     * @param string $title
     * @param string $folderName
     * @return UploadField
     */
    protected function getUploadField($name, $title = '', $folderName = 'Themes') {
        if (!$title) {
            $title = $name;
        }
        $field = new UploadField($name, $title);
        $field->setFolderName($folderName);
        return $field;
    }

    protected function HOTSTab() {
        return Tab::create(
            'HeroesOfTheStorm',
            _t('MainPage.HOTS', 'Heroes of the Storm'),
            new ListboxField(
                'HeroesRotation',
                'Heroes Rotation',
                StormHero::get()->map('ID', 'TitleEN')->toArray(),
                '',
                8,
                true
            ),
            $this->getUploadField('HeroesBackground', 'Heroes Background')
        );
    }

    protected function HearthStoneTab() {
        return Tab::create(
            'HearthStone',
            _t('MainPage.HS', 'HearthStone'),
            $this->getUploadField('HearthBackground', 'HearthStone Background')
        );
    }

    protected function OverWatchTab() {
        return Tab::create(
            'Overwatch',
            _t('MainPage.OVERWATCH', 'Overwatch')
        );
    }

    /**
     * standard SS method
     */
    function onAfterWrite() {
        if ($this->UseThisOne) {
            $configs = HomePageSettings::get()
                ->Filter(array("UseThisOne" => 1, 'UsedByID' => $this->UsedByID))
                ->Exclude(array("ID" => $this->ID));
            if ($configs->count()) {
                foreach($configs as $config) {
                    $config->UseThisOne = 0;
                    $config->write();
                }
            }
        }

        $configs = HomePageSettings::get()
            ->Filter(array("Title" => $this->Title, 'UsedByID' => $this->UsedByID))
            ->Exclude(array("ID" => $this->ID));
        if ($configs->count()) {
            foreach($configs as $key => $config) {
                $config->Title = $config->Title."_".$config->ID;
                $config->write();
            }
        }
    }
}
