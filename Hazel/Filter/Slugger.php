<?php

/**
 * Slugger
 * 
 * @category Hazel
 * @package  Hazel_Filter
 * @author   Wanderson Henrique Camargo Rosa
 */
class Hazel_Filter_Slugger {

    /**
     * Mapper
     * @var array
     */
    protected $_mapper = null;

    /**
     * Slugger
     * @param string $content Conteúdo para Filtragem
     * @return string Conteúdo Filtrado
     */
    public function filter($content) {
        $mapper = $this->_getMapper();
        $input  = array_keys($mapper);
        $output = array_values($mapper);
        // Conversão
        $content = str_replace($input, $output, $content);
        $content = strtolower($content);
        $content = preg_replace('/[^a-z0-9-]/', '-', $content);
        $content = preg_replace('/-+/', '-', $content);
        return $content;
    }

    /**
     * Slugger Mapper
     * @return array Mapeamento para Transformação
     */
    protected function _getMapper() {
        if ($this->_mapper === null) {
            $this->_mapper = $this->_buildMapper();
        }
        return $this->_mapper;
    }

    /**
     * Construtor de Mapeamento
     * @return array Mapa Construído conforme Template
     */
    protected function _buildMapper() {
        $template = $this->_getTemplate();
        $mapper   = array();
        foreach ($template as $output => $input) {
            $count = strlen($input);
            for ($i = 0; $i < $count; $i++) {
                $mapper[$input[$i]] = $output;
            }
        }
        return $mapper;
    }

    /**
     * Informação do Template de Filtragem
     * @return array Conteúdo do Template
     */
    protected function _getTemplate() {
        return array(
            'a' => 'AÀÁÂÃÄÅàáâãäå',
            'e' => 'EÈÉÊËèéêë',
            'i' => 'IÌÍÎÏìíîï',
            'o' => 'OÒÓÔÕÖØòóôõöø',
            'u' => 'UÙÚÛÜùúûü',
            'c' => 'CÇç',
        );
    }
}
