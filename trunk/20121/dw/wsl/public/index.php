<?php
// Ambiente de Software
define('APPLICATION_ENV', 4);
// Diretório do Aplicativo
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
// Inicialização de Caminho de Inclusão
set_include_path(implode(PATH_SEPARATOR, array(
    dirname(APPLICATION_PATH) . '/library',
    get_include_path(),
)));
// Carregamento
require_once 'WSL/Loader/Autoloader.php';
// Autocarregador de Classes
$autoloader = WSL_Loader_Autoloader::getInstance();
// Controladora Frontal
$front = WSL_Controller_Front::getInstance();
// Mapeamento de Camadas
$autoloader
    ->setMapper('Controller', realpath(APPLICATION_PATH . '/controllers'))
    ->setMapper('Model', realpath(APPLICATION_PATH) . '/models');
// Execução
$front->dispatch();

