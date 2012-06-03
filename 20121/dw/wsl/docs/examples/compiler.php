<?php
/**
 * LaTeX Webservice Compiler
 * Command Line Interface
 * @author Wanderson Henrique Camargo Rosa
 */
// Configurações
$address = 'http://192.168.10.12/wsl/services/compiler';

// Execução
$client = new SoapClient(null, array(
    'uri'      => 'tns:CompilerService',
    'location' => $address,
));
// Solicitação de Token
$token = $client->login('root@localhost', '7c4a8d09ca3762af61e59520943dc26494f8941b');
// Compilar Documento
$result = $client->compile($token, 'Tex', 'TarGz', array(array(
    'hash'     => sha1_file(dirname(__FILE__) . '/document.tex'),
    'filename' => 'document.tex',
    'content'  => base64_encode(file_get_contents(dirname(__FILE__) . '/document.tex')),
)));
// Salvar Arquivo
file_put_contents(dirname(__FILE__) . '/' . $result['filename'], base64_decode($result['content']));
// Apresentar Resultado
echo 'filename: ' . $result['filename'] . ' (saved) ' . PHP_EOL;
echo 'hash:     ' . $result['hash'] . PHP_EOL;