<?php

/**
 * Class MainPage
 */
class MainPage extends Page {

}

/**
 * Class MainPage_Controller
 */
class MainPage_Controller extends Page_Controller {

    public function allNews() {

        $allEntries = News::get()->limit(10);

        return $allEntries;
    }
}
