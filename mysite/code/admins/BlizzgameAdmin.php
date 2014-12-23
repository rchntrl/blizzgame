<?php
/**
 * Created by PhpStorm.
 * User: nurgazy
 * Date: 18.09.14
 * Time: 21:52
 */

class BlizzgameAdmin extends ModelAdmin {

    private static $managed_models = array(
        'ElementLink',
        'ElementLinkGroup',
        'PeopleFace',
        'Book',
    );
    private static $url_segment = 'blizzgame-objects';

    private static $menu_title = 'Blizzgame objects';

    /**
     * List only newsitems from current subsite.
     * @author Marcio Barrientos
     * @return ArrayList $list
     */

    public function getList() {
        $list = parent::getList();
        $classes = array(
            'ElementLink',
            'ElementLinkGroup'
        );

        if(in_array($this->modelClass, $classes) && class_exists('Subsite')) {
            $list = $list->filter('SubsiteID', Subsite::currentSubsiteID());
        }

        return $list;
    }/**/
} 