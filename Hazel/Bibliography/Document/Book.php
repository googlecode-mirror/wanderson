<?php

/**
 * Hazel Bibliography Document Book
 * 
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Document
 * @author     Wanderson Henrique Camargo Rosa
 */
class Hazel_Bibliography_Document_Book
    extends Hazel_Bibliography_DocumentAbstract
{
    /**
     * Autor
     * 
     * @var string
     */
    protected $_author;

    /**
     * Título
     * 
     * @var string
     */
    protected $_title;

    /**
     * Editora
     * 
     * @var string
     */
    protected $_publisher;

    /**
     * Ano de Publicação
     * 
     * @var string
     */
    protected $_year;

    /**
     * Configuração de Autor
     * 
     * @param string $author
     * @return Hazel_Bibliography_Document_Book Próprio Objeto
     */
    public function setAuthor($author)
    {
        $this->_author = (string) $author;
        return $this;
    }

    /**
     * Configuração do Título
     * 
     * @param string $title
     * @return Hazel_Bibliography_Document_Book Próprio Objeto
     */
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    /**
     * Configuração da Editora
     * 
     * @param string $publisher
     * @return Hazel_Bibliography_Document_Book Próprio Objeto
     */
    public function setPublisher($publisher)
    {
        $this->_publisher = (string) $publisher;
        return $this;
    }

    /**
     * Configuração do Ano de Publicação
     * 
     * @param string $year
     * @return Hazel_Bibliography_Document_Book Próprio Objeto
     */
    public function setYear($year)
    {
        $this->_year = (string) $year;
        return $this;
    }

    /**
     * Informa o Autor
     * @return string
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * Informa o Título
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Informa a Editora
     * @return string
     */
    public function getPublisher()
    {
        return $this->_publisher;
    }

    /**
     * Informa o Ano de Publicação
     * @return string
     */
    public function getYear()
    {
        return $this->_year;
    }
}