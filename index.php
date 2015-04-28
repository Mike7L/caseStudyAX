<?php
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Schwacke');

ini_set('xdebug.var_display_max_children', 26 );
ini_set('xdebug.var_display_max_data', 20 );
ini_set('xdebug.var_display_max_depth', 7 );

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
    echo 'ERROR: ' .$exc->getMessage().'<br>';
}


