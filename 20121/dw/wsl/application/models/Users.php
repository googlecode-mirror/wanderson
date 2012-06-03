<?php

/**
 * Camada de Modelo para Usuários
 *
 * @category Application
 * @package  Application_Model
 */
class Model_Users {

    /**
     * Limite de Autenticação em Segundos
     * @var int
     */
    protected $_limit = 300;

    /**
     * Configuração de Limite de Autenticação
     *
     * Tempo em segundos utilizado na comparação de limite máximo para
     * autenticação do usuário. Valor utilizado durante a verificação de usuário
     * habilitado para utilizar o sistema.
     *
     * @param  int $limit Valor para Configuração
     * @return Model_Users Próprio Objeto para Encadeamento
     */
    public function setLimit($limit) {
        // Conversão
        $limit = abs((int) $limit);
        // Configuração
        $this->_limit = $limit;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação de Limite de Autenticação
     *
     * Utilizado durante a validação de usuário autenticado no sistema. Valor em
     * segundos que deve ser adicionado ao último horário de autenticação do
     * usuário no sistema para verificar se este ainda está habilitado para
     * utilização.
     *
     * @return int Valor Configurado
     */
    public function getLimit() {
        // Apresentação
        return $this->_limit;
    }

    /**
     * Ofuscar Valor
     *
     * @param  string $value Valor para Processamento
     * @return string Conteúdo Processado
     */
    public static function salt($value) {
        return sha1('3520e0dc3650aac' . md5($value) . '630c6ccebdd6867e8');
    }

    /**
     * Filtro Básico de Informação
     */
    public static function filter($identifier, $container, $default, $typed = 'string') {
        $value = $default;
        if (array_key_exists($identifier, $container)) {
            $value = $container[$identifier];
        }
        return eval("return ($typed) \$value;");
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
        $data['email']  = self::filter('email', $data, null, 'string');
        $data['active'] = (int) self::filter('active', $data, null, 'bool');
        $data['admin']  = (int) self::filter('admin', $data, null, 'bool');
        // Gerar Hash para Usuário
        $data['hash']   = self::salt($data['email'] . time());
        // Cadastrar no Banco de Dados
        if (empty($data['id'])) {
            $data['id'] = $adapter->insert($data, 'wsl_users');
        } else {
            $adapter->update($data, 'wsl_users', array('id' => $data['id']));
        }
        // Apresentar Identificador do Usuário
        return $data['id'];
    }

    /**
     * Gerar Novo Hash para Usuário
     *
     * Recebe como parâmetro o identificador do usuário que necessita de
     * alteração no conteúdo de Hash e modifica o valor no banco de dados,
     * apresentando o novo valor como retorno de função.
     *
     * @param  int $id Identificador do Usuário para Atualização
     * @return string Conteúdo do Novo Hash Salvo no Banco de Dados
     */
    public function hash($id) {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Filtro de Dados
        $id = (int) $id;
        // Gerar Hash para Usuário
        $hash = self::salt(time());
        // Dados para Atualização
        $data = array(
            'hash' => $hash
        );
        // Cadastrar no Banco de Dados
        $adapter->update('wsl_users', $data, array('id' => $id));
        // Apresentar Novo Hash
        return $hash;
    }

    /**
     * Remover Usuário
     *
     * Apaga informações do usuário solicitado informando o seu identificador.
     * Remove do banco de dados todas as entradas relacionadas ao usuário que
     * possuem relacionamento.
     *
     * @param  int $identifier Identificador do Usuário para Remoção
     * @return bool Confirmação de Usuário Removido com Sucesso
     */
    public function remove($id) {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Filtro de Dados
        $id = (int) $id;
        // Verificar Usuário ROOT
        if ($id === 1) {
            throw new Exception('Invalid User', 404);
        }
        // Remover do Banco de Dados
        $affected = $adapter->delete('wsl_users', array('id' => $id));
        // Apresentar Resultados
        return $affected === 1;
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
     * @return int    Identificador do Usuário ou Falso Caso Contrário
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
SELECT
    `u`.`id` AS `reference`,
    `u`.`admin` AS `admin`,
    `s`.`id` AS `session`,
    UNIX_TIMESTAMP(`s`.`timestamp`) AS `timestamp`
FROM `wsl_sessions` AS `s`
    LEFT JOIN `wsl_users` AS `u` ON `u`.`id` = `s`.`user_id`
WHERE `s`.`token` = '$token'
ORDER BY `timestamp` DESC
LIMIT 1
SQL;
        // Consulta
        $search = $adapter->query($sql);
        // Resultado Inicial
        $result = false;
        // Elemento Encontrado?
        if (!empty($search)) {
            // Construção de Elemento
            $element = reset($search);
            // Verificar Usuário Administrativo?
            if ((!$admin) || ($admin && $element['admin'])) {
                // Horário Atual
                $current = time();
                // Verificação de Token
                $result = ($current <= ($element['timestamp'] + $this->getLimit()));
                // Sucesso?
                if ($result) {
                    // Dados para Atualização
                    $data = array('timestamp' => $current);
                    // Atualizar Sessão Atual
                    $adapter->update('wsl_sessions', $data, array(
                        'id' => $element['session'],
                    ));
                    // Aplicar Resultado
                    $result = $element['reference'];
                }
            }
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
    `u`.`id`, (`u`.`hash` = '$hash') AS `compare`
FROM `wsl_users` AS `u` WHERE `u`.`email` = '$email'
SQL;
        // Consulta de Informações
        $result = $adapter->query($sql);
        // Verificação
        if (!empty($result)) {
            // Elemento Encontrado
            $element = reset($result);
            // Comparação de Senhas
            if ($element['compare']) {
                // Existe Usuário Autenticado?
                do {
                    // Credenciais Válidas
                    $seed  = date('Y-m-d H:i:s.u');
                    // Criação de Token
                    $token = self::salt($seed);
                    // Possível Autenticar?
                } while ($this->check($token, true /* admin */));
                // Identificador
                $id = $element['id'];
                // Sessão Utilizada
                $adapter->insert('wsl_sessions', array(
                    'user_id' => $id,
                    'token'   => $token,
                ));
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

