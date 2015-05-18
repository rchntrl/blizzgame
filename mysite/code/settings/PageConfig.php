<?php

/**
 * Class PageConfig
 *
 * @property String Title
 * @property String View
 * @property Boolean UseThisOne
 */
class PageConfig extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        "UseThisOne" => "Boolean",
        'View' => "Enum('BookView,AlbumView')",
    );

    private static $has_one = array(
        'UsedBy' => 'Page',
        'Subsite' => 'Subsite',
    );

    private static $summary_fields = array(
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

    /**
     *
     * Casted Variable
     * @return String
     */
    public function UseThisOneNice() {
        return $this->UseThisOne ? "YES" : "NO";
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        if (class_exists('Subsite')) {
            $fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
        }
        $list = SiteTree::get('SiteTree', "\"SiteTree\".\"ClassName\" in ('BooksHolderPage', 'MediaPage')")->map()->toArray();
        $fields->replaceField('UsedByID',
            new DropdownField("UsedByID", "Used By", $list)
        );
        return $fields;
    }

    /**
     * standard SS method
     */
    function onAfterWrite() {
        if ($this->UseThisOne) {
            $configs = PageConfig::get()
                ->Filter(array("UseThisOne" => 1, 'UsedByID' => $this->UsedByID))
                ->Exclude(array("ID" => $this->ID));
            if ($configs->count()) {
                foreach($configs as $config) {
                    $config->UseThisOne = 0;
                    $config->write();
                }
            }
        }

        $configs = PageConfig::get()
            ->Filter(array("Title" => $this->Title, 'UsedByID' => $this->UsedByID))
            ->Exclude(array("ID" => $this->ID));
        if ($configs->count()) {
            foreach($configs as $key => $config) {
                $config->Title = $config->Title . "_" . $config->ID;
                $config->write();
            }
        }
    }
}
