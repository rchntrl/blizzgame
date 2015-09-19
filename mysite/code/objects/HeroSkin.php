<?php

class HeroSkin extends DataObject {

    private static $db = array(
        'TitleEN' => 'Varchar(255)',
        'TitleRU' => 'Varchar(255)',
        'Type' => "Enum('Epic, Unique, Legendary')",
        'Content' => 'HTMLText',
    );

    private static $has_one = array(
        'Hero' => 'StormHero',
    );

    private static $summary_fields = array(
        'ID', 'TitleEN', 'TitleRU'
    );
}
