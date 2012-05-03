<?php

/**
 * Camada de Modelo para Usuários
 *
 * @category Application
 * @package  Application_Model
 */
class Model_Users {

    /**
     * Ofuscar Valor
     *
     * @param  string $value Valor para Processamento
     * @return string Conteúdo Processado
     */
    public static function salt($value) {
        return sha1('3520e0dc3650aac' . md5($value) . '630c6ccebdd6867e8');
    }

    public static function filter($identifier, $container, $default, $typed = 'string') {
        $value = $default;
        if (array_key_exists($identifier, $container)) {
            $value = $container[$identifier];
        }
        eval("return ($typed) \$value;");
    }

    /**
     * Salvar Usuário
     *
     * Para gerenciar usuários no sistema, precisamos informar alguns dados
     * ao sistema. Todos os dados apresentados serão salvos no banco de dados e
     * se a chave primária estiver sendo apresentada, será executada uma
     * atualização do dado.
     *
     * @param  mixed[] $data Informações para Salvamento
     * @return int Identificador do Usuário Salvo
     */
    public function save($data) {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Filtro de Dados
        $data['email'] = self::filter('email', $data, null, 'string');
    }

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
     * Verificação de Token
     *
     * Após uma autenticação, o usuário receberá um token que será apresentado
     * junto aos outros elementos e que será considerado como o identificador de
     * sessão do mesmo. Este token será comparado com informações armazenadas no
     * banco de dados e este método busca verificar se o usuário pode ou não
     * utilizar tais recursos.
     *
     * @param  string $token Valor do Token Apresentado ao Usuário
     * @param  bool   $admin Requisições Administradoras
     * @return bool   Resultado da Verificação de Possibilidade de Utilização
     */
    public function check($token, $admin = false) {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Conversão
        $token = (string) $token;
        $admin = (int) $admin;
        // Consultar Usuário
        $sql = <<<SQL
SELECT UNIX_TIMESTAMP(`u`.`session`) AS `timestamp`
    FROM `wsl_users` AS `u`
    WHERE `u`.`token` = '$token' AND `u`.`admin` <= $admin
SQL;
        // Consulta
        $search = $adapter->query($sql);
        // Resultado Inicial
        $result = false;
        // Elemento Encontrado?
        if (!empty($search)) {
            // Construção de Elemento
            $element = current($search);
            // Verificação de Token
            $result = (time() <= ($element['timestamp'] + 300));
        }
        // Apresentar Resultado
        return $result;
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
    `u`.`id`, `u`.`email`, `u`.`hash`, (`u`.`hash` = '$hash') AS `compare`
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
                $seed  = date('Y-m-d H:i:s');
                $token = self::salt($seed);
                // Identificador
                $id = $element['id'];
                // Sessão Utilizada
                $sql = <<<SQL
UPDATE `wsl_users` SET `session` = '$seed', `token` = '$token' WHERE `id` = $id
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

