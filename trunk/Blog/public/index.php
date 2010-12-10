<?php
/**
 * Incializador do Aplicativo
 * 
 * Arquivo de inicialização do aplicativo Zend Framework, que trabalha como
 * centralizador de requisições do cliente. Todas as páginas disponíveis devem
 * ser acessadas através deste arquivo.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */

/*
 * Definição de Ambiente de Desenvolvimento
 */
define('APPLICATION_ENV', 'development');

/*
 * Caminho do Diretório Principal do Aplicativo
 */
defined('APPLICATION_PATH') ||
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

/*
 * Definição do Ambiente Executável
 */
defined('APPLICATION_ENV') ||
    define('APPLICATION_ENV',
        (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/*
 * Inclusão da Biblioteca Local
 */
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

/*
 * Inicialização do Aplicativo Zend Framework
 */
require_once 'Zend/Application.php';
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

/*
 * Última Camada de Captura de Exceções
 */
try {
    /*
     * Execução do Aplicativo
     */
    $application->bootstrap()->run();
} catch (Exception $e) {
    header('Content-type: text/plain');
    echo $e;
}