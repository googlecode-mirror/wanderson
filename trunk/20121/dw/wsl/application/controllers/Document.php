<?php

/**
 * Controladora de Documentos
 *
 * Possibilita a edição de documentos utilizando o Webservice disponível para
 * compilação de conteúdo. Utiliza um Webservice do tipo SOAP para compilar o
 * documento atual no formato LaTeX.
 *
 * @category Application
 * @package  Application_Controller
 */
class Controller_Document extends WSL_Controller_ActionAbstract {

    /**
     * Edição de Documento
     * @return null
     */
    public function editAction() {
        // Criação do Serviço
        $client = new SoapClient(null, array(
            'uri'      => 'tns:CompilerService',
            'location' => 'http://localhost/wanderson/wsl/services/compiler',
        ));
        // Compilação
        $result = $client->compile('tex', 'dvi', array(array(
            'hash'     => sha1_file(APPLICATION_PATH . '/../temp/document.tex'),
            'filename' => 'document.tex',
            'content'  => base64_encode(file_get_contents(APPLICATION_PATH . '/../temp/document.tex')),
        )));
        var_dump($result);
    }

}