<?php
/**
 * Construtor de WSDL
 *
 * @category WSL
 * @package  WSL_Soap
 */
class WSL_Soap_AutoDiscover {

    /**
     * Endereço do Serviço
     * @var string
     */
    protected $_uri = null;

    /**
     * Nome do Serviço
     * @var string
     */
    protected $_name = null;

    /**
     * Configuração de Portas
     * @var array
     */
    protected $_ports = array();

    /**
     * Nome da Classe Utilizada
     * @var string
     */
    protected $_class = null;

    /**
     * Tradução de Parâmetro no Conteúdo
     *
     * Recebe como conteúdo um formato de documentação com parâmetros e
     * apresenta um conjunto de informações capturadas da classe.
     *
     * @param  string   $param   Parâmetro para Captura
     * @param  string   $content Conteúdo para Processamento
     * @return string[] Valores Capturados para o Conteúdo Apresentado
     */
    protected static function _parse($param, $content) {
        // Resultado Inicial
        $result = array();
        // Capturar Informações
        $counter = preg_match_all(sprintf('/@%s\s+([[:alpha:]]+)(?:[ \t]+(?:(\$[[:alpha:]]+)[ \t]+)?(.*))?/', $param), $content, $matches);
        // Processamento
        for ($i = 0; $i < $counter; $i++) {
            // Construção
            $result[] = array(
                'identifier' => $matches[1][$i],
                'content'    => $matches[2][$i],
            );
        }
        // Apresentar
        return $result;
    }

    /**
     * Construtor
     *
     * @param string $element Nome da Classe para Utilização
     */
    public function __construct($element) {
        // Reflexão
        $reflected = new ReflectionClass($element);
        // Procurar Nome de Serviço
        $contents = current(self::_parse('service', $reflected->getDocComment()));
        // Configurar Nome do Serviço
        $this->setName($contents['identifier']);
        // Capturar Métodos Públicos com Action
        foreach ($reflected->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Captura de Nome
            $name = $method->getName();
            // Parâmetros de Requisição
            $request = self::_parse('request', $method->getDocComment());
            // Parâmetros de Resposta
            $response = self::_parse('response', $method->getDocComment());
            // Configuração
            $this->setPort($name, $request, $response);
        }
        // Configurar Nome de Classe
        $this->_setClass($element);
    }

    /**
     * Configuração de Endereço do Serviço
     *
     * @param  string $uri Valor para Configuração
     * @return WSL_Soap_AutoDiscover Próprio Objeto para Encadeamento
     */
    public function setUri($uri) {
        // Configuração
        $this->_uri = $uri;
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Endereço do Serviço
     *
     * @return string Conteúdo Configurado
     */
    public function getUri() {
        // Valor Inicializado?
        if ($this->_uri === null) {
            // Capturar Uri
            $uri = (empty($_SERVER['HTTPS']) ? 'http' : 'https')
                   . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
            // Configuração
            $this->setUri($uri);
        }
        // Encadeamento
        return $this->_uri;
    }

    /**
     * Configurar Nome de Classe
     *
     * @param  string $class Valor para Configuração
     * @return WSL_Soap_AutoDiscover Próprio Objeto para Encadeamento
     */
    public function _setClass($class) {
        // Configuração
        $this->_class = $class;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Nome da Classe
     *
     * @return string Valor Configurado
     */
    public function getClass() {
        // Apresentação
        return $this->_class;
    }

    /**
     * Configura o Nome do Serviço Utilizado
     *
     * @param  string $name Valor para Configuração
     * @return WSL_Soap_AutoDiscover Próprio Objeto para Encadeamento
     */
    public function setName($name) {
        // Conversão
        $name = (string) $name;
        // Configuração
        $this->_name = $name;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Nome do Serviço Utilizado
     *
     * @return string Valor Configurado
     */
    public function getName() {
        // Apresentação
        return $this->_name;
    }

    /**
     * Configuração de Porta
     *
     * @param  string $method Método Utilizado
     * @param  array  $request Informações sobre Requisição
     * @param  array  $response Informações sobre Resposta
     * @return WSL_Soap_AutoDiscover Próprio Objeto para Encadeamento
     */
    public function setPort($method, $request, $response) {
        // Configuração
        $this->_ports[$method] = array(
            'request'  => $request,
            'response' => $response,
        );
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Portas Configuradas
     *
     * @return array Conjunto de Informações
     */
    public function getPorts() {
        // Apresentação
        return $this->_ports;
    }

    /**
     * Manipular Requisição
     *
     * Verifica se na requisição está sendo solicitada a especificação WSDL do
     * conteúdo do serviço que deve ser apresentado, enviando as configurações
     * solicitadas para o cliente. Caso contrário, executa o servidor com a
     * classe configurada no momento da inicialização do objeto.
     *
     * @return WSL_Soap_AutoDiscover Próprio Objeto para Encadeamento
     */
    public function handle() {
        // Existe parâmetro WSDL?
        if (array_key_exists('WSDL', $_GET)) {
            // Exibir Configurações
            if (!headers_sent()) {
                header('Content-Type: text/xml');
            }
            // Conteúdo na Saída Padrão
            file_put_contents('php://output', $this);
        } else {
            // Capturar Conteúdo de Entrada
            $content = file_get_contents('php://input');
            // Construção do Servidor
            $server = new SoapServer($this->getUri() . '?WSDL');
            $server->setClass($this->getClass());

            try {
                // Execução
                $server->handle($content);
            } catch (Exception $e) {
                // Apresentar Erro
                $server->fault($e->getCode(), $e->getMessage());
            }

        }
        // Encadeamento
        return $this;
    }

    /**
     * Renderização do WSDL
     *
     * @return string Conteúdo WSDL do Serviço Apresentado
     */
    public function __toString() {
        // Inicialização
        $uri     = $this->getUri();
        $ports   = $this->getPorts();
        $service = $this->getName();
        // Iniciar Captura
        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<definitions name="<?php echo $service ?>Service"
    targetNamespace="<?php echo $uri ?>?WSDL"
    xmlns="http://schemas.xmlsoap.org/wsdl/"
    xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
    xmlns:tns="<?php echo $uri ?>?WSDL"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
>
<?php foreach ($ports as $name => $methods) : $name = ucfirst($name) ?>
<?php foreach ($methods as $method => $parts) : ?>
    <message name="<?php echo $name ?><?php echo ucfirst($method) ?>">
<?php foreach ($parts as $part) : ?>
        <part name="<?php echo substr($part['content'], 1) ?>" type="xsd:<?php echo $part['identifier'] ?>"/>
<?php endforeach ?>
    </message>
<?php endforeach ?>
    <portType name="<?php echo $name ?>PortType">
        <operation name="<?php echo $name ?>">
            <input message="tns:<?php echo $name ?>Request"/>
            <output message="tns:<?php echo $name ?>Response"/>
        </operation>
    </portType>
    <binding name="<?php echo $name ?>Binding" type="tns:<?php echo $name ?>PortType">
        <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
        <operation name="<?php echo $name ?>">
            <soap:operation soapAction="<?php echo $name ?>"/>
        </operation>
    </binding>
<?php endforeach ?>
    <service name="<?php echo $service ?>">
<?php foreach ($ports as $name => $methods) : $name = ucfirst($name) ?>
        <port binding="tns:<?php echo $name ?>Binding" name="<?php echo $name ?>Port">
            <soap:address location="<?php echo $uri ?>"/>
        </port>
<?php endforeach ?>
    </service>
</definitions>
<?php
        $content = ob_get_clean();
        // Apresentação
        return $content;
    }

}

