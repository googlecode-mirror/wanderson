<?php

/**
 * Execução Pré Compilação
 *
 * Elemento utilizado para construção de tipagem para definição de plugins que
 * podem ser executados antes da compilação. Este elemento deve ser utilizado
 * sempre que uma classe necessita ser executada naquele ponto.
 *
 * @category   WSL
 * @package    WSL_Compiler
 * @subpackage Plugin
 */
interface WSL_Compiler_PluginBeforeInterface {

    /**
     * Execução Pré Compilação
     *
     * Método definido para execução antes do término da compilação do
     * gerenciador para o documento em LaTeX.
     *
     * @param  WSL_Compiler_Manager $manager Gerenciador Utilizado
     * @return null
     */
    public function beforeAction(WSL_Compiler_Manager $manager);

}
