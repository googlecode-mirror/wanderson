<?php

/**
 * Controladora Padrão
 * 
 * Classe controladora padrão de requisições não direcionadas. Caso o cliente
 * não forneça uma rota de acesso, esta controladora receberá a requisição.
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @package Application
 * @subpackage Controller
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * Ação Padrão
     * 
     * Método padrão de requisições não direcionadas. Caso o cliente também não
     * forneça uma ação específica, esta receberá a requisição.
     * 
     * @return void
     */
    public function indexAction()
    {
        
    }
}