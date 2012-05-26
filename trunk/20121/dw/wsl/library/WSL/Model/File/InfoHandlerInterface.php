<?php

interface WSL_Model_File_InfoHandlerInterface {

    /**
     * Pesquisa de Hashes
     *
     * Apresenta um conjunto de Hashes conforme parâmetros apresentados pela
     * camada de modelo para arquivos, buscando carregá-los posteriormente.
     * Estes Hashes serão referências para arquivos em disco.
     *
     * @param  string $container Recipiente de Elementos
     * @param  string $category  Categoria dos Arquivos
     * @param  string $reference Referência Cruzada
     * @return array  Conjunto de Hashes Relacionados
     */
    public function find($container, $category, $reference);

    /**
     * Carregar Informações de Arquivos
     *
     * Método utilizado para carregar informações adicionais aos arquivos
     * apresentados, previamente construídos com os hashes apresentados.
     *
     * @param  array $files Conjunto de Arquivos
     * @return WSL_Model_File_InfoHandlerInterface Próprio Objeto para Encadeamento
     */
    public function load(array $files);

    /**
     * Salvar Informações
     *
     * Utilizado para persistência de informações adicionais que não são
     * relacionadas ao arquivo utilizado.
     *
     * @param  WSL_Model_File_File $file Elemento Utilizado
     * @return bool Confirmar Salvamento em Disco do Arquivo
     */
    public function save(WSL_Model_File_File $file);
    public function delete(WSL_Model_File_File $file);
}