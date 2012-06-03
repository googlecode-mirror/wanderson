<?php

/**
 * Camada de Modelo para Compilador
 *
 * Utiliza elementos para criar um documento no formato LaTeX conforme
 * parâmetros de requisição apresentados. Utiliza a biblioteca de compilação de
 * arquivos LaTeX desenvolvida, aplicando assim as regras de negócio.
 *
 * @category Application
 * @package  Application_Model
 */
class Model_Compiler {

    /**
     * Executa o Compilador
     *
     * Recebe como parâmetros as informações passadas durante a requisição para
     * executar o compilador de documentos LaTeX. O primeiro parâmetro
     * apresentado é o nome do Plugin para execução de entrada de conteúdo; o
     * segundo representa o nome do Plugin de saída; e o último parâmetro é um
     * conjunto de documentos que devem ser compilados para saída do documento
     * no formato desejado.
     *
     * @param  string $input     Nome do Plugin de Entrada
     * @param  string $output    Nome do Plugin de Saída
     * @param  array  $documents Conjunto de Documentos para Compilação
     * @return array  Conjunto de Informações para Documento Resultado
     * @throws Exception Hash não Apresentado
     * @throws Exception Nome de Arquivo não Apresentado
     * @throws Exception Hash Inválido
     */
    public function compile($input, $output, array $documents) {
        // Documentos Apresentados?
        if (empty($documents)) {
            // Sem Compilação
            return array();
        }
        // Inicialização
        $elements = array();
        // Capturar Documentos
        foreach ($documents as $document) {
            // Hash Apresentado?
            if (empty($document['hash'])) {
                // Erro Encontrado
                throw new Exception('Empty Hash');
            }
            // Nome de Arquivo Apresentado?
            if (empty($document['filename'])) {
                // Erro Encontrado
                throw new Exception('Empty Filename');
            }
            // Apresentado Conteúdo?
            if (!empty($document['content'])) {
                // Criar Novo Documento
                $element = WSL_Model_File_File::buildFromContent($document['filename'], base64_decode($document['content']));
            } else {
                // Criação por Hash
                $search = WSL_Model_File_File::findFromHashes(array($document['hash']));
                // Capturar Elemento
                $element = reset($search);
                // Elemento Existe?
                if (!$element->exists()) {
                    throw new Exception("Invalid Hash: '{$document['hash']}'");
                }
                // Salvar Nome de Arquivo
                $element->setFileName($document['filename']);
            }
            // Salvar Elemento
            $element->save();
            // Anexar Elemento
            $elements[] = $element;
        }
        // Inicialização de Contexto
        $context = new WSL_Compiler_Context();
        // Cópia de Arquivos
        foreach ($elements as $element) {
            $context->copy($element->getFileName(), $element->getRealPath());
        }
        // Inicialização de Compilador
        $compiler = new WSL_Compiler_Manager($context);
        $compiler // Configuração
            ->setBeforePlugin($input)
            ->setAfterPlugin($output);
        // Execução
        $compiler->compile();
        // Capturar Documento Resultante
        $output = $context->getOutput(true /* caminho completo */);
        // Existe Saída?
        if (empty($output)) {
            // Sem Arquivos
            return array();
        }
        // Adicionar Arquivo Resultado
        $element = WSL_Model_File_File::buildFromRealPath($output);
        $element->setFileName($context->getOutput());
        // Resultados
        $result = array(
            'hash'     => $element->getHash(),
            'filename' => $element->getFileName(),
            'content'  => base64_encode($element->getContent()),
        );
        $element->save();
        // Apresentação
        return $result;
    }

}
