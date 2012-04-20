<?php

/**
 * Elemento de Requisição
 *
 * @category WSL
 * @package  WSL_Controller
 */
class WSL_Controller_Request {

    /**
     * Parâmetros de Execução
     * @var array
     */
    protected $_params = array();

    /**
     * Construtor Padrão
     */
    public function __construct() {
        // Inicializar Parâmetros
        $this->_buildParams();
    }

    /**
     * Construção de Parâmetros
     *
     * Captura o endereço de requisição e efetua a conversão de seu conteúdo
     * para possíveis parâmetros apresentados ao cliente.
     *
     * @return WSL_Controller_Request Próprio Objeto para Encadeamento
     */
    protected function _buildParams() {
        // Endereço Base
        $baseurl = dirname($_SERVER['SCRIPT_NAME']);
        $content = str_replace($baseurl, '', $_SERVER['REQUEST_URI']);
        preg_match_all('#/(?<name>[^/]*)/(?<value>[^/]*)#', $content, $matches, PREG_SET_ORDER);
        // Capturar Controladora e Ação
        $router  = array_shift($matches);
        if (!empty($router)) {
            $this->setParam('controller', $router['name'])
                 ->setParam('action', $router['value']);
        }
        // Processar Parâmetros
        foreach ($matches as $match) {
            // Configurar Parâmetros
            $this->setParam($match['name'], $match['value']);
        }
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Parâmetros
     *
     * Consulta de parâmetros de requisição durante o processamento. Estes são
     * pesquisados primeiramente em conjunto local e caso não encontrado, será
     * efetuada uma pesquisa em variáveis de ambiente; quando capturado este é
     * configurado localmente para acelerar o processo.
     *
     * @param  string $identifier Identificador para Consulta
     * @param  mixed  $default    Valor Padrão para Consulta sem Resultados
     * @return mixed  Elemento Solicitado
     */
    public function getParam($identifier, $default = null) {
        // Resultado Inicial
        $result = $default;
        // Existe Parâmetro Configurado?
        if (array_key_exists($identifier, $this->_params)) {
            // Capturar Parâmetro Local
            $result = $this->_params[$identifier];
        } else {
            // Pesquisar Parâmetro
            $search = $this->_findParam($identifier);
            // Encontrado?
            if ($search !== null) {
                // Capturar Consulta
                $result = $search;
                // Configurar Elemento
                $this->setParam($identifier, $result);
            }
        }
        // Resultado
        return $result;
    }

    /**
     * Consulta de Identificador
     *
     * Pesquisa em ambientes do sistema o parâmetro solicitado, processando de
     * forma iterativa os possíveis conjuntos de comunicação do cliente com o
     * sistema;
     *
     * @param  string $identifier Identificador para Consulta
     * @return mixed  Valor Encontrado
     */
    protected function _findParam($identifier) {
        // Resultado Inicial
        $result = null;
        // Conversão
        $identifier = (string) $identifier;
        // Pesquisa em Conteúdos
        foreach (array('GET', 'POST', 'SERVER') as $element) {
            // Processo de Pesquisa
            eval(sprintf('$container = $_%s;', $element));
            // Existe Identificador?
            if (array_key_exists($identifier, $container)) {
                // Capturar Resultado
                $result = $container[$identifier]; break;
            }
        }
        // Resultado
        return $result;
    }

    /**
     * Configuração de Parâmetros
     *
     * Os parâmetros de requisição podem ser configurados utilizando este método
     * que armazena as informações necessárias internamente. Caso o valor
     * apresentado seja nulo, o identificador será desconfigurado.
     *
     * @param  string $identifier Identificador para Configuração
     * @param  mixed  $value      Valor para Configuração
     * @return WSL_Controller_Request Próprio Objeto para Encadeamento
     */
    public function setParam($identifier, $value) {
        // Conversão
        $identifier = (string) $identifier;
        // Configurar Elemento?
        if ($value !== null) {
            // Configurar Valor Apresentado
            $this->_params[$identifier] = $value;
        } else {
            // Remover Conteúdo
            unset($this->_params[$identifier]);
        }
        // Encadeamento
        return $this;
    }

}

