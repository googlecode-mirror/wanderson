<?php
/**
 * Hazel Zend Framework Extended Library
 * 
 * LICENSE
 * 
 * Copyright (c) 2010, Wanderson Henrique Camargo Rosa.
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permited provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 * 
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 * 
 *     * Neither the name of the author nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * Zend Framework
 * Copyright (c) Zend Technologies Ltd. All rights reserved.
 * 
 * @category Hazel
 * @package  Hazel_Bibliography
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel_Bibliography
 */

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