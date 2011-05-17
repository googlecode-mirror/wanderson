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
     * Construtor
     * @param string $charset 
     */
    public function __construct($charset = 'utf-8')
    {
        /* Sobrescrita */
        parent::__construct($charset);
        /* Camada de Visualização */
        $view = new Zend_View();
        $this->setView($view);
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
     * Renderização do Conteúdo
     * @return Hazel_Mail_Html Próprio Objeto para Encadeamento
     */
    public function render()
    {
        /* Renderização do Conteúdo */
        $script = $this->getScript();
        $content = $this->getView()->render($script);
        /* Configuração do Conteúdo */
        $this->setBodyHtml($content);
        return $this;
    }

    /**
     * Sobrescrita de Método para Renderização da Visualização
     * @param boolean $htmlOnly Renderização do Corpo do Email
     * @param boolean $render   Renderização da Visualização Anexada
     * @return false|Zend_Mime_Part|string Resultado do Método na Superclasse
     */
    public function getBodyHtml($htmlOnly = false, $render = true)
    {
        /* BodyHtml Possivelmente Objeto */
        if ($render && $this->_bodyHtml === false) {
            $this->render();
        }
        return parent::getBodyHtml($htmlOnly);
    }

    /**
     * Acesso a Métodos da Visualização
     * @param string $name Nome do Método
     * @param array  $args Argumentos de Execução
     * @return mixed Resultado da Execução pela Camada de Visualização
     */
    public function __call($name, $args)
    {
        /* Captura da Visualização */
        $view = $this->getView();
        /* Execução do Método */
        $result = call_user_method_array($name, $view, $args);
        /* Envio do Resultado */
        return $result;
    }
}
