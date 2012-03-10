<?php
// Configurações Iniciais
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));
define('APPLICATION_ENV', 'development');
// Caminho de Inclusão
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));
// Carregamento Automático
require_once 'Pokeflute/Autoloader.php';
\Pokeflute\Autoloader::getInstance();
// Configurações
$config = \Pokeflute\Multiton::getInstance('Pokeflute\\Config');
$config->set('music.directory', APPLICATION_PATH . '/../data/musics')
       ->set('music.server', 'http://localhost:7999');
