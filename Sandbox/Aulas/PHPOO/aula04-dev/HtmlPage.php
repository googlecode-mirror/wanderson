<?php

class HtmlPage extends HtmlNode
{
    public function __construct()
    {
        parent::__construct('html');

        $head = new HtmlNode('head');
        $body = new HtmlNode('body');

        $nome = new HtmlText('Wanderson Henrique Camargo ');
        $body->addContentNode($nome);

        $bold = new HtmlNode('b');
        $sobrenome = new HtmlText('Rosa');
        $bold->addContentNode($sobrenome);
        $body->addContentNode($bold);

        $this->addContentNode($head)->addContentNode($body);
    }
}