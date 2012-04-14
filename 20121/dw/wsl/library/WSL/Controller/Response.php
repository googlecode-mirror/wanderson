<?php
class WSL_Controller_Response {
    protected $_content;
    public function __construct() {
        $this->clear();
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
}

