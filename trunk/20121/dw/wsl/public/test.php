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
var_dump($picture->save());