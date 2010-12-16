<?php

/**
 * Formulário de Artigos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Form
 * 
 * @property Zend_Form_Element_Hidden   $idarticle
 * @property Zend_Form_Element_Text     $title
 * @property Zend_Form_Element_Textarea $description
 * @property Zend_Form_Element_Textarea $abstract
 * @property Zend_Form_Element_Textarea $content
 * @property Zend_Form_Element_Textarea $keywords
 * @property Zend_Form_Element_Submit   $submit
 */
class Publisher_Form_Article extends Zend_Form
{
    public function init()
    {
        /*
         * Configurações Iniciais do Formulário
         */
        $this->loadDefaultDecorators();
        $this->setName('publisher_form_article')->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url());

        /*
         * Chave Primária
         */
        $idarticle = new Zend_Form_Element_Hidden('idarticle');
        $idarticle->removeDecorator('Label')->addFilter(new Zend_Filter_Int())
            ->addFilter(new Zend_Filter_Null());
        $this->addElement($idarticle);

        /*
         * Título
         */
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Título')->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addFilter(new Zend_Filter_StringTrim())
            ->addValidator(new Zend_Validate_StringLength(1,100));
        $this->addElement($title);

        /*
         * Descrição para Indexação de Buscas
         */
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Descrição')->setAllowEmpty(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addFilter(new Zend_Filter_StripNewlines())
            ->addFilter(new Zend_Filter_StringTrim())
            ->setDescription('Descrição do artigo para sites de busca');
        $this->addElement($description);

        /*
         * Resumo
         */
        $abstract = new Zend_Form_Element_Textarea('abstract');
        $abstract->setLabel('Resumo')->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addFilter(new Zend_Filter_StripNewlines())
            ->addFilter(new Zend_Filter_StringTrim())
            ->addValidator(new Zend_Validate_NotEmpty());
        $this->addElement($abstract);

        /*
         * Conteúdo
         */
        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Conteúdo')->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addFilter(new Zend_Filter_StringTrim())
            ->addValidator(new Zend_Validate_NotEmpty());
        $this->addElement($content);

        /*
         * Botão de Envio do Formulário
         */
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')->setIgnore(true);
        $this->addElement($submit);
    }
}