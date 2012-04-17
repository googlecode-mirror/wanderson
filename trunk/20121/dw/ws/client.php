<?php
$client = new SoapClient('http://localhost/wanderson/ws/server.php?WSDL');
var_dump($client->SayHello(1));
