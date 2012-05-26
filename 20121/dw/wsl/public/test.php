<?php
require_once realpath(dirname(__FILE__) . '/../library/WSL/Loader/Autoloader.php');
$autoloader = WSL_Loader_Autoloader::getInstance();

$adapter = new WSL_Db_Adapter_MySQL(array(
    'host'     => '192.168.10.12',
    'dbname'   => 'wsl',
    'username' => 'root',
    'password' => '102030',
));

$handler = new WSL_Model_File_DbInfoHandler($adapter);
$basedir = realpath(dirname(__FILE__) . '/../data/files');
$tempdir = realpath(dirname(__FILE__) . '/../temp');
WSL_Model_File_File::setDefaultHandler($handler);
WSL_Model_File_File::setBasePath($basedir);
WSL_Model_File_File::setTempPath($tempdir);

$elements = WSL_Model_File_File::findFromReferences('documents', 'element', 1);
$picture = reset($elements);
var_dump($picture->delete());

//$elements = WSL_Model_File_File::findFromHashes(array('308a08ba0c83909a7a435d256585b21310de27d4'));
//$picture = reset($elements);
//var_dump($picture->setContainer('documents')->setCategory('element')->setReference(1)->setFileName('foto.jpg')->save());