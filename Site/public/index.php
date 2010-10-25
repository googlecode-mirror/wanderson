<?php

/*
 * Definição de Constante
 * Caminho do Diretório do Aplicativo
 */
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
        realpath(dirname(__FILE__) . '/../application'));

/*
 * Definição de Constante
 * Ambiente de Execução do Sistema
 * Não sobrescreve o ambiente definido no arquivo de acesso do Apache
 */
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV')
        ? getenv('APPLICATION_ENV') : 'production'));

/*
 * Diretório de Biblioteca Compartilhada
 */
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Application.php';

try {
    $application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
    );
    $application->bootstrap()->run();
} catch (Exception $e) {
    /*
     * Última Captura de Erros
     * Exceções não capturadas pelo aplicativo em tempo de execução
     */
    header('Content-type: text/plain');
    echo $e;
}