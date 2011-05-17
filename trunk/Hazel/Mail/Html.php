<?php

/**
 * Envio de Emails com Template Html
 *
 * Trabalha com arquivos de visualização para renderizar o conteúdo do email,
 * fornecendo um auxílio para montagem de mensagens amigáveis
 *
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel_Mail
 */
class Hazel_Mail_Html extends Zend_Mail
{
    /**
     * Camada de Visualização
     * @var Zend_View
     */
    protected $_view;

    /**
     * Caminho para Script de Visualização
     * @var string
     */
    protected $_script;

    /**
     * Camada de Transporte
     * @var Zend_Mail_Transport_Abstract
     */
    protected $_transport;

    /**
     * Construtor da Classe
     * @param $options Opções para Configuração
     */
    public function __construct(array $options = array())
    {
        /* Construção da Superclasse */
        $charset = isset($options['charset']) ? $options : 'utf-8';
        parent::__construct($charset);
        unset($options['charset']);

        /* Visualização */
        $view = new Zend_View();
        $this->setView($view);
        /* Transporte */
        $transport = new Zend_Mail_Transport_Smtp();
        $this->setTransport($transport);
    }

    /**
     * Configuração da Camada de Visualização
     * @param Zend_View $view Elemento para Configuração
     * @return Hazel_Mail_Html Próprio Objeto para Encadeamento
     */
    public function setView(Zend_View $view)
    {
        $this->_view = $view;
        return $this;
    }

    /**
     * Informação da Camada de Visualização
     * @return Zend_View Elemento Solicitado
     */
    public function getView()
    {
        return $this->_view;
    }

    /**
     * Configura o Caminho do Script de Visualização
     * @param string Elemento para Configuração
     * @return Hazel_Mail_Html Próprio Objeto para Encadeamento
     */
    public function setScript($script)
    {
        $this->_script = (string) $script;
        return $this;
    }

    /**
     * Informa o Caminho do Script de Visualização
     * @return string Elemento Solicitado
     */
    public function getScript()
    {
        return $this->_script;
    }

    /**
     * Configura a Camada de Transporte
     * @param Zend_Mail_Transport_Abstract $transport Elemento para Configuração
     * @return Hazel_Mail_Html Próprio Objeto para Encadeamento
     */
    public function setTransport(Zend_Mail_Transport_Abstract $transport)
    {
        $this->_transport = $transport;
        return $this;
    }

    /**
     * Informa a Camada de Transporte
     * @return Zend_Mail_Transport_Abstract Elemento Solicitado
     */
    public function getTransport()
    {
        return $this->_transport;
    }

    public function send()
    {
        /* Renderização do Conteúdo */
        $script = $this->getScript();
        $body   = $this->getView()->render($script);
        $this->setBodyHtml($body);
        /* Camada de Transporte */
        $transport = $this->getTransport();
        /* Envio */
        return parent::send($transport);
    }
}
