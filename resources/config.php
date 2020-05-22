<?php

ob_start();

session_start();
//session_destroy();

define('TIMEZONE', 'Europe/Kiev');
date_default_timezone_set(TIMEZONE);
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates\\front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates\\back");

defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS", "");
defined("DB_NAME") ? null : define("DB_NAME", "sumoist_db");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$connection->set_charset("utf8");

require_once("functions.php");

?>