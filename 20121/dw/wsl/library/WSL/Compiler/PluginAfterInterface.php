<?php

/**
 * Execução Pós Compilação
 *
 * Elemento utilizado para construção de tipagem para definição de plugins que
 * podem ser executados após a compilação. Este elemento deve ser utilizado
 * sempre que uma classe necessita ser executada naquele ponto.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
interface WSL_Compiler_PluginAfterInterface {

    /**
     * Execução Pós Compilação
     *
     * Método definido para execução após o término da compilação do gerenciador
     * para o documento em LaTeX.
     *
     * @param  WSL_Compiler_Manager $manager Gerenciador Utilizado
     * @return null
     */
    public function afterAction(WSL_Compiler_Manager $manager);

}
