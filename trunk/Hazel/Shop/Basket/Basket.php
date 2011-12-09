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
     * Atributos
     * @var array
     */
    protected $_attribs = array();

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

    /**
     * Verificação de Carrinho sem Itens Adicionados
     *
     * A verificação consulta a estrutura de itens adicionados e apresenta uma
     * confirmação de existência de elementos inclusos.
     *
     * @return bool Confirmação de Elementos Adiconados
     */
    public function isEmpty()
    {
        return empty($this->_items);
    }

    /**
     * Verifica a Existência de Atributo
     *
     * Um atributo de carrinho de compras é uma informação que pode ser
     * adicionada para que os Plugins consigam efetuar uma comunicação entre si,
     * já que estes não podem acessar informações paralelamente. Este apresenta
     * uma confirmação da existência do atributo com o nome solicitado.
     *
     * @param  string $name Nome do Atributo para Verificação
     * @return bool   Confirmação da Existência do Atributo
     */
    public function isAttrib($name)
    {
        // Conversão
        $name = (string) $name;
        // Verificação
        return array_key_exists($name, $this->_attribs);
    }

    /**
     * Configuração de Atributo
     *
     * O atributo solicitado pode ser gravado na estrutura do Carrinho de
     * Compras, melhorando a comunicação entre Plugins, tendo em vista que eles
     * não podem efetuar uma consulta direta entre si. Estes valores são
     * armazenados em conjunto de atributos e podem ser consultados quando
     * necessário. Caso o valor apresentado seja nulo, o atributo será removido
     * completamente da estrutura.
     *
     * @param  string $name  Nome do Atributo para Configuração
     * @param  mixed  $value Valor para Configuração
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function setAttrib($name, $value)
    {
        // Conversão
        $name = (string) $name;
        // Valor Nulo
        if ($value === null) {
            // Desconfiguração
            $this->clearAttrib($name);
        } else {
            // Configurar Valor
            $this->_attribs[$name] = $value;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Consulta de Atributo Configurado
     *
     * Um atributo pode ser configurado na estrutura do Carrinho de Compras para
     * facilitar a comunicação entre Plugins. Caso o atributo não exista dentro
     * da estrutura, um valor nulo é apresentado.
     *
     * @param string      $name Nome do Atributo Solicitado
     * @return mixed|null Valor para o Nome do Atributo
     */
    public function getAttrib($name)
    {
        // Conversão
        $name = (string) $name;
        // Resultado Inicial
        $result = null;
        // Existência
        if ($this->isAttrib($name)) {
            $result = $this->getAttrib($name);
        }
        // Resultado
        return $result;
    }

    /**
     * Consulta de Atributos Configurados
     *
     * Todos os atributos configurados até o momento para o Carrinho de Compras
     * é apresentado em conjunto onde a chave representa o nome do atributo e
     * conteúdo o valor deste.
     *
     * @return array Conjunto de Valores de Atributos
     */
    public function getAttribs()
    {
        // Resultado
        return $this->_attribs;
    }

    /**
     * Remoção de Atributo
     *
     * Um atributo pode ser removido do Carrinho de Compras através do método
     * apresentado. Este valor será removido completamente da estrutura.
     *
     * @param  string $name Nome do Atributo para Remoção
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function clearAttrib($name)
    {
        // Conversão
        $name = (string) $name;
        // Desconfiguração
        unset($this->_attribs[$name]);
        // Encadeamento
        return $this;
    }

    /**
     * Remoção de Todos Atributos
     *
     * A remoção de todos os atributos pode ser executada através deste método.
     * Não existe como retornar os valores configurados anteriormente.
     *
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function clearAttribs()
    {
        // Remoção
        $this->_attribs = array();
        // Encadeamento
        return $this;
    }

}
