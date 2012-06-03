<?php

/**
 * Gerenciador de Plugins
 *
 * Elemento utilizado no gerenciamento para compilação de documentos LaTeX
 * dentro do sistema, possuindo uma característica de modularização do
 * processamento, dividindo as tarefas em plugins que podem ser executados com
 * dependência entre si.
 *
 * @category WSL
 * @package  WSL_Compiler
 */
class WSL_Compiler_Manager {

    /**
     * Carregador de Plugins
     * @var WSL_Loader_PluginLoader
     */
    protected $_loader = null;

    /**
     * Contexto de Execução
     * @var WSL_Compiler_Context
     */
    protected $_context = null;

    /**
     * Nome do Plugin para Execução Anterior
     * @var string
     */
    protected $_beforePlugin = null;

    /**
     * Nome do Plugin para Execução Posterior
     * @var string
     */
    protected $_afterPlugin = null;

    /**
     * Estado de Compilação
     * @var string
     */
    protected $_state = 'DISABLED';

    /**
     * Construtor Padrão
     *
     * @param WSL_Compiler_Context $context Contexto de Execução
     */
    public function __construct(WSL_Compiler_Context $context) {
        // Configurações
        $this->_setContext($context);
        // Inicialização
        $loader = new WSL_Loader_PluginLoader();
        $loader->addPrefix('WSL_Compiler_Plugin');
        $this->_loader = $loader;
    }

    /**
     * Configuração do Plugin de Execução Anterior
     *
     * Nome do elemento que deve ser executado antes do início da compilação do
     * conteúdo armazenado no diretório de trabalho dentro do sistema. Quando
     * houver a necessidade de configuração de muitos plugins de execução,
     * precisamos criar um plugin que execute a chamada destes outros elementos
     * durante a execução.
     *
     * @param  string $name Nome do Plugin
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function setBeforePlugin($name) {
        // Configuração
        $this->_beforePlugin = (string) $name;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Nome do Plugin de Execução Anterior
     *
     * Informa o nome do plugin que deve ser utilizado para processamento
     * anterior ao compilador. Este plugin pode executar outros elementos
     * conforme necessidade. O nome do plugin pode ser apresentado ao método de
     * execução, onde este irá tratar o elemento conforme o estado do
     * gerenciamento.
     *
     * @return string Valor Solicitado
     */
    public function getBeforePlugin() {
        // Apresentação
        return $this->_beforePlugin;
    }

    /**
     * Configuração do Plugin de Execução Posterior
     *
     * Nome do elemento que deve ser executado após o início da compilação do
     * conteúdo armazenado no diretório de trabalho dentro do sistema.
     * Obedecendo a mesma regra de execução, quando houver a necessidade de
     * execução de muitos plugins, precisamos criar um novo que execute as
     * dependências necessárias.
     *
     * @param  string $name Nome do Plugin
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function setAfterPlugin($name) {
        // Configuração
        $this->_afterPlugin = (string) $name;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Nome do Plugin de Execução Posterior
     *
     * Informa o nome do plugin que deve ser utilizado para processamento
     * posterior ao compilador. Este plugin pode executar outros elementos
     * conforme necessidade. O nome do plugin pode ser apresentado ao método de
     * execução, onde este irá tratar o elemento conforme o estado do
     * gerenciamento.
     *
     * @return string Valor Solicitado
     */
    public function getAfterPlugin() {
        // Apresentação
        return $this->_afterPlugin;
    }

    /**
     * Execução de Plugin
     *
     * Durante o tempo de compilação, existem dois tempos que devem ser
     * considerados: anterior e posterior à compilação. Para isto, o gerenciador
     * deve armazenar estes tempos e, quando chamada a execução de um plugin,
     * o gerenciador deve verificar se aquele objeto pode executar tal tarefa e
     * executar o método solicitado. Quando esta execução é chamada fora desse
     * fluxo, nada será executado pelos plugins.
     *
     * @param  string $name Nome do Plugin
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function execute($name) {
        // Verificação de Estado
        switch ($this->_state) {

            case 'BEFORE':
                // Carregar Elemento
                $plugin = $this->_loader->load($name);
                if (empty($plugin)) {
                    // Plugin não Encontrado
                    throw new WSL_Compiler_PluginException('Invalid Element');
                }
                // Verificar Tipagem
                if (!($plugin instanceof WSL_Compiler_PluginBeforeInterface)) {
                    // Plugin Inválido
                    throw new WSL_Compiler_PluginException('Invalid Element');
                }
                // Execução
                $plugin->beforeAction($this);
                break;

            case 'AFTER':
                // Carregar Elemento
                $plugin = $this->_loader->load($name);
                if (empty($plugin)) {
                    // Plugin não Encontrado
                    throw new WSL_Compiler_PluginException('Invalid Element');
                }
                // Verificar Tipagem
                if (!($plugin instanceof WSL_Compiler_PluginAfterInterface)) {
                    // Plugin Inválido
                    throw new WSL_Compiler_PluginException('Invalid Element');
                }
                // Execução
                $plugin->afterAction($this);
                break;

            case 'DISABLED':
            default:
                // Não Executar Tarefas

        }
        // Encadeamento
        return $this;
    }

    /**
     * Configuração do Contexto
     *
     * Possibilidade de encapsulamento do configurador de contexto de execução
     * do gerenciador de plugins. Este contexto serve como meio de acesso aos
     * arquivos utilizados pelo compilador para processamento do documento.
     *
     * @param  WSL_Compiler_Context $context Elemento para Configuração
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    protected function _setContext(WSL_Compiler_Context $context) {
        // Configuração
        $this->_context = $context;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação do Contexto
     *
     * O contexto de execução é um objeto utilizado que é apresentado junto com
     * o gerenciador para armazenar informações sobre a execução, como nomes de
     * elementos considerados como arquivos durante o processamento.
     *
     * @return WSL_Compiler_Context Elemento Solicitado
     */
    public function getContext() {
        // Apresentação
        return $this->_context;
    }

    /**
     * Compilação
     *
     * Executa toda a etapa de compilação do documento LaTeX dentro do sistema,
     * chamando todos os plugins necessários para execução e gerenciando os
     * contextos utilizados.
     *
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function compile() {

        // Diretório Atual
        $current = getcwd();

        try {

            // Área de Trabalho
            chdir($this->getContext()->getPath());

            // Chamada de Plugins
            $name = $this->getBeforePlugin();
            // Configurar Estado
            $this->_state = 'BEFORE';
            // Executar Elemento
            $this->execute($name);

            // Execução Interna
            $this->_compile();

            // Chamada de Plugins
            $name = $this->getAfterPlugin();
            // Configurar Estado
            $this->_state = 'AFTER';
            // Executar Elemento
            $this->execute($name);

            // Configurar Estado
            $this->_state = 'DISABLED';

        } catch (WSL_Compiler_PluginException $e) {

            // Configurar Estado
            $this->_state = 'DISABLED';
            // Diretório Anterior
            chdir($current);
            // Apresentar Erro
            throw new WSL_Compiler_ManagerException('Internal Error', 500, $e);

        }

        // Diretório Anterior
        chdir($current);

        // Encadeamento
        return $this;
    }

    /**
     * Compilação do Documento
     *
     * Método responsável pela execução do compilador principal do sistema, onde
     * serão criados todos os conteúdos de saída básica para criação do
     * documento no formato principal de saída LaTeX.
     *
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    protected function _compile() {
        // Criação de Descritores
        $descriptors = array(
            1 => array('file', 'wsl-stdout.log', 'w'), // Saída Padrão
            2 => array('file', 'wsl-stderr.log', 'w'), // Saída de Erro
        );
        // Chamada LaTeX
        $process = proc_open('latex -interaction=batchmode -file-line-error document.tex', $descriptors, $pipes);
        // Recurso Inicializado?
        if (is_resource($process)) {
            // Ocioso
            $idle = true;
            // Executar até Finalização
            while ($idle) {
                // Tempo Ocioso
                usleep(500);
                // Informações sobre Processo
                $information = proc_get_status($process);
                // Continuar Ocioso?
                $idle = (($information !== false) && ($information['running']));
            }
            // Finalizar Processo
            $result = proc_close($process);
            // Arquivo Básico de Saída
            $this->getContext()->touch('document.dvi');
            // Resultado?
            if ($result === 0) {
                // Configurar
                $this->getContext()->setOutput('document.dvi');
            }
        }
        // Encadeamento
        return $this;
    }

}
