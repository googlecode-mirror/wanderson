<?php

/**
 * Serviço de Compilação de Documentos
 *
 * Camada de fronteira para processamento de serviço de compilação de documentos
 * utilizando recursos do LaTeX. Possibilita a utilização de Plugins disponíveis
 * no servidor para manipular os dados enviados e processados, informando assim
 * o tipo de entrada e saída requerido pelo cliente.
 *
 * @category Application
 * @package  Application_Service
 */
class Service_Compiler {

    /**
     * Compilação de Documentos
     *
     * Possibilidade de construção de documentos utilizando o gerenciamento de
     * compilação instalado no servidor. Necessária informação de Plugins de
     * entrada e saída, informando assim o tipo de documento enviado e requerido
     * durante o processamento. Também é informado os documentos que devem ser
     * utilizados para criação do documento de saída.
     *
     * @param  string $input     Plugin de Entrada para Utilização
     * @param  string $output    Plugin de Saída para Utilização
     * @param  array  $documents Documentos para Processamento
     * @return array  Informações sobre o Documento Resultante
     */
    public function compile() {
        // Captura de Parâmetros
        $input     = (string) func_get_arg(0);
        $output    = (string) func_get_arg(1);
        $documents = func_get_arg(2);
        $documents = (is_array($documents) ? $documents : array());
        // Camada de Modelo
        $model = new Model_Compiler();
        // Processamento
        $result =  $model->compile($input, $output, $documents);
        // Apresentação
        return $result;
    }

}
