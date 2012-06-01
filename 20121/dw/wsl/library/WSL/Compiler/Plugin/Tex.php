<?php

/**
 * Plugin para Compilador
 * Verificador de Criação para 'document.tex'
 *
 * Utilizado para verificação de conteúdo para inicialização do compilador de
 * documentos LaTeX. Basicamente, verifica se o arquivo principal do documento
 * existem, apresentando um erro ao gerenciador de Plugins caso contrário.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
class WSL_Compiler_Plugin_Tex implements WSL_Compiler_PluginBeforeInterface {

    // Execução Anterior
    public function beforeAction(WSL_Compiler_Manager $manager) {
        // Arquivo Principal
        if (!$manager->getContext()->has('document.tex')) {
            // Arquivo não Encontrado. Existe?
            throw new WSL_Compiler_PluginException("Where's 'document.tex'?");
        }
    }

}

