<?php

/**
 * Verifica Autenticação no Sistem
 * 
 * @author Wanderson Henrique Camargo Rosa
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
    );

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

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            foreach ($this->getPublic() as $content) {
                $current = array(
                    'module' => $request->getModuleName(),
                    'action' => $request->getActionName(),
                    'controller' => $request->getControllerName(),
                );
                $diff = array_diff($current, $content);
                if (!empty($diff)) {
                    foreach ($content as $position => $value) {
                        $method = sprintf('set%sName', ucfirst($position));
                        $request->$method($value);
                    }
                }
            }
        }
    }
}