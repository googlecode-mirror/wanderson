<?php

/**
 * Manipulador de Arquivos em Banco de Dados
 *
 * Utilizado pelo gerenciamento de arquivos para salvar informações adicionais
 * de elementos salvos. Estes valores são armazenados em tabela já previamente
 * estruturada.
 *
 * @category   WSL
 * @package    WSL_Model
 * @subpackage File
 */
class WSL_Model_File_DbInfoHandler implements WSL_Model_File_InfoHandlerInterface {

    /**
     * Adaptador de Banco de Dados
     * @var WSL_Db_Adapter_MySQL
     */
    protected $_adapter = null;

    /**
     * Informações Consultadas
     * @var array
     */
    protected $_pool = array();

    /**
     * Inicializa o Manipulador de Arquivos para Banco de Dados
     *
     * Utilizado pela camada de modelo para arquivos para consulta de valores
     * adicionais aos arquivos armazenados em disco, servindo como apoio durante
     * a criação de objetos.
     *
     * @param WSL_Db_Adapter_MySQL $adapter Adaptador de Conexão
     */
    public function __construct(WSL_Db_Adapter_MySQL $adapter) {
        // Configurações
        $this->_setAdapter($adapter);
    }

    /**
     * Contabilização de Quantidades de Hash
     *
     * Efetua uma contabilização de quantos elementos salvos em banco de dados
     * estão utilizando aquele valor de Hash para que o elemento em disco seja
     * ou não salvo em disco.
     *
     * @param  string $hash Valor para Consulta
     * @return int    Quantidade de Elementos Encontrados
     */
    protected function _count($hash) {
        // Construção de Consulta
        $sql = <<<SQL
SELECT
	COUNT(`f`.`id`) AS `counter`
FROM `wsl_files` AS `f`
WHERE
	`f`.`hash` = '$hash'
SQL;
        // Execução
        $result = $this->getAdapter()->query($sql);
        // Resultado
        $result = reset($result);
        return $result['counter'];
    }

    /**
     * Configura o Adaptador de Conexão com Banco de Dados
     *
     * @param  WSL_Db_Adapter_MySQL $adapter Valor para Configuração
     * @return WSL_Model_File_DbInfoHandler Próprio Objeto para Encadeamento
     */
    protected function _setAdapter(WSL_Db_Adapter_MySQL $adapter) {
        // Configuração
        $this->_adapter = $adapter;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Adaptador de Conexão com Banco de Dados
     *
     * @return WSL_Db_Adapter_MySQL Valor Configurado
     */
    public function getAdapter() {
        // Apresentação
        return $this->_adapter;
    }

    /**
     * Registrar Informações Adicionais
     *
     * Durante a pesquisa inicial, serão apresentados informações adicionais
     * para consulta de arquivos. Porém, estas somente são solicitadas em passo
     * posterior. Visando melhorar o processamento, as informações adicionais
     * são salvas para posterior consulta.
     *
     * @param  string $container Recipiente
     * @param  string $category  Categoria
     * @param  string $reference Referência
     * @param  array  $params    Parâmetros para Registro
     * @return WSL_Model_File_DbInfoHandler Próprio Objeto para Encadeamento
     */
    protected function _register($container, $category, $reference, $params) {
        // Armazenar Informações
        $index = "$container-$category-$reference";
        $this->_pool[$index] = $params;
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Informações Adicionais
     *
     * As informações adicionais cadastradas anteriormente podem ser limpas do
     * elemento de armazenamento durante o carregamento de informações
     * adicionais.
     *
     * @param  string $container Recipiente
     * @param  string $category  Categoria
     * @param  int    $reference Referência
     * @return array  Conjunto de Informações Adicionais
     */
    protected function _unregister($container, $category, $reference) {
        // Inicialização
        $result = array();
        // Chave de Mapeamento
        $index = "$container-$category-$reference";
        // Existe Informações?
        if (!empty($this->_pool[$index])) {
            // Capturar Informações
            $result = $this->_pool[$index];
            // Desconfiguração
            unset($this->_pool[$index]);
        }
        // Apresentar
        return $result;
    }

    // Consulta de Hashes em Banco de Dados
    public function find($container, $category, $reference) {
        // Inicialização
        $hashes = array();
        $info   = array();
        // Construção de Consulta
        $sql = <<<SQL
SELECT
	`f`.`hash`, `f`.`id`, `f`.`filename`
FROM `wsl_files` AS `f`
WHERE
	`f`.`container` = '$container'
	AND `f`.`category` = '$category'
	AND `f`.`reference` = '$reference'
ORDER BY `f`.`order` ASC
SQL;
        // Consulta ao Banco de Dados
        $result = $this->getAdapter()->query($sql);
        // Limpeza de Informações
        foreach ($result as $element) {
            // Informações Adicionais
            $id        = $element['id'];
            $info[$id] = array(
                'fileName' => $element['filename'],
                'hash'     => $element['hash'],
            );
            // Resultado
            $hashes[] = $element['hash'];
        }
        // Registrar Parâmetros
        $this->_register($container, $category, $reference, $info);
        // Apresentar Resultados
        return $hashes;
    }

    // Carregar Informações Adicionais
    public function load(array $files) {
        // Vazio? Não Consultar
        if (empty($files)) {
            // Encadeamento
            return $this;
        }
        // Capturar Primeiro Elemento
        $element = current($files);
        // Informações
        $container = $element->getContainer();
        $category  = $element->getCategory();
        $reference = $element->getReference();
        // Capturar Informações
        $params = $this->_unregister($container, $category, $reference);
        // Processar Informações
        foreach ($files as $file) {
            // Parâmetros
            foreach ($params as $id => $param) {
                if ($file->getHash() == $param['hash']) {
                    // Registrar Informações
                    $file // Configurações
                        ->setFileName($param['fileName'])
                        ->getConfig()->setParam('id', $id);
                    // Remover Parâmetro
                    unset($params[$id]);
                }
            }
        }
        // Encadeamento
        return $this;
    }

    // Salvar Informações Adicionais
    public function save(WSL_Model_File_File $file) {
        // Persistência de Informações
        $data = array(
            'hash'      => $file->getHash(),
            'filename'  => $file->getFileName(),
            'container' => $file->getContainer(),
            'category'  => $file->getCategory(),
            'reference' => $file->getReference(),
            'order'     => $file->getOrder(),
        );
        // Contabilizar Hashes
        $counter = $this->_count($data['hash']);
        // Identificador Informado?
        if ($file->getConfig()->hasParam('id')) {
            // Atualizar
            $this->getAdapter()->update('wsl_files', $data, array(
                'id' => $file->getConfig()->getParam('id'),
            ));
        } else {
            // Inclusão
            $this->getAdapter()->insert('wsl_files', $data);
        }
        // Adicionar Elemento?
        return $counter == 0;
    }

    public function delete(WSL_Model_File_File $file) {}

}
