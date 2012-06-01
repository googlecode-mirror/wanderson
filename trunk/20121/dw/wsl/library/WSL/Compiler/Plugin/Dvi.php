<?php

/**
 * Plugin para Compilador
 * Verificador de Criação para 'document.dvi'
 *
 * Utilizado pelo compilador para verificação de existência do arquivo
 * resultante do processamento principal do conteúdo. Verifica se o arquivo
 * principal resultante existe apresentando um erro caso contrário.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
class WSL_Compiler_Plugin_Dvi implements WSL_Compiler_PluginAfterInterface {

    // Execução Posterior
    public function afterAction(WSL_Compiler_Manager $manager) {
        // Arquivo Principal
        if (!$manager->getContext()->has('document.dvi')) {
            // Arquivo não Encontrado. Existe?
            throw new WSL_Compiler_PluginException("Where's 'document.dvi'?");
        }
    }

}

