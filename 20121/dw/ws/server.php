<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_error', true);
class HelloServer {
	public function SayHello() {
		return var_export(func_get_args(), true);
	}
}
$server = new SoapServer('HelloService.wsdl');
$server->setClass('HelloServer');
$server->handle();

