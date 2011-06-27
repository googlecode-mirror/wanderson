<?php

/**
 * Referência Table Row
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Row_Referencia extends Local_Db_Table_Row
{
    protected function _insert()
    {
        // Identificador do Usuário Atual
        $this->idusuario = 1; // @todo Fornecer o Identificador do Usuário
    }

    /**
     * Renderização da Referência Bibliográfica
     * @return string Conteúdo Resultado
     */
    public function render()
    {
        // Tipo do Artigo
        $translator = array(
            'artigo' => 'article'
        );
        $tipo = $translator[$this->tipo];
        // Conteúdo do Artigo
        $json = new Zend_Json();
        $info = $json->decode($this->conteudo);
        // Resultado
        return $this->_render($tipo, $info);
    }

    /**
     * Processa Informações do Artigo para Formato BibTeX
     * @param string $type Tipo do Artigo
     * @param array  $info Informações do Artigo
     * @return string Conteúdo Resultado
     */
    protected function _render($type, $info)
    {
        // Identificador
        $identifier = $this->identificador;
        // Inicialização
        $header = sprintf('@%s{%s,', $type, $identifier);
        $footer = '}';
        // Renderização das Linhas
        $lines = array();
        foreach ($info as $key => $value) {
            $lines[] = "\t$key = \"$value\"";
        }
        $lines = implode(",\n", $lines);
        // Resultado Final
        return "$header\n$lines\n$footer\n";
    }
}