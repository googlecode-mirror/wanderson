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
     * utilizados para criação do documento de saída. O usuário necessita estar
     * autenticado no sistema para utilizar este serviço.
     *
     * @param  string $token     Token de Autenticação
     * @param  string $input     Plugin de Entrada para Utilização
     * @param  string $output    Plugin de Saída para Utilização
     * @param  array  $documents Documentos para Processamento
     * @return array  Informações sobre o Documento Resultante
     */
    public function compile() {
        // Captura de Parâmetros
        $token     = (string) func_get_arg(0);
        $input     = (string) func_get_arg(1);
        $output    = (string) func_get_arg(2);
        $documents = func_get_arg(3);
        $documents = (is_array($documents) ? $documents : array());
        // Camada de Modelo
        $model = new Model_Users();
        // Verificar Token de Autenticação
        $user = $model->check($token);
        // Existe Referência?
        if (!empty($user)) {
            // Apresentar Erro de Autenticação
            throw new Exception('Authentication Error', 403);
        }
        // Camada de Modelo
        $model = new Model_Compiler();
        // Processamento
        $result = $model->compile($user, $input, $output, $documents);
        // Apresentação
        return $result;
    }

    /**
     * Autenticação de Usuário
     *
     * Apresentando como primeiro parâmetro o e-mail do usuário e como segundo o
     * seu hash cadastrado no sistema, será apresentado um token de autenticação
     * resultante se as credenciais apresentadas estiverem válidas.
     *
     * @param  string $email E-mail Utilizado pelo Usuário
     * @param  string $hash  Hash Cadastrado para o E-mail
     * @return string Token de Autenticação
     */
    public function login() {
        // Captura de Parâmetros
        $email = (string) func_get_arg(0);
        $hash  = (string) func_get_arg(1);
        // Camada de Modelo
        $model = new Model_Users();
        // Processamento
        $result = $model->login($email, $hash);
        // Apresentação
        return $result;
    }

}
