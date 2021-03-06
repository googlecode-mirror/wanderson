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
 * Item de Carrinho
 *
 * Utilizado pelo carrinho de compras para controlar os produtos armazenados.
 * Esta estrutura também é utilizada para ser manipulada pelos Plugins para
 * salvar os preços. Os preços serão utilizados pelo calculador de preços.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
class Hazel_Shop_Basket_Item
{
    /**
     * Carrinho de Compras
     * @var Hazel_Shop_Basket_Basket
     */
    protected $_basket;

    /**
     * Produto Referenciado
     * @var Hazel_Shop_Basket_ProductInterface
     */
    protected $_product;

    /**
     * Quantidade de Produtos
     * @var int
     */
    protected $_quantity;

    /**
     * Valores para Manipulação
     * @var array
     */
    protected $_values = array();

    /**
     * Construtor Padrão
     *
     * O construtor de item de Carrinho de Compras recebe por parâmetro um
     * produto que deve ser armazenado e este não pode receber uma modificação
     * na referência do produto posteriormente.
     *
     * @param Hazel_Shop_Basket_Basket Carrinho de Compras
     * @param Hazel_Shop_Basket_ProductInterface $product Produto para Configuração
     */
    public function __construct(Hazel_Shop_Basket_Basket $basket, ProductInterface $product)
    {
        // Configuração Inicial
        $this->_setBasket($basket)->_setProduct($product)->setQuantity(1);
    }

    /**
     * Configuração do Carrinho de Compras
     *
     * @param  Hazel_Shop_Basket_Basket $basket Elemento para Configuração
     * @return Hazel_Shop_Basket_Item   Próprio Objeto para Encadeamento
     */
    protected function _setBasket(Hazel_Shop_Basket_Basket $basket)
    {
        $this->_basket = $basket;
        return $this;
    }

    /**
     * Apresentação do Carrinho de Compras
     *
     * @return Hazel_Shop_Basket_Basket Elemento Solicitado
     */
    public function getBasket()
    {
        return $this->_basket;
    }

    /**
     * Configuração do Produto Referenciado
     *
     * @param Hazel_Shop_Basket_ProductInterface $product Elemento para Configuração
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    protected function _setProduct(Hazel_Shop_Basket_ProductInterface $product)
    {
        $this->_product = $product;
        return $this;
    }

    /**
     * Informação do Produto Referenciado
     *
     * @return Hazel_Shop_Basket_ProductInterface Elemento Solicitado
     */
    public function getProduct()
    {
        return $this->_product;
    }

    /**
     * Apresenta o Código do Produto
     *
     * O código do produto é utilizado pelo Carrinho de Compras para identificar
     * elementos de forma única dentro da estrutura, principalmente para acesso
     * direto nos métodos.
     *
     * @return string Código do Produto Referenciado
     */
    public function getProductCode()
    {
        return $this->getProduct()->getCode();
    }

    /**
     * Apresenta o Valor do Produto
     *
     * O valor do produto é o preço apresentado pelo objeto referenciado para
     * que os Plugins consigam utilizar como base para processamentos e que o
     * manipulador de valores efetue o cálculo.
     *
     * @return float Valor do Produto Referenciado
     */
    public function getProductValue()
    {
        return $this->getProduct()->getValue();
    }

    /**
     * Configura a Quantidade de Produtos
     *
     * A quantidade de produtos é utilizada pelos Plugins de Carrinho de Compras
     * para efetuar cálculos de quantidade total ou processamento de descontos.
     * Qualquer valor menor do que zero será gravado como nulo. Caso a
     * quantidade seja igual a zero, o produto solicita ao carrinho a sua
     * remoção.
     *
     * @param int $quantity Valor para Configuração
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function setQuantity($quantity)
    {
        // Conversão
        $quantity = (int) $quantity;
        // Verificar Valor Inválido
        if ($quantity <= 0) {
            // Quantidade Zerada
            $quantity = 0;
            // Solicitar ao Carrinho a Remoção
            $this->getBasket()->clearItem($this->getProductCode());
        }
        // Configurar a Quantidade
        $this->_quantity = $quantity;
        // Informar Carrinho
        $this->getBasket()->update($this);
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta a Quantidade de Produtos
     *
     * A quantidade de produtos é configurada pelo encapsulamento e nunca será
     * nula ou negativa conforme regras internas. Caso isto aconteça, o produto
     * solicita ao Carrinho de Compras a sua remoção.
     *
     * @return int Valor Solicitado
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Adiciona uma Quantidade de Produtos
     *
     * A inclusão de uma determinada quantidade de produtos é verificada se o
     * resultado da operação não ocasiona um estouro de memória para inteiros,
     * havendo perda de informação. O valor da quantidade sempre será
     * considerado pelo seu valor absoluto.
     *
     * @param int $quantity Valor para Configuração
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function addQuantity($quantity)
    {
        // Conversão
        $quantity = abs($quantity);
        // Cálculo
        $result = (int) ($quantity + $this->getQuantity());
        // Verificar Estouro de Inteiro
        if ($result < $quantity) {
            $result = 0;
        }
        // Gravação do Resultado
        $this->setQuantity($result);
        // Encadeamento
        return $this;
    }

    /**
     * Subtrai uma Quantidade de Produtos
     *
     * A remoçao de uma determinada quantidade de produtos é verificada se o
     * resultado da operação não ocasiona um estouro de memória para inteiros,
     * havendo perda de informação. O valor da quantidade sempre será
     * considerado pelo seu valor absoluto inverso.
     *
     * @param int $quantity Valor para Configuração
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function subQuantity($quantity)
    {
        // Conversão
        $quantity = abs($quantity) * (-1);
        // Cálculo
        $result = (int) ($quantity + $this->getQuantity());
        // Verificar Estouro de Inteiro
        if ($result > $quantity) {
            $result = 0;
        }
        // Gravação do Resultado
        $this->setQuantity($result);
        // Encadeamento
        return $this;
    }

    /**
     * Verificação de Tipo de Valor Configurado
     *
     * Busca no conjunto de valores armazenados para o produto a existência de
     * determinado nome armazenado dentro da estrutura. Este valor pode ser
     * utilizado pelos Plugins para efetuar cálculos. Preferencialmente, cada
     * Plugin deve salvar uma informação com seu nome dentro do item de Carrinho
     * de Compras.
     *
     * @param string $name Nome do Tipo de Valor Configurado
     * @return bool Confirmação da Existência do Valor
     */
    public function isValue($name)
    {
        // Conversão
        $name = (string) $name;
        // Verificação
        return array_key_exists($this->_values[$name]);
    }

    /**
     * Limpeza de Tipo de Valor Configurado
     *
     * Efetua a remoção de determinado valor do conjunto interno do item de
     * Carrinho de Compras. Este método remove completamente o valor, não
     * somente anulando seu conteúdo.
     *
     * @param string $name Nome do Tipo de Valor Configurado
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function clearValue($name)
    {
        // Conversão
        $name = (string) $name;
        // Desconfiguração
        unset($this->_values[$name]);
        // Informar Carrinho
        $this->getBasket()->update($this);
        // Encadeamento
        return $this;
    }

    /**
     * Limpeza Completa de Valores
     *
     * Remove todos os valores do item de carrinho de compras, facilitando o
     * reinício dos cálculos para os Plugins. Caso estes valores recebam o
     * comando de limpeza, não há como retornar os valores.
     *
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function clearValues()
    {
        // Limpeza
        $this->_values = array();
        // Informar Carrinho
        $this->getBasket()->update($this);
        // Encadeamento
        return $this;
    }

    /**
     * Configura um Valor para Tipo Configurado
     *
     * O tipo solicitado é armazenado com o valor informado dentro do item de
     * Carrinho de Compras para que este seja consultado pelos Plugins. Cada
     * Plugin pode gravar a informação desejada dentro dos itens e manipular
     * estas informações, buscando manipular os dados conforme necessário.
     *
     * @param string $name  Nome do Tipo de Valor para Configuração
     * @param float  $value Valor para Configuração
     * @return Hazel_Shop_Basket_Item Próprio Objeto para Encadeamento
     */
    public function setValue($name, $value)
    {
        // Conversão
        $name  = (string) $name;
        // Verificação do Valor
        if ($value === null) {
            // Desconfigurar
            $this->clearValue($name);
        } else {
            // Conversão
            $value = (float) $value;
            // Configuração
            $this->_values[$name] = $value;
        }
        // Informar Carrinho
        $this->getBasket()->update($this);
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Valor para Tipo Configurado
     *
     * Um tipo configurado pode ser solicitado ao item. Um Plugin de Carrinho de
     * Compras possui livre acesso a todos os valores armazenados no item e este
     * deve ser desenvolvido para configurar o valor com o nome de sua própria
     * classe para evitar conflitos.
     *
     * @param string $name Nome do Tipo de Valor Configurado
     * @return float|null Valor Configurado ou Nulo para Inexistente
     */
    public function getValue($name)
    {
        // Conversão
        $name = (string) $name;
        // Resultado Inicial
        $result = null;
        // Valor Existente
        if ($this->isValue($name)) {
            // Valor Resultante
            $result = $this->_values[$name];
        }
        // Resultado
        return $result;
    }

    /**
     * Informação de Todos os Valores Configurados
     *
     * A lista de valores configurados pode ser acessada diretamente solicitando
     * todos os valores armazenados no item de Carrinho de Compras. Estes
     * valores estão armazenados utilizando um mapeamento, onde a chave
     * representa o nome do tipo a ser utilizado e o conteúdo o valor
     * configurado para aquele tipo.
     *
     * @return array Conjunto de Valores de Tipo Configurados
     */
    public function getValues()
    {
        return $this->_values;
    }

}
