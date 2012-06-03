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
     *
     * @param  string $token Token de Autenticação
     * @return array[] Conjunto de Usuários Cadastrados
     */
    public function fetch() {
        // Captura de Parâmetros
        $token = (string) func_get_arg(0);
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
     * Salvar Usuário
     *
     * Recebe as informações do usuário que devem ser salvas no sistema e acessa
     * a camada de modelo para salvar usuários no sistema. Verifica
     * primeiramente se o usuário atual possui as credenciais para alteração de
     * informações de usuário. Apresenta o identificador do usuário que foi
     * criado ou salvo no sistema.
     *
     * @param  string  $token Token de Autenticação do Usuário
     * @param  mixed[] Informações sobre Usuário
     * @return int Identificador do Usuário
     */
    public function save() {
        // Filtro de Parâmetros
        $args = func_get_args();
        foreach (array('token', 'data') as $identifier) {
            $$identifier = array_shift($args);
        }
        // Camada de Modelo
        $model = new Model_Users();
        // Resultado Inicial
        $result = 0;
        // Verificar Credenciais
        if ($model->check($token, true /* admin */)) {
            // Cadastrar Informações
            $result = $model->save($data);
        }
        // Apresentar Resultados
        return $result;
    }

    /**
     * Remover Usuário
     *
     * Recebendo como parâmetro o identificador do usuário, acessa a camada de
     * modelo que remove todas as entradas e relacionamentos do usuário no banco
     * de dados. Apresenta uma confirmação de remoção com sucesso sobre o dado
     * solicitado.
     *
     * @param  string $token Token de Autenticação do Usuário
     * @param  int    $id    Identificador do Usuário para Remoção
     * @return bool   Confirmação de Usuário Removido com Sucesso
     */
    public function remove() {
        // Filtro de Parâmetros
        $args = func_get_args();
        foreach (array('token', 'id') as $identifier) {
            $$identifier = array_shift($args);
        }
        // Camada de Modelo
        $model = new Model_Users();
        // Resultado Inicial
        $result = false;
        // Verificar Credenciais
        if ($model->check($token, true /* admin */)) {
            // Remover Informações
            $result = $model->remove($id);
        }
        // Apresentar Resultados
        return $result;
    }

    /**
     * Alteração de Hash de Usuário
     *
     * Existem alguns casos que o hash utilizado pelo usuário necessita ser
     * modificado, visando segurança. Para isto, esta ação do serviço solicita
     * para a camada de modelo a alteração deste conteúdo e apresenta ao cliente
     * este valor alterado.
     *
     * @param  string $token Token de Autenticação do Usuário
     * @param  int    $id    Identificador do Usuário para Alteração de Hash
     * @return string Conteúdo do Novo Hash Gerado
     */
    public function hash() {
        // Filtro de Parâmetros
        $args = func_get_args();
        foreach (array('token', 'id') as $identifier) {
            $$identifier = array_shift($args);
        }
        // Camada de Modelo
        $model = new Model_Users();
        // Resultado Inicial
        $result = null;
        // Verificar Credenciais
        if ($model->check($token, true /* admin */)) {
            // Remover Informações
            $result = $model->hash($id);
        }
        // Apresentar Resultados
        return $result;
    }

}

