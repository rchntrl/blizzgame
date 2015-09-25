<?php

class BlizzgameAdmin extends ModelAdmin {

    private static $managed_models = array(
        'StormHero',
        'HeroTag',
        'ElementLink',
        'ElementLinkGroup',
        'PeopleFace',
    );

    private static $url_segment = 'blizzgame-objects';

    private static $menu_title = 'Blizzgame Data';

    /**
     * List only items from current subsite.
     * @return ArrayList $list
     */
    public function getList() {
        /** @var DataList $list */
        $list = parent::getList();
        $classes = array(
            'ElementLink',
            'ElementLinkGroup',
        );

        if(in_array($this->modelClass, $classes) && class_exists('Subsite')) {
            $list = $list->filter('SubsiteID', Subsite::currentSubsiteID());
        }

        return $list;
    }

    /**
     * Manage tabs
     *
     * @return array
     */
    public function getManagedModels() {
        $models = parent::getManagedModels();
        if (Subsite::currentSubsiteID() == 0) {
            $classes = array(
                'ElementLink',
                'ElementLinkGroup',
            );
            foreach($classes as $key) {
                unset($models[$key]);
            }
        }
        return $models;
    }

    public function subsiteCMSShowInMenu() {
        return true;
    }
}
