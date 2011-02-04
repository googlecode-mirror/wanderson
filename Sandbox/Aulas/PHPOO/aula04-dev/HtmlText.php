<?php

class HtmlText implements NodeInterface
{
    private $_parentNode;

    private $_text;

    public function __construct($text)
    {
        $this->setText($text);
    }

    public function setParentNode($parentNode)
    {
        if ($parentNode !== null && !($parentNode instanceof NodeAbstract)) {
            throw new NodeException('Invalid Parent Node');
        }
        return $this;
    }

    public function getParentNode()
    {
        return $this->_parentNode;
    }

    public function setText($text)
    {
        $this->_text = (string) $text;
        return $this;
    }

    public function getText()
    {
        return $this->_text;
    }

    public function render($level = 0)
    {
        return $this->getText();
    }
}