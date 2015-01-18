<?php

/**
 * Class BooksHolderPage
 * @method SS_List Books()
 */
class BooksHolderPage extends Page {

    static $has_many = array (
        'Books' => 'Book'
    );

    public function getCMSFields() {

        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new GridFieldBulkManager());
        $fields->removeFieldFromTab('Root.Main', 'Content');
        // Customize GridField
        $gridFieldConfig->removeComponentsByType('GridFieldPaginator'); // Remove default paginator
        $gridFieldConfig->addComponent(new GridFieldPaginator(20)); // Add custom paginator
        $gridFieldConfig->addComponent(new GridFieldFilterHeader('AuthorID'));
        $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton'); // We only use bulk upload button
        // Creates sortable grid field
        $gridField = new GridField("Books", _t("Gallery.LIBRARY_CMS_TITLE", "Books"), $this->Books(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'Metadata');

        return $fields;
    }
}

class BooksHolderPage_Controller extends Page_Controller {

    static $url_handlers = array(
        'author/$ID!' => 'viewAuthor',
        'size/$ID!' => 'viewSize',
        'tag/$ID!' => 'viewTag',
        '$ID!' => 'view',
    );

    /**
     * @return SQLQuery
     */
    public function getQueryBuilder() {
        $qb = new SQLQuery();
        $qb
            ->setFrom('Book')
            ->setOrderBy(array('Book.Created DESC'))
            ->setWhere('Book.HolderPageID = ' . $this->ID) // Books must belong to this page
        ;
        return $qb;
    }

    /**
     * @param SQLQuery $qb
     * @return SQLQuery
     */
    public function applyFiltersFromRequest(SQLQuery $qb) {

        return $qb;
    }

    /**
     * @param int $itemsPerPage
     * @param SQLQuery|null $query
     * @return null|PaginatedList
     */
    public function getPaginatedPages(SQLQuery $query = null,  $itemsPerPage = 16)
    {
        if (!$query) {
            $query = $this->getQueryBuilder();
        }
        $query = $this->applyFiltersFromRequest($query); // additional filters based on url params
        $start = $this->request->getVar('start');
        $query->setLimit($itemsPerPage, $start ?: 0);
        $books = new ArrayList();
        $records = $query->execute();
        foreach($records as $rowArray) {
            $books->push(new Book($rowArray));
        }
        //exit($books->count());
        $pages = new PaginatedList($books, $this->request);
        $pages
            ->setLimitItems(false)
            ->setPaginationFromQuery($query)
        ;

        return $pages;
    }
}
