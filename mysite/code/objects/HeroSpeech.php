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
 * @method HeroTag ToSeveral()
 * @method HeroSkin Skin()
 */
class HeroSpeech extends DataObject {
    const
        QUESTION = 'Question',
        RESPONSE = 'Response';

    private static $db = array(
        'Type' => "Enum('Pissed, Question, Response, WhenKill, Boast', 'Pissed')",
        'Tone' => "Enum('None, Negative, Positive, Neutral, Other')",
        'Phrase' => 'Text',
        'OriginalPhrase' => 'Text',
    );

    private static $has_one = array(
        'To' => 'StormHero',
        'Skin' => 'HeroSkin',
        'ToSeveral' => 'HeroTag',
        'From' => 'StormHero',
    );

    private static $summary_fields = array(
        'ID', 'Type', 'Phrase', 'To.TitleRU', 'ToSeveral.TitleRU', 'Skin.TitleRU'
    );

    private static $searchable_fields = array(
        'Type'
    );

    private static $field_labels = array(
        'To.TitleRU' => 'To',
        'ToSeveral.TitleRU' => 'Tag',
        'Skin.TitleRU' => 'Skin',
    );

    public static $api_access = array(
        'view' => array(
            'Type', 'Tone', 'Phrase', 'OriginalPhrase', 'Intro', 'MateOriginalPhrase', 'MatePhrase',
            'SkinOwnerID', 'SkinIconSrc',
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
        $fields->replaceField('ToSeveralID', HeroTag::getListField('ToSeveralID', 'To'));
        $fields->replaceField('SkinID', HeroSkin::getListField('SkinID', 'Skin'));
        return $fields;
    }

    public function getIntro() {
        return in_array($this->Type, array('Question', 'Response'));
    }

    public function getMatePhrase() {
        return $this->getMateSpeech()->Phrase;
    }

    public function getMateOriginalPhrase() {
        return $this->getMateSpeech()->OriginalPhrase;
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

    public function getMateSpeech() {
        if (!$this->mateSpeech) {
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
                // пробуем подставить фразу, обращенную к герою по его признаку
                $idList = implode(', ', $this->From()->Tags()->getIDList());
                $this->mateSpeech = HeroSpeech::get_one('HeroSpeech',
                    'HeroSpeech.FromID = ' . $this->ToID
                    . ($idList ? ' AND HeroSpeech.ToSeveralID IN(' . $idList . ')' : '')
                    . ' AND HeroSpeech.Type = \'' . $type . '\''
                );
            }
        }

        return $this->mateSpeech;
    }
}
