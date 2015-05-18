<?php

class LessController extends Controller {

    private static $allowed_actions = array(
        'variables',
    );

    public function getBaseUrl() {
        return Director::BaseURL();
    }

    public function variables() {
        $ssv = new SSViewer('Less');
        $this->response->addHeader("Content-Type", "text/css");
        return $this->renderWith($ssv);
    }

    public function index() {
        $ssv = new SSViewer('Less');
        $this->response->addHeader("Content-Type", "text/css");
        echo $this->renderWith($ssv);
    }

}
