<?php

class BnetMemberExtension extends DataExtension {

    static $db = array (
        'NickName' => 'Varchar'
    );

    private static $has_one = array(
        "BattleAccount" => "BNetAccount"
    );


}