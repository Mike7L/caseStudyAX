<?php
set_include_path('D:\Code\_li
bs\zend\library' . PATH_SEPARATOR . get_include_path());
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();


require_once 'Classes/Import.php';
require_once 'Classes/Version.php';

$version = new Version('Config\version.xml');
$import = new Import($version );
$import->start();
