<?php

// Ambiente de Execução
//$environment = 'production';
$environment = 'development';

// Definição de Caminho do Aplicativo
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Definição do Ambiente de Execução
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : $environment));

// Configuração do Caminho de Pesquisa de Arquivos
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

// Zend Application
require_once 'Zend/Application.php';

// Inicialização do Aplicativo
try {
    $application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
    );
    $application->bootstrap()->run();
} catch (Exception $e) {
    header('Content-Type: text/plain');
    echo $e;
}