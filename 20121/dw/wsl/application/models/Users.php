<?php

class Model_Users {
    public function fetch() {
        // Adaptador de Conexão
        $adapter = WSL_Controller_Front::getInstance()
            ->getConfig()->getParam('Db.adapter');
        // Exibir Adaptador
        return $adapter->query('SELECT * FROM `wsl_users`');
    }
}

