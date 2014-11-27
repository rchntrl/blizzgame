<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => 'MySQLDatabase',
	"server" => 'localhost',
	"username" => 'root',
	"password" => '',
	"database" => 'blizzgame',
	"path" => '',
);

// Set the site locale
i18n::set_locale('ru_RU');

FulltextSearchable::enable();

//SS_Log::add_writer(new SS_LogEmailWriter('Archan1c@yandex.com'), SS_Log::ERR, '<=');