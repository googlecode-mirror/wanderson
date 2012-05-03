<?php

/**
 * Camada de Modelo para Usuários
 *
 * @category Application
 * @package  Application_Model
 */
class Model_Users {

    /**
     * Consulta de Usuários
     *
     * Acesso ao cadastro de usuários do sistema, utilizados para autenticação e
     * utilização deste, incluindo registro de sessões utilizadas.
     *
     * @return array[] Conjunto de Usuários Utilizados
     */
    public function fetch() {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Exibir Adaptador
        return $adapter->query('SELECT `id`, `email`, `active`, `admin` FROM `wsl_users`');
    }

    /**
     * Autenticação
     *
     * Ação utilizada para efetuar a autenticação de um usuário dentro do
     * sistema. Para utilizar o serviço, o usuário necessita efetuar uma
     * autenticação no sistema, apresentando informações sobre e-mail e hash
     * utilizado, que serão comparados com a base de dados. Caso as informações
     * estiverem corretas, será apresentado um token que deve ser considerado
     * como sessão atual do usuário, necessitando ser enviado sempre que algum
     * recurso do servidor estiver sendo utilizado.
     *
     * @param  string $email E-mail do Usuário Cadastrado
     * @param  string $hash  Hash do Usuário para Autenticação
     * @return string Token de Autenticação
     */
    public function login($email, $hash) {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Filtro de Informações
        $email = (string) $email;
        $hash  = (string) $hash;
        // Consulta
        $sql = <<<SQL
SELECT
    `u`.`id`,
    `u`.`email`,
    `u`.`hash`,
    (`u`.`hash` = '$hash') AS `compare`
FROM `wsl_users` AS `u` WHERE `u`.`email` = '$email'
SQL;
        // Consulta de Informações
        $result = $adapter->query($sql);
        // Verificação
        if (!empty($result)) {
            // Elemento Encontrado
            $element = current($result);
            // Comparação de Senhas
            if ($element['compare']) {
                // Credenciais Válidas
                $seed  = date('c');
                $token = sha1($element['hash'] . $seed . sha1('123456'));
                // Identificador
                $id = $element['id'];
                // Sessão Utilizada
                $sql = <<<SQL
UPDATE `wsl_users` SET `session` = '$seed' WHERE `id` = $id
SQL;
                // Salvar Informações
                $adapter->query($sql);
            } else {
                // Hash não Encontrado
                $token = null;
            }
        } else {
            // Usuário não Encontrado
            $token = null;
        }
        // Apresentação
        return $token;
    }
}

