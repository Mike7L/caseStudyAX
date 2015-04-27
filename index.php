<?php
set_include_path('D:\Code\_libs\zend\library' . PATH_SEPARATOR . get_include_path());
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();

ini_set('xdebug.var_display_max_children', 6 );
ini_set('xdebug.var_display_max_data', 20 );
ini_set('xdebug.var_display_max_depth', 7 );

require_once 'Classes/Import.php';
require_once 'Classes/Version.php';

$version = new Version('Config\version');
$import = new Import($version);
$import->start();
