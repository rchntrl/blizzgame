<?php

class PeopleFacePage extends Page
{
    static $has_many = array (
        'PeopleFaces' => 'PeopleFace'
    );

}

class PeopleFacePage_Controller extends Page_Controller {

    static $allowed_actions = array(
        'view',
    );

    static $url_handlers = array(
        '$ID!' => 'view',
    );

    public function view() {
        $face = PeopleFace::get_by_url($this->urlParams['ID']);
        if (!$face) {
            $this->httpError(404);
        }
        if ($this->request->isAjax() && $this->request->getVar('start')) {
            return $this->loadArts($face);
        }
        $ssv = new SSViewer('Page');
        $ssv->setTemplateFile('Layout', 'PeopleFace');
        return $this->customise($face)->renderWith($ssv);
    }

    /**
     * @param PeopleFace $face
     * @return HTMLText
     */
    public function loadArts($face) {
        $arts = new PaginatedList($face->GalleryImages(), $this->request);
        $arts->setPageLength(12);
        $ssv = new SSViewer('Arts');
        return $this->customise(array('GalleryImages' => $arts))->renderWith($ssv);
    }
}
