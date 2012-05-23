<?php
require_once realpath(dirname(__FILE__) . '/../library/WSL/Loader/Autoloader.php');
$autoloader = WSL_Loader_Autoloader::getInstance();

$context = new WSL_Compiler_Context();
$context->setWorkspacePath(realpath(dirname(__FILE__) . '/../temp'));

$context
    ->setElement('document.tex', 'document.tex')
    ->setElement('document.dvi', 'document.dvi');

$compiler = new WSL_Compiler_Manager($context);
$compiler->setBeforePlugin('tex')->setAfterPlugin('dvi');

$compiler->compile();