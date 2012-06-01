<?php

/**
 * Plugin para Compilador
 * Conversor de Arquivo 'document.ps' para 'document.pdf'
 *
 * Utilizado pelo compilador para transformar o arquivo resultado do
 * processamento em conteúdo PDF. Também registra como saída padrão o arquivo
 * manipulado.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
class WSL_Compiler_Plugin_Pdf implements WSL_Compiler_PluginAfterInterface {

    // Execução Posterior
    public function afterAction(WSL_Compiler_Manager $manager) {
        // Plugin para 'document.ps'
        $manager->execute('ps');
        // Criação de Arquivo de Saída
        $manager->getContext()->touch('document.pdf');
        // Criação de Descritores
        $descriptors = array(
            1 => array('pipe', 'w'), // Saída Padrão
            2 => array('pipe', 'w'), // Saída de Erro
        );
        // Processamento
        $process = proc_open('ps2pdf document.ps', $descriptors, $pipes);
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
        // Informar Arquivo de Saída
        $manager->getContext()->setOutput('document.pdf');
    }

}

