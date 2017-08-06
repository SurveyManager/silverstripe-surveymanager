<?php

global $project;
$project = 'SurveyManager';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'barracuda',
	'database' => 'SilverStrip_simple',
	'path' => ''
);

// Set the site locale
// i18n::set_locale('ru_RU');
   i18n::set_locale('en_GB');
   
Security::setDefaultAdmin('daniell', '3264');
