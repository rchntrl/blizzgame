<?php

class BlizzgameAdmin extends ModelAdmin {

    private static $managed_models = array(
        'ElementLink',
        'ElementLinkGroup',
        'PeopleFace',
    );

    private static $url_segment = 'blizzgame-objects';

    private static $menu_title = 'Blizzgame Data';

    /**
     * List only newsitems from current subsite.
     * @author Marcio Barrientos
     * @return ArrayList $list
     */

    public function getList() {
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

    public function subsiteCMSShowInMenu() {
        return true;
    }
}
