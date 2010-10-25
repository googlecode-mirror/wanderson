<?php

/**
 * Controladora Principal do Sistema
 * 
 * Trabalha como controladora padrão do sistema, possibilitando o acesso direto
 * pelos parâmetros já configurados.
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @package Application
 * @subpackage Controller
 * @see http://code.google.com/p/wanderson/
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * Ação Padrão
     * 
     * Método principal da controladora que é acessado quando não são fornecidos
     * parâmetros. Página inicial do aplicativo.
     * 
     * @return void
     */
    public function indexAction()
    {
        
    }

    /**
     * Sobre o Aplicativo
     * 
     * Descreve o aplicativo e trabalha como um centralizador de informações,
     * incluindo dados pessoais, meios de contato e objetivos.
     * 
     * @return void
     */
    public function sobreAction()
    {
        
    }
}