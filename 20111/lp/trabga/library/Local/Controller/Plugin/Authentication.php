<?php

/**
 * Verifica Autenticação no Sistem
 * 
 * @category   Local
 * @package    Local_Controller
 * @subpackage Plugin
 */
class Local_Controller_Plugin_Authentication
    extends Zend_Controller_Plugin_Abstract
{
    /**
     * Endereços Públicos do Sistema
     * @var array
     */
    protected $_public = array(
        'login' => array(
            'module' => 'default',
            'action' => 'login',
            'controller' => 'auth',
        ),
        'cadastro' => array(
            'module' => 'default',
            'action' => 'cadastro',
            'controller' => 'index',
        ),
    );

    /**
     * Endereço Público para Redirecionamento
     * @var string
     */
    protected $_redirect = 'login';

    /**
     * Adiciona um Endereço Público
     * @param string $label   Etiqueta para Identificaçaõ
     * @param string $content Conteúdo do Nó
     * @return Local_Controller_Plugin_Authentication Próprio Objeto para Encadeamento
     */
    public function addPublic($label, array $content)
    {
        $this->_public[$label] = $content;
        return $this;
    }

    /**
     * Seleciona um Grupo confome Conjunto Informado
     * @return array Conjunto com Valores Solicitados
     */
    public function getPublic()
    {
        return $this->_public;
    }

    /**
     * Informa a Página Públic Padrão para Redirecionamento
     * @return array Conjunto de Roteamento para Página Pública
     */
    public function getRedirect()
    {
        $public   = $this->getPublic();
        $redirect = $this->_redirect;
        if (!array_key_exists($redirect, $public)) {
            throw new Zend_Controller_Exception('Invalid Public');
        }
        return $public[$redirect];
    }

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $params = array();
            $keywords = array('module', 'controller', 'action');
            foreach ($keywords as $keyword) {
                $params[$keyword] = $request->getParam($keyword);
            }
            foreach ($this->getPublic() as $element) {
                $result = array_diff($element, $params);
                if (!empty($result)) {
                    $redirect = $this->getRedirect();
                    foreach ($keywords as $keyword) {
                        $method = 'set' . ucfirst($keyword) . 'Name';
                        $request->$method($redirect[$keyword]);
                    }
                    break;
                }
            }
        }
    }
}