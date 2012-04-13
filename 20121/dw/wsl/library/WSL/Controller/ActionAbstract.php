<?php
abstract class WSL_Controller_ActionAbstract {
    protected $_request;
    protected $_response;
    public function __construct($request, $response) {
        $this->_setRequest($request)->_setResponse($response);
    }
    protected function _setRequest($request) {
        $this->_request = $request;
        return $this;
    }
    public function getRequest() {
        return $this->_request;
    }
    protected function _setResponse($response) {
        $this->_response = $response;
        return $this;
    }
    public function getResponse() {
        return $this->_response;
    }
}

