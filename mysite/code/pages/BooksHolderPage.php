<?php

class BooksHolderPage extends Page {

    static $has_many = array (
        'Books' => 'Book'
    );

}

class BooksHolderPage_Controller extends Page_Controller {

}
