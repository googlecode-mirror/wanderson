<?php
/**
 * Hazel Zend Framework Extended Library
 *
 * LICENSE
 *
 * Copyright (c) 2010, Wanderson Henrique Camargo Rosa.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permited provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *     * Neither the name of the author nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Zend Framework
 * Copyright (c) Zend Technologies Ltd. All rights reserved.
 *
 * @category Hazel
 * @package  Hazel_Basket
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel
 */

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
class Hazel_Shop_Basket_Storage_Session implements Hazel_Shop_Basket_StorageInterface {

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
     * @return Hazel_Shop_Basket_Session Próprio Objeto para Encadeamento
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
     * @return Hazel_Shop_Basket_Session Próprio Objeto para Encadeamento
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

    public function write(Hazel_Shop_Basket_Basket $basket)
    {
        // Armazenar Carrinho de Compras
        $this->_getSession()->basket = $basket;
        // Confirmar Execução
        return true;
    }

}
