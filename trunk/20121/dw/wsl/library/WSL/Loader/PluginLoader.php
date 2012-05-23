<?php

/**
 * Carregador de Plugins
 *
 * Estrutura auxiliar para gerenciamento e carregamento de plugins dentro de
 * determinada programação. Após configurações de prefixos e diretórios para
 * pesquisa, podemos efetuar o carregamento destes elementos, que serão
 * consultados e apresentados os nomes de classes.
 *
 * @category WSL
 * @package  WSL_Loader
 */
class WSL_Loader_PluginLoader {

    /**
     * Conjunto de Elementos Carregados
     * @var string[]
     */
    protected $_plugins = array();

    /**
     * Prefixos para Carregamento
     * @var string[]
     */
    protected $_prefixes = array();

    /**
     * Configurar Prefix para Inclusão
     *
     * Adiciona um prefixo que deve ser considerado para consulta de classes.
     * Quando é solicitado um elemento, serão consultados todos os prefixos até
     * que seja encontrada uma classe que responda aos padrões aplicados.
     *
     * @param  string $prefix Valor do Prefixo para Pesquisa
     * @return WSL_Loader_PluginLoader Próprio Objeto para Encadeamento
     */
    public function addPrefix($prefix) {
        // Inclusão de Elemento
        $this->_prefixes[] = $prefix;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação de Prefixos Registrados
     *
     * Informa todos os prefixos que devem ser utilizados durante o carregamento
     * de elementos dentro do sistema. Durante a consulta de classes, estes
     * valores serão concatenados com os nomes de elementos solicitados até que
     * seja encontrada uma classe.
     *
     * @return string[] Valores Configurados
     */
    public function getPrefixes() {
        // Apresentação
        return $this->_prefixes;
    }

    /**
     * Carregamento de Plugin
     *
     * Sendo apresentado um nome para consulta, este valor será concatenado com
     * cada prefixo configurado até que seja encontrada uma classe existente.
     * Quando encontrado o elemento, uma nova instância deste elemento será
     * criada e armazenada localmente, não criando outra instância do mesmo
     * objeto na memória.
     *
     * @param  string $name Nome do Elemento
     * @return mixed Plugin Carregado com Sucesso ou Nulo Caso Contrário
     */
    public function load($name) {
        // Conversão
        $name = (string) $name;
        // Resultado Inicial
        $result = null;
        // Consultar Prefixos
        foreach ($this->getPrefixes() as $prefix) {
            // Nome de Classe
            $classname = $prefix . '_' . ucfirst($name);
            // Existe Classe?
            if (class_exists($classname)) {
                // Criação de Instância
                $result = new $classname();
                // Quebrar Execução
                break;
            }
        }
        // Registrar Elemento
        $this->_plugins[$name] = $result;
        // Apresentação
        return $result;
    }

    // Método Mágico: Acesso
    public function __get($name) {
        // Consulta de Plugin
        return $this->load($name);
    }

}
