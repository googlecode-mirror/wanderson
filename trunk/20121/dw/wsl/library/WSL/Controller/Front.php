<?php

/**
 * Controladora Frontal
 *
 * @category WSL
 * @package  WSL_Controller
 */
class WSL_Controller_Front {

    /**
     * Instância Singleton
     * @var WSL_Controller_Front
     */
    private static $_instance = null;

    /**
     * Camada de Visualização
     * @var WSL_View_View
     */
    private $_view;

    /**
     * Configurações
     * @var WSL_Model_Config
     */
    private $_config;

    /**
     * Acesso Singleton
     *
     * @return WSL_Controller_Front Elemento Solicitado
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Construtor Singleton
     */
    private function __construct() {
        // Configuração
        $this->setView(new WSL_View_View())
             ->setConfig(new WSL_Model_Config());
    }

    /**
     * Configuração de Visualização
     *
     * @param  WSL_View_View $view Elemento para Configuração
     * @return WSL_Controller_Front Próprio Objeto para Encadeamento
     */
    public function setView(WSL_View_View $view) {
        // Configuração
        $this->_view = $view;
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Camada de Visualização
     *
     * @return WSL_View_View Elemento Solicitado
     */
    public function getView() {
        // Apresentação
        return $this->_view;
    }

    /**
     * Configuração de Modelo para Configurações
     *
     * @param  WSL_Model_Config $config Elemento para Configuração
     * @return WSL_Controller_Front Próprio Objeto para Encadeamento
     */
    public function setConfig(WSL_Model_Config $config) {
        // Configuração
        $this->_config = $config;
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Configurações
     *
     * @return WSL_Model_Config Elemento Solicitado
     */
    public function getConfig() {
        // Apresentação
        return $this->_config;
    }

    /**
     * Execução de Controladora Frontal
     *
     * Utiliza informações do ambiente e parâmetros adicionais para carregar a
     * controladora correta conforme execução do sistema, encaminhando assim a
     * solicitação. Para processamento, precisamos informar dois objetos do tipo
     * requisição e resposta que serão apresentados durante o fluxo.
     *
     * @param  WSL_Controller_Request  Elemento de Requisição
     * @param  WSL_Controller_Response Elemento de Resposta
     * @return WSL_Controller_Front Próprio Objeto para Encadeamento
     */
    public function dispatch(WSL_Controller_Request $request, WSL_Controller_Response $response) {
        // Execução do Sistema
        try {
            // Execução
            $this->_execute($request, $response);
        } catch (Exception $e) {
            // Controladora de Erros
            $request->setParam('controller', 'error')
                    ->setParam('action', 'error');
            // Limpeza de Resposta
            $response->clear();
            // Recuperação de Erro
            $this->_execute($request, $response);
        }
        // Renderizar Layout?
        if ($this->getConfig()->getParam('Layout.enabled')) {
            // Camada de Visualização
            $view = $this->getView();
            // Conteúdo em Passo 1
            $view->content = $response->getContent();
            // Renderização em Passo 2
            $content = $view->render('layout/layout.phtml');
            // Configurar Conteúdo
            $response->setContent($content);
        }
        // Encadeamento
        return $this;
    }

    /**
     * Execução de Controladora de Ações
     *
     * Utiliza os elementos de requisição e resposta para executar o fluxo do
     * sistema conforme parâmetros informados durante a consulta do cliente.
     * Caso a controladora ou ação solicitada não existir, será gerada uma
     * exceção que pode ser tratada pela controladora de erros.
     *
     * @param  WSL_Controller_Request  Elemento de Requisição
     * @param  WSL_Controller_Response Elemento de Resposta
     * @return WSL_Controller_Front Próprio Objeto para Encadeamento
     * @throws Exception Erro Encontrado Durante Execução
     */
    protected function _execute(WSL_Controller_Request $request, WSL_Controller_Response $response) {
        // Parâmetros de Rotas
        $controller = $request->getParam('controller', 'index');
        $action     = $request->getParam('action', 'index');
        // Construção de Controladora de Ações
        $classname  = 'Controller_' . ucfirst($controller);
        $methodname = $action . 'Action';
        // Existe Controladora Solicitada?
        if (!class_exists($classname)) {
            // Controladora não Encontrada
            throw new Exception("Invalid Controller: '$classname'");
        }
        // Verificar Tipagem Correta
        if (!in_array('WSL_Controller_ActionAbstract', class_parents($classname))) {
            // Controladora Inválida
            throw new Exception("Invalid Controller Type; '$classname'");
        }
        // Existe Ação Solicitada?
        if (!in_array($methodname, get_class_methods($classname))) {
            // Ação não Encontrada
            throw new Exception("Invalid Action: '$methodname'");
        }
        // Criação do Elemento
        $element = new $classname($request, $response);
        // Camada de Visualização
        $element->view = $this->getView();
        // Executar Ação da Controladora
        $element->$methodname();
        // Renderizar Visualização
        $content = $this->getView()->render("$controller/$action.phtml");
        // Aplicar em Resposta
        $response->setContent($content);
        // Encadeamento
        return $this;
    }

}

