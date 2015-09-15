<?php

/**
 * Class HeroSpeech
 *
 * @method StormHero From()
 * @method  StormHero To()
 */
class HeroSpeech extends DataObject {

    private static $db = array(
        'Type' => "Enum('Pissed, Question, Response, WhenKill', 'Pissed')",
        'Tone' => "Enum('None, Negative, Positive, Neutral')",
        'Phrase' => 'Text',
        'OriginalPhrase' => 'Text',
    );

    private static $has_one = array(
        'To' => 'StormHero',
        'From' => 'StormHero',
    );

    private static $summary_fields = array(
        'ID', 'Type', 'Phrase', 'To.TitleRU'
    );

    private static $searchable_fields = array(
        'Type'
    );

    private static $field_labels = array(
        'To.TitleRU' => 'To',
    );

    public static $api_access = array(
        'view' => array(
            'Type', 'Phrase', 'OriginalPhrase',
        ),
    );

    public function canCreate($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canEdit($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canDelete($Member = null) {return (permission::check('DELETE_HERO')) ? true : false;}
    public function canView($member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->replaceField('FromID', new HasOnePickerField($this, 'FromID', 'From', $this->From()));
        $toField = new HasOnePickerField($this, 'ToID', 'To', $this->To());
        if (empty($this->ID)) {
            $toField = StormHero::getHeroesField('ToID', 'To');
        }
        $fields->replaceField('ToID', $toField);
        return $fields;
    }
}
