<?php

/**
 * Interface para Nós
 * @author Wanderson Henrique Camargo Rosa
 */
interface NodeInterface
{
    /**
     * Renderizador de Nó
     * @param int $level Nível de Indentação
     * @return string Conteúdo Renderizado
     */
    public function render($level = 0);

    /**
     * Configuração do Nó Pai
     * @param NodeAbstract|null $parentNode Nó Pai
     * @return NodeInterface Próprio Objeto para Encadeamento
     */
    public function setParentNode($parentNode);

    /**
     * Informação do Nó Pai
     * @return NodeAbstract Nó Pai
     */
    public function getParentNode();
}