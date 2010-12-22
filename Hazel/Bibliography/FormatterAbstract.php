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
 * Hazel Bibliography Formatter
 * 
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Formatter
 * @author     Wanderson Henrique Camargo Rosa
 */
abstract class Hazel_Bibliography_FormatterAbstract
{
    /**
     * Formatação da Referência Bibliográfica
     * 
     * @param Hazel_Bibliography_DocumentAbstract $document
     * @return string Referência Formatada
     */
    public function format(Hazel_Bibliography_DocumentAbstract $document)
    {
        $type = array_pop(explode('_', get_class($document)));
        $method = "format{$type}";
        $result = (string) $this->$method($document);
        return $result;
    }

    /**
     * Método Mágico para Tratamento de Chamadas Inválidas
     * 
     * @param string $name Nome do Método
     * @param array $args Argumentos da Chamada
     * @return Hazel_Bibliography_FormatterAbstract Próprio Objetos
     */
    public function __call($name, $args)
    {
        if (preg_match('/^format([a-zA-Z]+)$/', $name, $match)) {
            throw new Hazel_Bibliography_Exception("Invalid Formatter: '{$match[1]}'");
        } else {
            throw new Hazel_Bibliography_Exception("Invalid Method: '$name'");
        }
        return $this;
    }
}