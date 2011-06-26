<?php

/**
 * Tradutor
 * Wiki Creole > LaTeX SBC Article
 * 
 * @category Local
 * @package  Local_Parser
 * @author   Wanderson Henrique Camargo Rosa
 */
class Local_Parser_WikiToLatex
{
    /**
     * Artigo para Manipulação
     * @var Application_Model_DbTable_Row_Artigo
     */
    protected $_article;

    /**
     * Construtor Padrão
     */
    public function __construct()
    {
        
    }

    /**
     * Configura Artigo para Tradução
     * @param Application_Model_DbTable_Row_Artigo $article Elemento
     * @return Local_Parser_WikiToLatex Próprio Objeto para Encadeamento
     */
    public function setArticle(Application_Model_DbTable_Row_Artigo $article)
    {
        $this->_article = $article;
        return $this;
    }

    /**
     * Informa o Artigo para Tradução
     * @return Application_Model_DbTable_Row_Artigo Elemento Solicitado
     * @throws Local_Parser_Exception Elemento não Configurado
     */
    public function getArticle()
    {
        if ($this->_article === null) {
            throw new Local_Parser_Exception('Invalid Element');
        }
        return $this->_article;
    }

    /**
     * Solicitação do Tradutor
     * @return SubWikiParser Tradutor Configurado para o Artigo
     */
    protected function _getParser()
    {
        // Artigo
        $article = $this->getArticle();
        // Requisição de Classes
        Zend_Loader::loadFile('antlr.php', null, true);
        Zend_Loader::loadClass('SubWikiLexer');
        Zend_Loader::loadClass('SubWikiParser');
        // Construção do Tradutor
        $ass = new ANTLRStringStream($article->conteudo);
        $lex = new SubWikiLexer($ass);
        $cts = new CommonTokenStream($lex);
        $par = new SubWikiParser($cts);
        // Configurações Iniciais de Imagens
        $usuario = $article->findParentRow('Usuario');
        $figuras = $usuario->findDependentRowset('Figura');
        foreach ($figuras as $figura) {
            $identifier = $figura->identificador;
            $filename   = $figura->arquivo;
            $caption    = $figura->legenda;
            $par->addImageInfo($identifier, $filename, $caption);
        }
        // Resultado
        return $par;
    }

    /**
     * Traduz o Conteúdo
     * @return string Conteúdo Resultante
     */
    public function parse()
    {
        $parser = $this->_getParser();
        return '';
    }
}
