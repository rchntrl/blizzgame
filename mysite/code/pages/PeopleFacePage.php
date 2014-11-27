<?php
class PeopleFacePage extends Page
{

    static $has_many = array (
        'PeopleFaces' => 'PeopleFace'
    );

    public function getCMSFields() {

        $fields = parent::getCMSFields();

        /*	$gridFieldConfig = GridFieldConfig_RecordEditor::create();
            $gridFieldConfig->addComponent(new GridFieldBulkEditingTools());
            $gridFieldConfig->addComponent(new GridFieldBulkImageUpload());
            $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        /**/
        $gridFieldConfig = GridFieldConfig_RelationEditor::create();
        $gridFieldConfig->getComponentByType('GridFieldDataColumns')->setDisplayFields(
            array(
                'TitleEN' => 'TitleEN',
                'TitleRU' => 'TitleRU',
                'Nick' => 'Nick',
            ));
        $gridfield = new GridField("PeopleFaces", "PeopleFaces", $this->PeopleFaces()->sort("TitleEN"), $gridFieldConfig);

        $fields->addFieldToTab('Root.PeopleFaces', $gridfield);

        return $fields;

    }/**/

}

class PeopleFacePage_Controller extends Page_Controller{

	
}
