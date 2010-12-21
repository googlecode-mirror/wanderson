<?php

/**
 * Hazel Bibliography Default Formatter
 * 
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Formatter
 * @author     Wanderson Henrique Camargo Rosa
 */
class Hazel_Bibliography_Formatter_Default
    extends Hazel_Bibliography_FormatterAbstract
{
    /**
     * Formatação do Autor do Documento como Método Auxiliar
     * 
     * @param string $content Conteúdo Autor do Documento
     * @return string Autor Formatado
     */
    protected function _formatAuthor($content)
    {
        $authors = explode('and', $content);
        foreach ($authors as $key => $author) {
            $exploded  = explode(' ', $author);
            $lastname  = strtoupper(array_pop($exploded));
            foreach ($exploded as $index => $part) {
                if (preg_match('/^([A-Z]).*$/', $part, $match) == 1) {
                    $exploded[$index] = "{$match[1]}.";
                }
            }
            $firstname = implode(' ', $exploded);
            $authors[$key] = "$lastname, $firstname";
        }
        $content = implode(';', $authors);
        return $content;
    }

    /**
     * Formatação de Livros
     * 
     * @param Hazel_Bibliography_DocumentAbstract $document
     * @return string Referência Bibliográfica
     */
    public function formatBook(Hazel_Bibliography_DocumentAbstract $document)
    {
        $author    = $this->_formatAuthor($element->getAuthor());
        $title     = $element->getTitle();
        $publisher = $element->getPublisher();
        $year      = $element->getYear();
        return "$author ($year). $title. $publisher.";
    }
}