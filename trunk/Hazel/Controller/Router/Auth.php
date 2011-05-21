<?php

/**
 * Rota de Autenticação
 * 
 * Trabalha sobre o roteamento para modificar a rota caso o usuário não esteja
 * autenticado no sistema, utilizando componentes do próprio Zend Framework
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel_Controller
 */
class Hazel_Controller_Router_Auth extends Zend_Controller_Router_Route
{
    /**
     * Rota de Autenticação
     * @var string
     */
    protected $_route = '/login';

    /**
     * Valores Padrão
     * @var array
     */
    protected $_defaults = array(
        'module' => 'default', 'controller' => 'auth', 'action' => 'login'
    );

    public function __construct()
    {
        /* Informações */
        $route    = $this->getRoute();
        $defaults = $this->getDefaults();
        /* Construtor */
        parent::__construct($route, $defaults);
    }

    /**
     * Configura a Rota de Autenticação
     * @param string $route Valor para Configuração
     * @return Hazel_Controller_Router_Auth Próprio Objeto para Encadeamento
     */
    public function setRoute($route)
    {
        $this->_route = $route;
        return $this;
    }

    /**
     * Informa a Rota de Autenticação
     * @return string Valor Solicitado
     */
    public function getRoute()
    {
        return $this->_route;
    }

    public function match($path)
    {
        /* Não Modificar a Rota */
        $result = false;
        /* Autenticador */
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            /* Não Há Usuário Autenticado */
            /* Modifique Utilizando Esta Rota */
            $result = $this->getDefaults();
        }
        return $result;
    }
}