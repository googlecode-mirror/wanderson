<?php
class WSL_Controller_Router {
    protected $_serverUrl = null;
    protected $_baseUrl = null;
    protected $_params = null;
    public function getServerUrl() {
        if ($this->_serverUrl === null) {
            $this->_serverUrl = (empty($_SERVER['HTTPS']) ? 'http' : 'https')
                . '://' .  $_SERVER['HTTP_HOST'];
        }
        return $this->_serverUrl;
    }
    public function getBaseUrl() {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        }
        return $this->_baseUrl;
    }
    public function getParams() {
        // Parâmetros Inicializados?
        if ($this->_params === null) {
            // Parâmetros Iniciais
            $params = array(
                'controller' => 'index',
                'action'     => 'index',
            );
            // Conteúdo para Parâmetros de Requisição
            $content = preg_replace(sprintf('#^%s(?:/index.php|/)?|\?.*$#', $this->getBaseUrl()), '', $_SERVER['REQUEST_URI']);
            preg_match_all('#(?<name>[^/]*)(?:/(?<value>[^/]*))?#', $content, $matches, PREG_SET_ORDER);
            // Capturar Controladora e Ação
            $route = array_shift($matches);
            if (!empty($route)) {
                $params['controller'] = (empty($route['name'])  ? 'index' : $route['name']);
                $params['action']     = (empty($route['value']) ? 'index' : $route['value']);
            }
            // Processar Parâmetros
            foreach ($matches as $match) {
                // Configurar Parâmetros
                $params[$match['name']] = (empty($match['value']) ? null : $match['value']);
            }
            // Configurar Local
            $this->_params = $params;
        }
        // Apresentação
        return $this->_params;
    }
    public function url(array $params, $reset = false) {
        $current = array();
        if (!$reset) {
            $current = $this->getParams();
        }
        // União de Elementos
        $elements = array_merge($current, $params);
        // Capturar Controladora e Ação
        $controller = $elements['controller']; unset($elements['controller']);
        $action     = $elements['action']    ; unset($elements['action']);
        // Capturar Outros Parâmetros
        $address = implode('/', $elements);
        // Apresentar Endereço
        return $this->getBaseUrl() . "/$controller/$action/$address";
    }
}

