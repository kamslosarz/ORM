<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
set_include_path(dirname(__DIR__));

define('FIXTURES', __DIR__ . '/fixtures');
define('DATABASE_STRUCTURE_FILE', FIXTURES . '/database.sql');


include 'vendor/autoload.php';
