<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);
}

class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

    /**
     * @param ArrayList|null $pages
     * @param int $itemsPerPage
     * @param SQLQuery $query
     * @return null|PaginatedList
     */
    protected function getPaginatedPages($pages = null, $itemsPerPage = 20, SQLQuery $query)
    {
        $pages = new PaginatedList($pages, $this->request);
        if ($query) {
            $pages->setPaginationFromQuery($query);
        }
        $pages->setPageLength($itemsPerPage);
        return $pages;
    }

    function InSectionNeed(){
        return (strpos($this->Link(),'Library')||strpos($this->Link(),'encyclopedia'))?true:false;
    }

    function getLastUpdateEncyclopedia($limit) {
        $ds = DataObject::get("SiteTree",' ClassName = '."'Page'".' AND Content IS NOT NULL', 'LastEdited DESC', null, $limit);
        $itemData = new DataList("SiteTree");
        $i=0;
        foreach($ds as $v) {
            if(strpos($v->Link(),'encyclopedia') && $v->URLSegment != 'encyclopedia'){
                $itemData->push($v);
                $i++;
            }
            if (10==$i) {
                break;
            }
        }
        return $itemData;
    }
}
