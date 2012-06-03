<?php

/**
 * Plugin para Compilador
 * Compactação de Diretório de Trabalho
 *
 * Utilizado para capturar todos os arquivos gerados no servidor, compactando-os
 * de forma que o conteúdo gerado pelo compilador seja apresentado ao cliente.
 * Também pode ser chamado durante o início da compilação, descompactando um
 * arquivo enviado pelo cliente e posteriormente executando o Plugin básico de
 * conteúdo LaTeX para confirmar existência de arquivo.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
class WSL_Compiler_Plugin_TarGz implements
    WSL_Compiler_PluginBeforeInterface, WSL_Compiler_PluginAfterInterface {

    // Execução Anterior
    public function beforeAction(WSL_Compiler_Manager $manager) {
        // Criação de Descritores
        $descriptors = array(
            1 => array('pipe', 'w'), // Saída Padrão
            2 => array('pipe', 'w'), // Saída de Erro
        );
        // Processamento
        $process = proc_open('tar xzf document.tar.gz .', $descriptors, $pipes);
        // Recurso Inicializado?
        if (is_resource($process)) {
            // Execução de Processo
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            // Finalizar Pipes
            fclose($pipes[1]);
            fclose($pipes[2]);
            // Finalizar Processo
            $result = proc_close($process);
        }
        // Execução de Plugin
        $manager->execute('tex');
    }

    // Execução Posterior
    public function afterAction(WSL_Compiler_Manager $manager) {
        // Plugin para 'document.pdf'
        $manager->execute('pdf');
        // Criação de Descritores
        $descriptors = array(
            1 => array('pipe', 'w'), // Saída Padrão
            2 => array('pipe', 'w'), // Saída de Erro
        );
        // Processamento
        $process = proc_open('tar cpzf document.tar.gz *', array(), $pipes);
        // Recurso Inicializado?
        if (is_resource($process)) {
            // Saídas Padrão e de Erro
            $stdout = '';
            $stderr = '';
            // Ocioso
            $idle = true;
            // Executar até Finalização
            while ($idle) {
                // Tempo Ocioso
                usleep(500); // 0.5 Segundos
                // Capturar Saídas
                $stdout = $stdout . stream_get_contents($pipes[1]);
                $stderr = $stderr . stream_get_contents($pipes[2]);
                // Informações sobre Processo
                $information = proc_get_status($process);
                // Continuar Ocioso?
                $idle = (($information !== false) && ($information['running']));
            }
            // Finalizar Pipes
            fclose($pipes[1]);
            fclose($pipes[2]);
            // Finalizar Processo
            proc_close($process);
        }
        // Criação de Arquivo de Saída
        $manager->getContext()->touch('document.tar.gz');
        // Informar Arquivo de Saída
        $manager->getContext()->setOutput('document.tar.gz');
    }
}

