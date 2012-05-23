<?php

/**
 * Contexto de Execução
 *
 * Estrutura utilizada para comunicação entre diferentes elementos de execução
 * do gerenciador de compilação para LaTeX. Utilizando componentes no formato de
 * plugins, estes podem registrar parâmetros ou consultar neste contexto.
 *
 * @category WSL
 * @package  WSL_Compiler
 */
class WSL_Compiler_Context {

    /**
     * Diretório de Trabalho
     * @staticvar string
     */
    protected static $_workspacePath = null;

    /**
     * Diretório de Contexto
     * @var string
     */
    protected $_path = null;

    /**
     * Elementos
     * @var string[]
     */
    protected $_elements = array();

    /**
     * Construtor Padrão
     *
     * Inicializa o contexto para execução do processamento, incluindo um novo
     * subdiretório temporário no caminho estático configurado para o sistema.
     */
    public function __construct() {
        // Inicialização
        $this->_initPath();
    }

    /**
     * Destruidor Padrão
     *
     * Durante a finalização do objeto, existe a necessidade de remoção do
     * diretório criado para o contexto de execução.
     */
    public function __destruct() {
        // Finalização
        self::clear($this->getPath());
    }

    /**
     * Configuração do Diretório de Contexto
     *
     * @return WSL_Compiler_Context Próprio Objeto para Encadeamento
     */
    protected function _initPath() {
        // Diretório Temporário
        $pathname = self::$_workspacePath . DIRECTORY_SEPARATOR . microtime(true);
        $result   = @mkdir($pathname, 0777, true);
        if (!$result) {
            throw new WSL_Compiler_PluginException('Invalid Directory');
        }
        // Configuração
        $this->_path = $pathname;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação do Diretório de Contexto
     *
     * @param  string $element Possibilidade de Concatenação com Elemento
     * @return string Valor Configurado
     */
    public function getPath($element = null) {
        // Captura
        $path = $this->_path;
        // Elemento Informado?
        if ($element !== null) {
            $path = $this->_path . DIRECTORY_SEPARATOR . $element;
        }
        // Apresentação
        return $path;
    }

    /**
     * Cópia de Elemento para Diretório de Trabalho
     *
     * O fluxo de compilação é executado dentro do diretório de trabalho do
     * contexto. Neste diretório, serão armazenados todos os arquivos
     * necessários para a compilação do documento; porém nem todos os arquivos
     * estão neste diretório e necessitam ser copiados.
     *
     * @param  string $element  Nome do Elemento
     * @param  string $filename Caminho do Arquivo para Cópia
     * @return WSL_Compiler_Context Próprio Objeto para Encadeamento
     */
    public function copy($element, $filename) {
        // Arquivo Existe?
        if (!is_readable($filename)) {
            throw new WSL_Compiler_PluginException('Invalid Filename');
        }
        // Criar Hardlink
        link($filename, $this->getPath($element));
        // Registrar Elemento
        if (!$this->has($element)) {
            $this->_elements[] = $element;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Criação de Arquivo
     *
     * Registra o elemento no contexto, criando um arquivo localmente caso este
     * não exista. Adiciona o elemento no conteúdo do objeto para posterior
     * utilização.
     *
     * @param  string $element Nome do Elemento
     * @return WSL_Compiler_Context Próprio Objeto para Encadeamento
     */
    public function touch($element) {
        // Criação de Elemento
        $result = @touch($this->getPath($element));
        if (!$result) {
            throw new WSL_Compiler_PluginException('Invalid Element');
        }
        // Registrar Elemento
        if (!$this->has($element)) {
            $this->_elements[] = $element;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Verifica a Existência de Elemento
     *
     * @param  string $element Nome do Elemento
     * @return bool Confirmação de Existência
     */
    public function has($element) {
        // Consulta
        return array_search($element, $this->_elements) !== false;
    }

    /**
     * Configuração do Caminho para Diretório de Trabalho
     *
     * O diretório de trabalho é aquele que recebe todos os arquivos temporários
     * para compilação do documento LaTeX. Para isto, será criado um
     * subdiretório com nome randômico para que o contexto armazene seus
     * arquivos necessários.
     *
     * @param string $path Valor para Configuração
     */
    public static function setWorkspacePath($path) {
        // Configuração
        self::$_workspacePath = (string) $path;
    }

    /**
     * Captura do Caminho para Diretório de Trabalho
     *
     * O diretório de trabalho é aquele que recebe todos os subdiretórios
     * temporários de contextos que servem para compilação do documento fonte no
     * formato LaTeX para a saída desejada pelo cliente.
     *
     * @return string Valor Configurado
     */
    public static function getWorkspacePath() {
        // Diretório Vazio?
        if (empty(self::$_workspacePath)) {
            // Diretório Temporário do Sistema
            self::$_workspacePath = sys_get_temp_dir();
        }
        // Apresentação
        return self::$_workspacePath;
    }

    /**
     * Limpeza Recursiva de Arquivos
     *
     * Método padrão para limpeza recursiva de arquivos no sistema em diretórios
     * que não estão vazios. Utilizado principalmente na destruição dos objetos.
     *
     * @return null
     */
    protected static function clear($path) {
        // Captura de Elementos Internos
        foreach (glob($path . DIRECTORY_SEPARATOR . '*') as $element) {
            // Diretório?
            if (is_dir($element)) {
                // Limpeza Recursiva
                self::clear($element);
            } else {
                // Remoção de Arquivo
                unlink($element);
            }
        }
        // Remoção de Diretório Local
        rmdir($path);
    }

}
