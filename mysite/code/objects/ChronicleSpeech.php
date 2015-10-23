<?php

/**
 * Class ChronicleSpeech
 *
 * @method ElementLink To()
 * @method ElementLink From()
 * @method ChronicleSpeech Speech()
 */
class ChronicleSpeech extends DataObject {

    private static $db = array(
        'SortOrder' => 'Int',
        'Type' => "Enum('action, cry, description, say, whisper')",
        'Phrase' => 'Text',
    );

    private static $has_one = array(
        'To' => 'ElementLink',
        'From' => 'ElementLink',
        'Speech' => 'ChronicleSpeech',
        'PageElement' => 'PageElement',
    );

    private static $default_sort = "\"SortOrder\" ASC";

    function canCreate($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canEdit($Member = null) {return (permission::check('CREATE_EDIT_CHRONICLE')) ? true : false;}
    function canDelete($Member = null) {return (permission::check('DELETE_CHRONICLE')) ? true : false;}
    function canView($Member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->replaceField('Type', new OptionsetField('Type', 'Type', $fields->dataFieldByName('Type')->getSource()));
        if ($this->ID) {
            $fields->replaceField('FromID', new HasOnePickerField($this, 'FromID', 'From', $this->From()));
            $fields->replaceField('ToID', new HasOnePickerField($this, 'ToID', 'To', $this->From()));
            $fields->replaceField('SpeechID', new HasOnePickerField($this, 'SpeechID', 'Mate Speech', $this->Speech()));
        }
        return $fields;
    }
}
