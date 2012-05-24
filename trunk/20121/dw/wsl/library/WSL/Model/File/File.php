<?php

class WSL_Model_File_File {

    /**
     * Valor Hash do Arquivo
     * @var string
     */
    protected $_hash = null;

    /**
     * Nome do Recipiente
     * @var string
     */
    protected $_container = '';

    /**
     * Nome da Categoria
     * @var string
     */
    protected $_category = '';

    /**
     * Valor de Referência
     * @var int
     */
    protected $_reference = 0;

    /**
     * Valor de Posicionamento
     * @var int
     */
    protected $_order = 0;

    /**
     * Configuração do Hash do Arquivo
     *
     * @param  string $hash Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    protected function _setHash($hash) {
        // Configuração
        $this->_hash = (string) $hash;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Hash do Arquivo
     *
     * @return string Valor Solicitado
     */
    public function getHash() {
        // Apresentação
        return $this->_hash;
    }

    public function getRealPath() {}
    public function save() {}
    public function delete() {}
    public function equals(WSL_Model_File_File $file) {}

    /**
     * Configuração de Recipiente
     *
     * @param  string $container Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setContainer($container) {
        // Configuração
        $this->_container = (string) $container;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Recipiente
     *
     * @return string Valor Solicitado
     */
    public function getContainer() {
        // Apresentação
        return $this->_container;
    }

    /**
     * Configuração de Categoria
     *
     * @param  string $category Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setCategory($category) {
        // Configuração
        $this->_category = (string) $category;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Categoria
     *
     * @return string Valor Solicitado
     */
    public function getCategory() {
        // Apresentação
        return $this->_category;
    }

    /**
     * Configuração de Referência
     *
     * @param  int $reference Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setReference($reference) {
        // Configuração
        $this->_reference = (int) $reference;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Referência
     *
     * @return int Valor Solicitado
     */
    public function getReference() {
        // Apresentação
        return $this->_reference;
    }

    /**
     * Configuração de Posicionamento
     *
     * @param  int $order Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setOrder($order) {
        // Configuração
        $this->_order = (int) $order;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Posicionamento
     *
     * @return int Valor Solicitado
     */
    public function getOrder() {
        // Apresentação
        return $this->_order;
    }

    public static function factory($params) {}
    public static function findFromReference($container, $category, $reference) {}
    public static function findFromHashes(array $hashes) {}

    /**
     * Sincronização de Elementos
     *
     * Método responsável pela sincronização de elementos, recebendo como
     * parâmetro dois conjuntos de arquivos, onde o primeiro representa os
     * arquivos já salvos no sistema e o outro os arquivos considerados como
     * novos na estrutura. Todos os arquivos do segundo elemento serão
     * considerados, ao final da execução, os novos arquivos com o devido
     * posicionamento necessário e valores atualizados.
     *
     * @param  array $oldfiles Conjunto de Arquivos Antigos
     * @param  array $newfiles Conjunto de Arquivos Novos
     */
    public static function synchronize(array $oldfiles, array $newfiles) {
        // Salvar Posicionamentos
        $counter = 0;
        $element = reset($newfiles);
        while ($element !== false) {
            $element->setOrder($counter++);
            $element = next($newfiles);
        }
        // Remoção de Elementos
        foreach ($oldfiles as $oldfile) {
            $search = null;
            foreach ($newfiles as $newfile) {
                if ($oldfile->equals($newfile)) {
                    $search = $oldfile;
                }
            }
            // Elemento Encontrado?
            if (empty($search)) {
                // Não Encontrado: Remover
                $oldfile->delete();
            }
        }
        // Salvar Elementos Novos
        foreach ($newfiles as $newfile) {
            $newfile->save();
        }
    }

    public static function setDefaultHandler(WSL_Model_File_InfoHandlerInterface $handler) {}
    public static function getDefaultHandler() {}

}
