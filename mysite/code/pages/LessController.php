<?php

class LessController extends Controller {

    public static $allowed_actions = array(
        'variables',
    );

    public function getBaseUrl() {
        return Director::BaseURL();
    }

    public function Link() {
        //var_dump($this->request-)); exit();
    }
    public function variables() {
        $ssv = new SSViewer('Less');
        $ssv->setTemplateFile('Layout', 'LessVariables');
        $this->response->addHeader("Content-Type", "text/css");
        return $this->renderWith($ssv);
    }

    public function index() {
        $ssv = new SSViewer('Less');
        $ssv->setTemplateFile('Layout', 'LessVariables');
        header('Content-type: text/css');
        echo $this->renderWith($ssv);
    }
} 