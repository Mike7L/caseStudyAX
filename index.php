<?php
define( "APP_ROOT", realpath( dirname( __FILE__ ) ).'/' );

require_once 'Classes/Import.php';
require_once 'Classes/Version.php';
require_once 'Classes/Config.php';
require_once 'Classes/Database.php';

try {
    $version = new Version('Config\version');
    $database = new Database();
    $import = new Import($version, $database);
    $import->start();
} catch (Exception $exc) {
    Logger::getInstance()->reportCriticalError($exc);
}


