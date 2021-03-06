<?php

/**
 * Class HeroSpeech
 *
 * @property String $Type
 * @property String $Tone
 * @property String $Phrase
 * @property String $OriginalPhrase
 * @method StormHero From()
 * @method StormHero To()
 * @method HeroTag Tag()
 * @method HeroSkin Skin()
 * @method HeroSpeech Speech()
 */
class HeroSpeech extends DataObject {
    const
        QUESTION = 'Question',
        RESPONSE = 'Response';

    private static $db = array(
        'Type' => "Enum('Pissed, Question, Response, WhenKill, Other', 'Pissed')",
        'Tone' => "Enum('None, Negative, Positive, Neutral, Other')",
        'Phrase' => 'Text',
        'OriginalPhrase' => 'Text',
        'Reference' => 'Varchar',
    );

    private static $has_one = array(
        'To' => 'StormHero',
        'Skin' => 'HeroSkin',
        'Tag' => 'HeroTag',
        'From' => 'StormHero',
        'Speech' => 'HeroSpeech',
    );

    private static $default_sort = "\"ToID\" DESC, \"TagID\" DESC";

    private static $summary_fields = array(
        'ID', 'Type', 'Phrase', 'To.TitleRU', 'Tag.TitleRU', 'Skin.TitleRU'
    );

    private static $searchable_fields = array(
        'Type', 'From.TitleRU'
    );

    private static $field_labels = array(
        'To.TitleRU' => 'Mate',
        'Tag.TitleRU' => 'Tag',
        'Skin.TitleRU' => 'Skin',
        'From.TitleRU' => 'Speech Owner (Ru)',
    );

    public static $api_access = array(
        'view' => array(
            'Type', 'Tone', 'Phrase', 'OriginalPhrase', 'Intro', 'MateOriginalPhrase', 'MatePhrase',
            'SkinOwnerID', 'SkinIconSrc', 'TagIconSrc',
            'TagTitle'
        ),
    );

    /**
     * @var HeroSpeech
     */
    private $mateSpeech;

    public function canCreate($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canEdit($Member = null) {return (permission::check('CREATE_EDIT_HERO')) ? true : false;}
    public function canDelete($Member = null) {return (permission::check('DELETE_HERO')) ? true : false;}
    public function canView($member = null) {return true;}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->replaceField('Type', new OptionsetField('Type', 'Type', $fields->dataFieldByName('Type')->getSource()));
        $fields->replaceField('FromID', new HasOnePickerField($this, 'FromID', 'From', $this->From()));
        $fields->replaceField('ToID', StormHero::getHeroesField('ToID', 'To'));
        $fields->replaceField('TagID', HeroTag::getListField('TagID', 'To'));
        $fields->replaceField('SkinID', HeroSkin::getListField('SkinID', 'Skin'));
        if ($this->ID) {
            $fields->replaceField('SpeechID', new HasOnePickerField($this, 'SpeechID', 'Mate Speech', $this->Speech()));
        }
        return $fields;
    }

    public function getTitle() {
        return $this->Phrase;
    }

    public function getTagTitle() {
        return $this->Tag()->getTitle();
    }

    public function getIntro() {
        return in_array($this->Type, array('Question', 'Response'));
    }

    public function getMatePhrase() {
        return $this->getMateSpeech() ? $this->getMateSpeech()->Phrase : '???';
    }

    public function getMateOriginalPhrase() {
        return $this->getMateSpeech() ? $this->getMateSpeech()->OriginalPhrase : '???';
    }

    public function getTagIconSrc() {
        return $this->TagID ? $this->Tag()->getIconSrc() : null;
    }

    public function getSkinIconSrc() {
        if ($this->SkinID) {
            return $this->Skin()->getIconSrc();
        }
        return 0;
    }

    public function getSkinOwnerID() {
        if ($this->SkinID) {
            return $this->Skin()->HeroID;
        }
        return 0;
    }

    public function getOwnerIconSrc() {
        return $this->getSkinOwnerID() == $this->FromID ? $this->getSkinIconSrc() : $this->From()->getIconSrc();
    }

    public function getMateIconSrc() {
        return $this->getSkinOwnerID() == $this->ToID ? $this->getSkinIconSrc() : $this->To()->getIconSrc();
    }

    /**
     * @return HeroSpeech|null
     */
    public function getMateSpeech() {
        if (!$this->mateSpeech) {
            if ($this->SpeechID) {
                $this->mateSpeech = $this->Speech();
                return $this->mateSpeech;
            }
            $type = null;
            switch ($this->Type) {
                case HeroSpeech::QUESTION:
                    $type = HeroSpeech::RESPONSE;
                    break;
                case HeroSpeech::RESPONSE:
                    $type = HeroSpeech::QUESTION;
                    break;
                default:
                    return null;
                    break;
            }
            $this->mateSpeech = HeroSpeech::get_one('HeroSpeech',
                'HeroSpeech.FromID = ' . $this->ToID
                . ' AND HeroSpeech.SkinID = ' . $this->SkinID // skin speech
                . ' AND HeroSpeech.ToID = ' . $this->FromID
                . ' AND HeroSpeech.Type = \'' . $type . '\''
            );
            if (!$this->mateSpeech) {
                $this->mateSpeech = HeroSpeech::get_one('HeroSpeech',
                    'HeroSpeech.FromID = ' . $this->ToID
                    . ' AND HeroSpeech.ToID = ' . $this->FromID
                    . ' AND HeroSpeech.Type = \'' . $type . '\''
                );
            }
            if (!$this->mateSpeech && $idList = implode(', ', $this->From()->Tags()->getIDList())) {
                // пробуем подставить фразу, обращенную к герою по его признаку
                $this->mateSpeech = HeroSpeech::get_one('HeroSpeech',
                    'HeroSpeech.FromID = ' . $this->ToID
                    . ' AND HeroSpeech.TagID IN(' . $idList . ')'
                    . ' AND HeroSpeech.Type = \'' . $type . '\''
                );
            }
        }

        return $this->mateSpeech;
    }
}
