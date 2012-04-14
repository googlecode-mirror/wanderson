<?php

class WSL_Model_Config implements Countable, IteratorAggregate, ArrayAccess {

    protected $_params = array();

    public function setParam($name, $value) {
        $name = (string) $name;
        if ($value === null) {
            unset($this->_params[$name]);
        } else {
            $this->_params[$name] = $value;
        }
        return $this;
    }

    public function hasParam($name) {
        $name = (string) $name;
        return array_key_exists($name, $this->_params);
    }

    public function getParam($name) {
        $name = (string) $name;
        $result = null;
        if ($this->hasParam($name)) {
            $result = $this->_params[$name];
        }
        return $result;
    }

    public function __set($name, $value) {
        return $this->setParam($name, $value);
    }
    public function __isset($name) {
        return $this->hasParam($name);
    }
    public function __get($name) {
        return $this->getParam($name);
    }
    public function __unset($name) {
        return $this->setParam($name, null);
    }

    public function count() {
        return count($this->_params);
    }

    public function getIterator() {
        return new ArrayIterator($this->_params);
    }

    public function offsetSet($name, $value) {
        return $this->setParam($name, $value);
    }
    public function offsetExists($name) {
        return $this->hasParam($name);
    }
    public function offsetGet($name) {
        return $this->getParam($name);
    }
    public function offsetUnset($name) {
        return $this->setParam($name, null);
    }

}

