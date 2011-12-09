<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace \Hazel\Shop\Basket\Storage;

/**
 * Camada de Persistência para Sessão
 *
 * Utilizando a sessão da requisição feita pelo navegador, é possivel armazenar
 * informações do Carrinho de Compras para que esta esteja disponível entre as
 * solicitações feitas ao servidor.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
class Session implements StorageInterface {

    /**
     * Parâmetros
     * @var array
     */
    protected $_params = array();

    /**
     * Elemento de Sessão
     * @var Zend_Session_Namespace
     */
    protected $_session;

    /**
     * Configuração de Parâmetros
     *
     * Possibilidade de encapsulamento dos parâmetros de construção com
     * informações importantes para o carregamento do Carrinho de Compras.
     *
     * @param  array   $params Valores para Configuração
     * @return Session Próprio Objeto para Encadeamento
     */
    protected function _setParams(array $params = array())
    {
        $this->_params = $params;
        return $this;
    }

    /**
     * Configuração da Sessão
     *
     * A camada de persistência atual utiliza um espaço nomeado na sessão para o
     * cliente centralizando as informações.
     *
     * @param  Zend_Session_Namespace $session Local de Configuração
     * @return Session Próprio Objeto para Encadeamento
     */
    protected function _setSession(Zend_Session_Namespace $session)
    {
        $this->_session = $session;
        return $this;
    }

    /**
     * Captura da Sessão
     *
     * A camada de persistência utiliza um espaço nomeado na sessão para
     * armazenar as informações do Carrinho de Compras.
     *
     * @return Zend_Session_Namespace Elemento Solicitado
     */
    protected function _getSession()
    {
        return $this->_session;
    }

    public function __construct(array $params = array())
    {
        // Inicializar Sessão
        $session = new Zend_Session_Namespace(get_class($this), true);
        // Configurar Parâmetros
        $this->_setParams($params)->_setSession($session);
    }

    public function read()
    {
        // Buscar Carrinho de Compras
        return $this->_getSession()->basket;
    }

    public function write(Basket $basket)
    {
        // Armazenar Carrinho de Compras
        $this->_getSession()->basket = $basket;
        // Confirmar Execução
        return true;
    }

}
