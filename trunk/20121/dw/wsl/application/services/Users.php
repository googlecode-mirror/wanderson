<?php

/**
 * Serviço de Usuários
 *
 * @category Application
 * @package  Application_Service
 */
class Service_Users {

    /**
     * Apresentar Usuários Cadastrados
     * @return array[] Conjunto de Usuários Cadastrados
     */
    public function fetch() {
        // Filtro de Parâmetros
        $args = func_get_args();
        foreach (array('token') as $identifier) {
            $$identifier = array_shift($args);
        }
        // Camada de Modelo
        $model = new Model_Users();
        // Verificar Credenciais
        $result = array();
        // Habilitado?
        if ($model->check($token, true /* admin */)) {
            // Consultar Informações
            $result = $model->fetch();
        }
        // Apresentar Resultados
        return $result;
    }

    /**
     * Autenticação no Sistema
     *
     * Para utilização do Webservice em determinados pontos, precisamos que o
     * usuário efetue uma autenticação no sistema. Esta autenticação é feita
     * informando o seu e-mail e hash. Comparados, será disponibilizado um token
     * para utilização. Este token permanece ativo por tempo determinado.
     *
     * @param  string $email E-mail Cadastrado no Sistema
     * @param  string $hash  Hash Utilizado pelo Usuário
     * @return string Token Disponibilizado para Autenticação
     */
    public function login() {
        // Filtro de Parâmetros
        $args = func_get_args();
        foreach (array('email', 'hash') as $identifier) {
            $$identifier = array_shift($args);
        }
        // Camada de Modelo
        $model = new Model_Users();
        // Autenticação
        $result = $model->login($email, $hash);
        // Apresentar Resultados
        return $result;
    }

}

