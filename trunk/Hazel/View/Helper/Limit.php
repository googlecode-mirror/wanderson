<?php

/**
 * Limitador de Caracteres
 *
 * Auxiliar de visualização que busca limitar a quantidade de caracteres que
 * devem ser exibidos durante uma renderização. Ao final, sempre é concatenado
 * um sufixo solicitado, nunca ultrapassando o limite máximo atribuído.
 *
 * @category   Hazel
 * @package    Hazel_View
 * @subpackage Helper
 */
class Hazel_View_Helper_Limit extends Zend_View_Helper_Abstract {

    /**
     * Método Principal Limitador de Conteúdo
     *
     * Busca limitar a quantidade de caracteres que devem ser exibidos durante
     * uma renderização, possibilitando assim sempre exibir a quantidade limite
     * solicitada, preenchendo com um sufixo solicitado, ainda não ultrapassando
     * o valor máximo.
     *
     * @param  string $content Conteúdo para Limitação
     * @param  int    $limit   Quantidade Máxima Limite para Exibição
     * @param  string $suffix  Sufixo para Preenchimento
     * @return string Conteúdo Limitado conforme Solicitado
     */
    public function limit($content, $limit = 255, $suffix = '...') {
        // Conversão
        $content = (string) $this->view->escape($content);
        $limit   = (int) $limit;
        $suffix  = (string) $suffix;
        // Verificação de Limite Válido
        if (($suffix_len = strlen($suffix)) > $limit) {
            // Limite Máximo Menor que Tamanho do Sufixo
            throw new Zend_View_Exception("Invalid Suffix Length: $suffix_len:$limit");
        }
        // Conteúdo Menor que Limite
        if (($content_len = strlen($content)) <= $limit) {
            return $content;
        }
        // Conteúdo com Tamanho do Sufixo
        if ($content_len - $suffix_len <= 0) {
            return $suffix;
        }
        // Conteúdo Maior que Limite
        return substr($content, 0, $limit - $suffix_len) . $suffix;
    }

}

