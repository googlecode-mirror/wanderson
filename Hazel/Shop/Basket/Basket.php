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
class Hazel_Shop_Basket_Basket
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
     * Camada de Persistência
     * @var Hazel_Shop_Basket_StorageInterface
     */
    protected $_storage = null;

    /**
     * Calculadora de Itens
     * Padrão de Projeto Strategy
     * @var Hazel_Shop_Basket_ItemStrategy
     */
    protected $_itemStrategy = null;

    /**
     * Plugins de Carrinho de Compras
     * @var array
     */
    protected $_plugins = array();

    /**
     * Caminho para Carregamento de Plugins
     * @var string
     */
    protected $_pluginPath = null;

    /**
     * Configuração do Prefixo de Classes de Plugin
     * @var string
     */
    protected $_pluginPrefix = null;

    /**
     * Padrão de Projeto Factory
     *
     * Produção de Carrinho de Compras utilizando como base um identificador o
     * nome da classe da camada de persistência, onde os parâmetros apresentados
     * serão utilizados durante a sua construção. Os parâmetros variam de acordo
     * com a classe de persistência utilizada.
     *
     * @param  string $storage Nome da Classe de Persistência
     * @param  array  $params  Parâmetros de Configuração
     * @return Hazel_Shop_Basket_Basket|null Resultado Solicitado
     */
    public static function factory($storage, array $params = array()) {
        // Conversão
        $storage = (string) $storage;
        // Verificação de Armazenamento
        if (!class_exists($storage)) {
            throw new Hazel_Shop_Basket_Exception("Invalid Storage Class: '$storage'");
        }
        // Criação do Armazenador
        $persistence = new $storage($params);
        // Captura do Carrinho de Compras
        $basket = null;
        try {
            // Camada de Persistência
            $basket = $persistence->read();
        } catch (Exception $e) {
            // Erro Encontrado
            $basket = null;
        }
        // Analisar Tipo do Objeto
        if (!($basket instanceof self)) {
            $basket = null;
        }
        // Existência de Elemento
        if ($basket === null) {
            $basket = new self();
        }
        // Configurar Persistência
        $basket->_setStorage($persistence);
        // Resultados
        return $basket;
    }

    /**
     * Construtor Básico
     */
    protected function __construct()
    {
        // Construtor
    }

    /**
     * Destruidor
     *
     * Busca armazenar o carrinho de compras quando o objeto estiver em tempo
     * de destruição, mantendo os dados persistidos.
     */
    public function __destruct()
    {
        // Persistência
        try {
            $this->_getStorage()->write($this);
        } catch (Exception $e) {}
    }

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
     * @return Hazel_Shop_Basket_Item Elemento Solicitado
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
     * @param  Item $item Elemento para Inclusão
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function addItem(Hazel_Shop_Basket_Item $item)
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
     * @param  Hazel_Shop_Basket_ProductInterface $product Produto para Inclusão
     * @return Basket Próprio Objeto para Encadeamento
     */
    public function addProduct(Hazel_Shop_Basket_ProductInterface $product)
    {
        // Criação do Item
        $item = new Hazel_Shop_Basket_Item($this, $product);
        // Inclusão de Elemento
        return $this->addItem($item);
    }

    /**
     * Remoção de Item
     *
     * Um item pode ser removido do Carrinho de Compras através de seu código de
     * produto. Caso o item não esteja incluso na estrutura, nenhum erro será
     * apresentado.
     *
     * @param  string $code Código do Produto
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
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
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
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
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
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
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
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
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function clearAttribs()
    {
        // Remoção
        $this->_attribs = array();
        // Encadeamento
        return $this;
    }

    /**
     * Configuração da Camada de Persistência
     *
     * A camada de persistência é adicionada durante a inicialização do objeto
     * de Carrinho de Compras e acessada ao final da vida deste, durante a sua
     * destruição.
     *
     * @param  Hazel_Shop_Basket_StorageInterface $storage Camada de Persistência para Configuração
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    protected function _setStorage(Hazel_Shop_Basket_StorageInterface $storage)
    {
        // Configuração
        $this->_storage = $storage;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação da Camada de Persistência
     *
     * A camada de persistência corresponde a um objeto necessário para
     * armazenamento do Carrinho de Compras para que este esteja disponível
     * entre diferentes requisições.
     *
     * @return Hazel_Shop_Basket_StorageInterface Camada de Persistência Solicitada
     */
    protected function _getStorage()
    {
        // Apresentação
        return $this->_storage;
    }

    /**
     * Configura a Calculadora de Itens
     *
     * Utilizando o Padrão de Projeto Strategy, existe a possibilidade de
     * injeção de código para efetuar cálculos aos itens adicionados no Carrinho
     * de Compras.
     *
     * @param  Hazel_Shop_Basket_ItemStrategy $strategy Elemento para Cálculos sobre Itens
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function setItemStrategy(Hazel_Shop_Basket_ItemStrategy $strategy)
    {
        $this->_itemStrategy = $strategy;
        return $this;
    }

    /**
     * Apresenta a Calculadora de Itens
     *
     * A calculadora de itens é um objeto que trabalha sob o Padrão de Projeto
     * Strategy e visa processar um determinado valor que é solicitado ao item
     * de Carrinho de Compras. Quando nenhuma calculadora de valores foi
     * configurada para utilização, o Carrinho de Compras apresenta a sua
     * calculadora padrão, que somente efetua o somatório dos valores gravados
     * no item com o valor do produto.
     *
     * @return Hazel_Shop_Basket_ItemStrategy Elemento para Cálculo sobre Itens
     */
    public function getItemStrategy()
    {
        if ($this->_itemStrategy === null) {
            $strategy = new Hazel_Shop_Basket_ItemCalculator();
            $this->setItemStrategy($strategy);
        }
        return $this->_itemStrategy;
    }

    /**
     * Atualização do Carrinho de Compras
     *
     * Quando um item adicionado ao Carrinho de Compras efetual alguma
     * modificação em seu estado, este deve informar ao objeto que o contém
     * sobre sua modificação, trabalhando com uma pequena aplicação no estilo do
     * Padrão de Projeto Observer.
     *
     * @param  Hazel_Shop_Basket_Item $item Elemento Adicionado que Solicita Atualização
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function update(Item $item)
    {
        // @todo Construção de Processamento
        return $this;
    }

    /**
     * Configura o Caminho para Captura de Plugins
     *
     * Apresenta ao Carrinho de Compras o diretório de pesquisa para Plugins.
     * Este diretório deve conter classes com a mesma estrutura de diretórios
     * utilizada pelo autocarregamento. Também existe a necessidade de fornecer
     * o prefixo da classe a ser carregada como Plugin.
     *
     * @param  string $path   Diretório para Pesquisa do Plugin
     * @param  string $prefix Prefixo das Classes Apresentadas
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function setPluginPath($path, $prefix = null)
    {
        // Configuração do Caminho
        $this->_pluginPath = rtrim($path, DIRECTORY_SEPARATOR);
        // Configuração do Prefixo
        if ($prefix === null) {
            $prefix = $this->_getPluginPrefix();
        }
        $this->_pluginPrefix = $prefix;
        // Encadeamento
        return $this;
    }

    /**
     * Informação sobre o Caminho para Captura de Plugins
     *
     * O diretório será utilizado para capturar os Plugins solicitados ao
     * Carrinho de Compras. Este diretório pode ser modificado, juntamente com o
     * prefixo das classes que devem ser carregadas como Plugin.
     *
     * @return string Caminho Completo para Carregar Plugins
     */
    public function getPluginPath()
    {
        // Caminho Configurado
        if ($this->_pluginPath === null) {
            // Diretório Adjacente
            $path = realpath(dirname(__FILE__) . '/Plugin');
            // Configuração do Diretório
            $this->setPluginPath($path);
        }
        // Resultado
        return $this->_pluginPath;
    }

    /**
     * Prefixo de Classes de Plugin
     *
     * Apresenta o valor configurado como prefixo para classes de Plugin,
     * carregadas em diretório específico. Estes Plugins podem iniciar com um
     * prefixo padrão caso o valor não esteja configurado.
     *
     * @return string Prefixo para Carregamento de Plugins
     */
    protected function _getPluginPrefix()
    {
        if ($this->_pluginPrefix === null) {
            return preg_replace('/(.)[a-zA-Z]+$/U', '$1Plugin$1', get_class($this));
        }
        return $this->_pluginPrefix;
    }

    /**
     * Carregamento de Plugin
     *
     * Caso o Plugin solicitado não tenha sido carregado anteriormente no
     * Carrinho de Compras na requisição atual, conforme as configurações de
     * inclusão de Plugins este será carregado.
     *
     * @param  string $name Nome do Plugin para Carregamento
     * @throws Hazel_Shop_Basket_Exception Plugin Inválido
     * @return Hazel_Shop_Basket_PluginInterface Elemento Solicitado
     */
    protected function _load($name)
    {
        // Carregamento de Plugin
        if (!array_key_exists($name, $this->_plugins)) {
            // Caminho Completo do Arquivo
            $filepath = $this->getPluginPath() . DIRECTORY_SEPARATOR . $name . '.php';
            // Nome da Classe
            $classname = $this->_getPluginPrefix() . $name;
            // Carregar Arquivo
            require_once $filepath;
            // Construção do Plugin
            $element = new $classname();
            // Verificação de Tipagem
            if (!($element instanceof Hazel_Shop_Basket_PluginInterface)) {
                throw new Hazel_Shop_Basket_Exception("Invalid Plugin Interface: '$name'");
            }
            // Inclusão do Plugin no Carrinho
            $this->_plugins[$name] = $element;
        }
        // Resultado
        return $this->_plugins[$name];
    }

    /**
     * Execução de Plugin
     *
     * Podemos solicitar ao Carrinho de Compras a execução de determinado Plugin
     * conforme necessário. Este Plugin irá receber o objeto atual do Carrinho
     * de Compras e poderá manipular todos os valores dos itens adicionados.
     *
     * @param  string $name Nome do Plugin para Execução
     * @return Hazel_Shop_Basket_Basket Próprio Objeto para Encadeamento
     */
    public function execute($name)
    {
        // Conversão
        $name = (string) $name;
        // Captura de Plugin
        $plugin = $this->_load($name);
        // Execução
        $plugin->execute($this);
        // Encadeamento
        return $this;
    }

    /**
     * Valores para Serialização
     *
     * Durante a serialização do objeto, somente devemos apresentar os itens
     * adicionados ao Carrinho de Compras e os atributos cadastrados, evitando
     * alguns erros de processamento em classes.
     *
     * @return array Atributor para Serialização
     */
    public function __sleep()
    {
        return array('_attribs', '_items');
    }

}
