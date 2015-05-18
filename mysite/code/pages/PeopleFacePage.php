<?php

/**
 * Class PeopleFacePage
 *
 * @method HasManyList PeopleFaces
 */
class PeopleFacePage extends Page
{
    private static $has_many = array (
        'PeopleFaces' => 'PeopleFace'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        /** @var GridFieldConfig $gridFieldConfig */
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridField = new GridField("PeopleFaces", _t("PeopleFace.MULTIPLE_CMS_TITLE", "Chronicle Items"), $this->PeopleFaces(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridField, 'MenuTitle');

        return $fields;
    }
}

class PeopleFacePage_Controller extends Page_Controller {

    private static $allowed_actions = array(
        'view',
    );

    private static $url_handlers = array(
        '$ID!' => 'view',
    );

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_TAG')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_TAG')) ? true : false;}

    public function GroupedByAlphabet() {
        $arrayList = new ArrayList();
        $abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i <= 25; $i++) {
            if (isset($abc[$i])) {
                $arrayList->push(new ArrayData(array(
                    'Title' => $abc[$i]
                )));
            }
        }
        return $arrayList;
    }

    public function PeopleFaces() {
        $text = $this->request->getVar('letter') ?: 'A';
        return PeopleFace::get("PeopleFace", "\"PeopleFace\".\"TitleEN\" LIKE '" . $text . "%'");
    }

    public function  getLetter() {
        return $this->request->getVar('letter') ?: 'A';
    }

    public function view() {
        $face = PeopleFace::get_by_url($this->urlParams['ID']);
        if (!$face) {
            $this->httpError(404);
        }
        if ($this->request->isAjax()) {
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
