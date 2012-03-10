<?php
// Requisição de Configurações
require_once dirname(__FILE__) . '/../config.php';

// Resultados de Operação
define('POKEFLUTE_FILENOTFOUND', -1);

// Camada de Modelo
$mMusics = new \Model\Musics();

// Bloco de Comandos
switch (@$argv[1]) {
    // Adicionar Arquivo
    case 'add':
        // Verificar Arquivo
        if (!empty($argv[2]) && is_file($argv[2])) {
            // Adicionar Arquivo
            $mMusics->addFilename($argv[2]);
        } else {
            // Erro Encontrado
            exit(POKEFLUTE_FILENOTFOUND);
        }
        break;
    // Remover Arquivo
    case 'remove':
        // Verificar Arquivo
        if (!empty($argv[2])) {
            // Remover Arquivo
            $mMusics->removeFilename($argv[2]);
        } else {
            // Erro Encontrado
            exit(POKEFLUTE_FILENOTFOUND);
        }
    // Consulta Randômica
    default:
        // Executar Pesquisa
        echo $mMusics->random() . PHP_EOL;
        break;
}

