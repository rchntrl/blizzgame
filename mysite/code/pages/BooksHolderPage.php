<?php

/**
 * Class BooksHolderPage
 * @method SS_List Books()
 */
class BooksHolderPage extends Page implements PermissionProvider {

    private static $has_many = array(
        'Books' => 'Book'
    );

    /**
     * @return PageConfig
     */
    public function getPageConfig() {
        return PageConfig::get_one('PageConfig', '"PageConfig"."UsedByID" = ' . $this->ID);
    }

    public function providePermissions() {
        return array(
            'CREATE_EDIT_BOOK' => array(
                'name' => _t('Book.PERMISSION_CREATE_EDIT_DESCRIPTION', 'Create&Edit Library'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Book.PERMISSION_CREATE_EDIT_HELP', 'Permission required to create new Library Item.')
            ),
            'DELETE_BOOK' => array(
                'name' => _t('Book.PERMISSION_DELETE_DESCRIPTION', 'Delete Library'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Book.PERMISSION_DELETE_HELP', 'Permission required to create new Library Item.')
            ),
            'VIEW_BOOK' => array(
                'name' => _t('Book.PERMISSION_VIEW_DESCRIPTION', 'View Library'),
                'category' => _t('Permissions.BLIZZGAME_DATA', 'BlizzGame Data'),
                'help' => _t('Book.PERMISSION_VIEW_HELP', 'Permission required to create new Library Item.')
            ),
        );
    }

    //Permissions
    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_BOOK')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_BOOK')) ? true : false;}

    public function getCMSFields() {

        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
        $gridField = new GridField('Books', _t('Library.BOOKS_CMS_TITLE', 'Books'), $this->Books(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');

        return $fields;
    }
}

/**
 * Class BooksHolderPage_Controller
 *
 * @method SS_List Books()
 */
class BooksHolderPage_Controller extends Page_Controller {

    private static $allowed_actions = array(
        'viewBook',
        'viewChapter',
    );

    private static $url_handlers = array(
        '$ID!/translate/$Number' => 'viewChapter',
        '$ID!' => 'viewBook',
    );

    /**
     * @return SQLSelect
     */
    public function getQueryBuilder() {
        $qb = new SQLSelect('*', 'Book');
        $qb
            ->setOrderBy(array('Book.DateSaleEN DESC'))
            ->setWhere('Book.HolderPageID = ' . $this->ID) // Books must belong to this page
        ;
        return $qb;
    }

    public function viewBook() {
        /** @var Book $book */
        $book = null;
        if($this->urlParams['ID']) {
            $id = $this->urlParams['ID'];
            $book = Book::get_by_url($id);
            if (!$book->ID || $book->HolderPage()->ID != $this->ID) {
                $this->httpError(404);
            }
        } else {
            $this->httpError(404);
        }

        return $this->renderDataObject($book, 'Page', 'Book');
    }

    public function viewChapter() {
        /** @var Chapter $chapter */
        $chapter = null;
        $id = $this->urlParams['ID'];
        $book = Book::get_by_url($id);
        if ($this->urlParams['Number']) {
            $chapterNum = $this->urlParams['Number'];
            $chapter = Chapter::get_by_id('Chapter', $chapterNum);
        } else {
            return $this->renderDataObject($book, 'Page', 'Chapters');
        }

        return $this->renderDataObject($chapter, 'Page', 'Chapter');
    }

    /**
     * @param int $itemsPerPage
     * @param SQLSelect|null $query
     * @return null|PaginatedList
     */
    public function getPaginatedPages($itemsPerPage = 12)
    {
        $pages = new PaginatedList($this->Books(), $this->request);
        $pages->setPageLength($itemsPerPage);

        return $pages;
    }
}
