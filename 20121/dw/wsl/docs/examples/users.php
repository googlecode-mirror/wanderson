<?php
/**
 * LaTeX Webservice Compiler
 * User Management
 */
// Configuração
$compiler = 'http://192.168.10.12/wsl/services/compiler';
$address  = 'http://192.168.10.12/wsl/services/users';

// Autenticador
$client = new SoapClient(null, array(
    'uri'      => 'tns:CompilerService',
    'location' => $compiler,
));
// Solicitação de Token
$token = $client->login('root@localhost', '7c4a8d09ca3762af61e59520943dc26494f8941b');
// Execução
$client = new SoapClient(null, array(
    'uri'      => 'tns:UsersService',
    'location' => $address,
));
// Resultado Inicial
$result = null;
// Variável de Linha de Comando
switch (@$argv[1]) {
    case 'fetch':
        $result = $client->fetch($token);
        break;
    case 'hash':
        $result = $client->hash($token, 1 /* root */);
}
// Exibir Resultado
var_dump($result);
