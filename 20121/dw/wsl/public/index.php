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
    ->setMapper('Model', realpath(APPLICATION_PATH . '/models'))
    ->setMapper('Service', realpath(APPLICATION_PATH . '/services'));
// Elementos de Fluxo
$request  = new WSL_Controller_Request();
$response = new WSL_Controller_Response();
// Caminhos de Renderização
$front->getView()->addScriptPath(realpath(APPLICATION_PATH . '/views'));
// Configurações
$front->getConfig()->setParam('Layout.enabled', true);
// Banco de Dados
$adapter = new WSL_Db_Adapter_MySQL(array(
    'host'     => 'localhost',
    'dbname'   => 'wsl',
    'username' => 'root',
    'password' => '102030',
));
// Registrar Adaptador
$front->getConfig()->setParam('Db.adapter', $adapter);
// Camada de Arquivos
$handler = new WSL_Model_File_DbInfoHandler($adapter);
WSL_Model_File_File::setDefaultHandler($handler);
WSL_Model_File_File::setBasePath(realpath(APPLICATION_PATH . '/../data/files'));
WSL_Model_File_File::setTempPath(realpath(APPLICATION_PATH . '/../temp'));
// Compilador
WSL_Compiler_Context::setWorkspacePath(realpath(APPLICATION_PATH . '/../temp'));
// Execução
try {
    $front->dispatch($request, $response);
    // Exibição de Saída
    $response->send();
} catch (Exception $e) {
    // Erro Encontrado
    echo "<pre>$e</pre>";
}

