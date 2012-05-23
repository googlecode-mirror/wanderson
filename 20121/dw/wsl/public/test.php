<?php
require_once realpath(dirname(__FILE__) . '/../library/WSL/Loader/Autoloader.php');
$autoloader = WSL_Loader_Autoloader::getInstance();

WSL_Compiler_Context::setWorkspacePath(realpath(dirname(__FILE__) . '/../temp'));
$context = new WSL_Compiler_Context();

$context
    ->copy('document.tex', '/home/wanderson/Desktop/README')
    ->touch('document.dvi');

$compiler = new WSL_Compiler_Manager($context);
$compiler->setBeforePlugin('tex')->setAfterPlugin('dvi');

$compiler->compile();