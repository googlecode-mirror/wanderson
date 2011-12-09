<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace \Hazel\Shop\Basket;

/**
 * Carrinho de Compras
 *
 * Classe responsável pela centralização dos itens a serem armazenados dentro de
 * um Carrinho de Compras em Loja Virtual. Este Carrinho de Compras pode receber
 * Plugins para manipulação que são executados para modificar os valores dos
 * itens cadastrados, cadastrando assim valores para promoções, cupom desconto e
 * fretes. Para manipular estes valores e apresentar um resultado como valor
 * final do item, existe um objeto para este fim que recebe um comando e informa
 * o resultado. A classe atual trabalha com um Padrão de Projeto do tipo Factory
 * para que o Carrinho de Compras seja inicializado com um armazenamento válido.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
class Basket
{
    /**
     * Conjunto de Itens Armazenados
     * @var array
     */
    protected $_items = array();

    /**
     * Verificação de Existência de Item
     *
     * Apresentando um código de item de Carrinho de Compras, podemos verificar
     * a sua inclusão consultado este método, que retorna uma confirmação da
     * existência.
     *
     * @param  string $code Código do Produto
     * @return bool   Confirmação de Existência
     */
    public function isItem($code)
    {
        // Conversão
        $code = (string) $code;
        // Verificação
        return array_key_exists($code, $this->_items);
    }

    /**
     * Captura de Item
     *
     * Podemos capturar um item armazenado no Carrinho de Compras através do
     * código do produto. Podemos ter como resultado a referência ao item de
     * Carrinho de Compras ou nulo se o código do produto não estiver armazenado
     * dentro da estrutura.
     *
     * @param  string $code Código do Produto para Captura
     * @return Item   Elemento Solicitado
     */
    public function getItem($code)
    {
        // Conversão
        $code = (string) $code;
        // Resultado Inicial
        $result = null;
        // Existência
        if ($this->isItem($code)) {
            // Captura de Item
            $result = $this->_items[$code];
        }
        // Resultado
        return $result;
    }

    /**
     * Captura de Itens Adicionados
     *
     * Todos os itens que foram inclusos na estrutura de Carrinho de Compras
     * podem ser acessados de uma única vez. O retorno é um conjunto de itens
     * mapeados onde a chave é o código do produto e o conteúdo o item de
     * Carrinho adicionado.
     *
     * @return array Conjunto de Itens Adicionados
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Inclusão de Item
     *
     * Podemos adicionar um item no Carrinho de Compras através do objeto de
     * armazenamento. Caso o Carrinho já possua um item com o mesmo código de
     * produto, a instância adiciona uma unidade ao elemento existente.
     *
     * @param  Item   $item Elemento para Inclusão
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function addItem(Item $item)
    {
        // Código do Produto
        $code = $item->getProductCode();
        // Verificar Existência
        if ($this->isItem($code)) {
            // Adicionar Quantidade
            $this->getItem($code)->addQuantity(1);
        } else {
            // Armazenar Item
            $this->_items[$code] = $item;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Inclusão de Produto ao Carrinho
     *
     * Um produto pode ser adicionado diretamente ao Carrinho de Compras. Este
     * será armazenado numa classe de item de Carrinho primeiramente e após será
     * incluso na estrutura.
     *
     * @param  ProductInterface $product Produto para Inclusão
     * @return Basket           Próprio Objeto para Encadeamento
     */
    public function addProduct(ProductInterface $product)
    {
        // Criação do Item
        $item = new Item($product);
        // Inclusão de Elemento
        return $this->setItem($item);
    }

    /**
     * Remoção de Item
     *
     * Um item pode ser removido do Carrinho de Compras através de seu código de
     * produto. Caso o item não esteja incluso na estrutura, nenhum erro será
     * apresentado.
     *
     * @param  string $code Código do Produto
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function clearItem($code)
    {
        // Conversão
        $name = (string) $name;
        // Desconfiguração
        unset($this->_items[$name]);
        // Encadeamento
        return $this;
    }

    /**
     * Limpeza de Itens Adicionados
     *
     * Todos os itens adicionados ao Carrinho de Compras podem ser removidos da
     * estrutura utilizando o método de limpeza. Não existe como retornar esta
     * execução.
     *
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function clearItems()
    {
        // Limpeza
        $this->_items = array();
        // Encadeamento
        return $this;
    }

}
