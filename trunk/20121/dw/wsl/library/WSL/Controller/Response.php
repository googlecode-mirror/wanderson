<?php
class WSL_Controller_Response {
    protected $_content;
    protected $_headers;
    public function __construct() {
        $this->clear();
        $this->_headers = new WSL_Model_Config();
    }
    public function __toString() {
        return $this->getContent();
    }
    public function clear() {
        $this->setContent('');
    }
    public function setContent($content) {
        $this->_content = (string) $content;
        return $this;
    }
    public function getContent() {
        return $this->_content;
    }
    public function setHeader($name, $value) {
        $this->_headers[$name] = $value;
        return $this;
    }
    public function getHeader($name) {
        return $this->_headers[$name];
    }
    public function send() {
        if (!headers_sent()) {
            foreach ($this->_headers as $name => $value) {
                header("$name: $value");
            }
        }
        echo $this->getContent();
        return $this;
    }
}

