<?php

/**
 * Serviço de Usuários
 *
 * @category Application
 * @service  Users
 * @package  Application_Service
 */
class Service_Users {

    /**
     * Salvar Usuário
     *
     * @request  int      $id    Identificador do Usuário
     * @request  string   $email E-mail para Configuração
     * @response int      $id    Identificador do Usuário
     * @response string   $hash  Código Hash do Usuário Atual
     * @response string   $email E-mail Configurado
     * @return   string[] Confirmação de Salvamento
     */
    public function save() {
        // Apresentação
        return array(
            'id'    => 1,
            'hash'  => '123456',
            'email' => 'wandersonwhcr@gmail.com',
        );
    }

    /**
     * Apresentar Usuários Cadastrados
     *
     * @response string[] $hash  Hash do Usuário
     * @response string   $email E-mail Utilizado como Nome do Usuário
     */
    public function fetch() {
        // Camada de Modelo
        $model = new Model_Users();
        // Consultar Informações
        $result = $model->fetch();
        // Apresentar Resultados
        return $result;
    }

}

