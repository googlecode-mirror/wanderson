<?php
/**
 * Construtor de WSDL
 *
 * @category WSL
 * @package  WSL_Soap
 */
class WSL_Soap_AutoDiscover {

    /**
     * Nome do Serviço
     * @var string
     */
    protected $_name = null;

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
            // Análise do Nome do Método
            if (preg_match('/^([[:alpha:]])+Action$/', $method->getName(), $match) === 1) {
                // Parâmetros de Requisição
                $request = self::_parse('request', $method->getDocComment());
                // Parâmetros de Resposta
                $response = self::_parse('response', $method->getDocComment());
            }
        }
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

}

