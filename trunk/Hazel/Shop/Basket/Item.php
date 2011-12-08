<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace \Hazel\Shop\Basket;

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
class Item
{
    /**
     * Produto Referenciado
     * @var ProductInterface
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
    protected $_values;

    /**
     * Configuração do Produto Referenciado
     *
     * @param ProductInterface $product Elemento para Configuração
     * @return Item Próprio Objeto para Encadeamento
     */
    protected function _setProduct(ProductInterface $product)
    {
        $this->_product = $product;
        return $this;
    }

    /**
     * Informação do Produto Referenciado
     *
     * @return ProductInterface Elemento Solicitado
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
     * @return Item Próprio Objeto para Encadeamento
     */
    public function setQuantity($quantity)
    {
        // Conversão
        $quantity = (int) $quantity;
        // Verificar Valor Inválido
        if ($quantity <= 0) {
            // Solicitar ao Carrinho a Remoção
            // @todo Capturar o Carrinho e Remover o Produto
        }
        // Configurar a Quantidade
        $this->_quantity = $quantity;
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
     * @return Item Próprio Objeto para Encadeamento
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
     * @return Item Próprio Objeto para Encadeamento
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

}
