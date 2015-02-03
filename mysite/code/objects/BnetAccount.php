<?php

/**
 * Class BnetAccount
 *
 * @property int AccountId
 * @property int Name
 * @property string Realm
 * @property string BattleTag
 * @property string DisplayName
 * @property string ClanName
 * @property string ClanTag
 * @property string ProfileUrl
 * @property string Race
 * @property string League
 * @property string TerranWins
 * @property string ProtossWins
 * @property string ZergWins
 * @property string SeasonTotalGames
 * @property string HighestLeague
 * @property string CareerTotalGames
 */
class BnetAccount extends DataObject {

    static $db = array (
        'AccountId' => "Int",
        'Name' => "Int",
        'Realm' => "Varchar",
        'BattleTag' => 'Varchar',
        'DisplayName' => 'Varchar',
        'ClanName' => 'Varchar',
        'ClanTag' => 'Varchar',
        'ProfileUrl' => 'Varchar',
        'Race' => 'Varchar',
        'League' => 'Varchar',
        'TerranWins' => 'Varchar',
        'ProtossWins' => 'Varchar',
        'ZergWins' => 'Varchar',
        'SeasonTotalGames' => 'Varchar',
        'HighestLeague' => 'Varchar',
        'CareerTotalGames' => 'Varchar',
    );

    static $summary_fields = array(
        'Member.Email', 'DisplayName', 'BattleTag'
    );

    public function fill(array $attributes) {
        $this->AccountId = $attributes['id'];
        $this->AccountId = isset($attributes['battleTag']) ? $attributes['battleTag'] : null;
        $this->Realm = $attributes['realm'];
        $this->Name = $attributes['name'];
        $this->DisplayName = $attributes['displayName'];
        $this->ClanName = (isset($attributes['clanName'])) ? $attributes['clanName'] : null;
        $this->ClanTag = (isset($attributes['clanTag'])) ? $attributes['clanTag'] : null;
        $this->ProfileUrl = "http://eu.battle.net/sc2/ru{$attributes['profilePath']}";
        if (isset($attributes['career'])) {
            $career = (is_object($attributes['career'])) ? (array)$attributes['career'] : $attributes['career'];
            $this->Race = (isset($career['primaryRace'])) ? $career['primaryRace'] : null;
            $this->League = (isset($career['league'])) ? $career['league'] : null;
            $this->TerranWins = (isset($career['terranWins'])) ? $career['terranWins'] : null;
            $this->ProtossWins = (isset($career['protossWins'])) ? $career['protossWins'] : null;
            $this->ZergWins = (isset($career['zergWins'])) ? $career['zergWins'] : null;
            $this->HighestLeague = (isset($career['highest1v1Rank'])) ? $career['highest1v1Rank'] : null;
            $this->SeasonTotalGames = (isset($career['seasonTotalGames'])) ? $career['seasonTotalGames'] : null;
            $this->CareerTotalGames = (isset($career['careerTotalGames'])) ? $career['careerTotalGames'] : null;
        }
    }
    public function toArray() {
        return array(
            'AccountId' => $this->AccountId,
            'Realm' => $this->Realm,
            'Name' => $this->Name,
            'DisplayName' => $this->DisplayName,
            'ClanName' => $this->ClanName,
            'ClanTag' => $this->ClanTag,
            'ProfileUrl' => $this->ProfileUrl,
        );
    }
}