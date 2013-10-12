<?php
/*

File:		Library Root File
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/php-core.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core

*/

#load the settings for the library
require_once("settings.php");

#load all the modules for the library
require_once("helpers/email.php");
require_once("helpers/data.php");
require_once("helpers/datetime.php");
require_once("helpers/debug.php");
require_once("helpers/errors.php");
require_once("helpers/strings.php");

require_once("classes/database/mysql.class.php");

?>