<?php

/**
 * Adaptador de Banco de Dados MySQL
 *
 * @category WSL
 * @package  WSL_Db
 */
class WSL_Db_Adapter_MySQL {

    /**
     * Recurso de Conexão
     * @var resource
     */
    protected $_connection = null;

    /**
     * Parâmetros para Conexão
     * @var string[]
     */
    protected $_params = array();

    /**
     * Construtor
     *
     * Recebe todos os parâmetros necessários para inicializar a conexão com o
     * Banco de Dados MySQL. São obrigatórios os valores para endereço de
     * conexão, nome do banco de dados, nome de usuário e senha.
     *
     * @param string[] $params Conjunto de Informações para Conexão
     */
    public function __construct(array $params) {
        $this->_setParams($params);
    }

    // Destruidor
    public function __destruct() {
        // Conexão Efetuada?
        if ($this->_connection !== null) {
            // Fechar Recurso MySQL
            mysql_close($this->_connection);
        }
    }

    /**
     * Parâmetros de Inicialização
     *
     * Informações para inicializar a conexão ao Banco de Dados solicitado.
     * Estes parâmetros são utilizados somente quando a conexão estiver sendo
     * solicitada, portanto são acessados sob demanda.
     *
     * @param  string[] $params Conjunto de Informações para Conexão
     * @return WSL_Db_Adapter_MySQL Próprio Objeto para Encadeamento
     */
    protected function _setParams(array $params) {
        // Verificar Parâmetros
        foreach (array('host', 'dbname', 'username', 'password') as $param) {
            // Verificar Existência de Parâmetro Obrigatório
            if (!array_key_exists($param, $params)) {
                // Apresentar Erro de Configuração
                throw new Exception("Parâmetro Inválido: '$param'", 500);
            }
        }
        // Registrar Parâmetros
        $this->_params = array_merge($this->_params, $params);
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta os Parâmetros de Conexão
     *
     * @return string[] Conjunto de Informações para Conexão
     */
    public function getParams() {
        // Apresentação
        return $this->_params;
    }

    /**
     * Captura de Conexão
     *
     * Acesso ao recurso de conexão disponível para o Banco de Dados, utilizando
     * informações apresentadas no momento da construção do objeto adaptador. Os
     * métodos internos ao adaptador utilizam este acesso para inicializar a
     * conexão sob demanda.
     *
     * @return resource Recurso para Conexão ao Banco de Dados
     */
    protected function _getConnection() {
        // Recurso Inicializado?
        if ($this->_connection === null) {
            // Parâmetros para Conexão
            $p = $this->getParams();
            // Criar o Recurso de Conexão
            $r = mysql_connect($p['host'], $p['username'], $p['password']);
            // Conexão Efetuada?
            if (empty($r)) {
                // Apresentar Erro
                throw new Exception('Impossível Conectar ao MySQL', 500);
            }
            // Selecionar o Banco de Dados
            if (!mysql_select_db($p['dbname'], $r)) {
                // Apresentar Erro
                throw new Exception('Erro ao Selecionar Banco de Dados', 500);
            }
            // Selecionar Caracteres
            mysql_set_charset('utf8', $r);
            // Configurar Recurso
            $this->_connection = $r;
        }
        // Apresentação
        return $this->_connection;
    }

    /**
     * Executar Consulta ao Banco de Dados
     *
     * Recebe como parâmetro uma execução com Banco de Dados MySQL e apresenta
     * informações sobre os resultados, encapsulando todas as necessidades
     * utilizadas e regras para manipular os recursos de conexão. Dependendo do
     * tipo de instrução utilizada, será apresentado um valor verdadeiro se esta
     * não possuir retorno, ou um conjunto de dados se existem retornos a serem
     * apresentados.
     *
     * @return true|array Resultado da Execução no Banco de Dados
     * @throws Exception  Problema Encontrado durante a Execução do Comando
     */
    public function query($sql) {
        // Resultado Inicial
        $result = true;
        // Conexão Utilizada
        $connection = $this->_getConnection();
        // Executar Consulta
        $r = mysql_query($sql, $connection);
        // Erro Encontrado?
        if ($r === false) {
            // Mensagem e Código do Erro
            $message = mysql_error($connection);
            $code    = mysql_errno($connection);
            // Apresentar Erro Encontrado
            throw new Exception($message, $code);
        }
        // Verificar Tipo de Resultado
        if (is_resource($r)) {
            // Resultado com Conteúdo
            $result = array();
            // Capturar Todas Informações
            while (($content = mysql_fetch_array($r, MYSQL_ASSOC)) !== false) {
                // Aplicar Resultado
                $result[] = $content;
            }
            // Liberar Resultado
            mysql_free_result($r);
        }
        // Apresentar Resultado
        return $result;
    }

}

