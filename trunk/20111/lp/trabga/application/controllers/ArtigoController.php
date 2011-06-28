<?php

/**
 * Artigo Controller
 * 
 * @category Application
 * @package  Application_Controller
 */
class ArtigoController extends Local_Controller_ActionAbstract
{
    /**
     * Tabela Padrão de Banco de Dados
     * @var string
     */
    protected $_dbTableClass = 'Application_Model_DbTable_Artigo';

    /**
     * Formulário Padrão da Controladora
     * @var string
     */
    protected $_formClass = 'Application_Form_Artigo';

    /**
     * Tradutor de Artigos
     * @var Local_Parser_WikiToLatex
     */
    protected $_parser;

    /**
     * Imagens Utilizadas na Exportação
     * @var Zend_Db_Table_Rowset_Abstract
     */
    protected $_images = array();

    /**
     * Citações Utilizadas na Exportação
     * @var Zend_Db_Table_Rowset_Abstract
     */
    protected $_citations = array();

    public function init()
    {
        // Requisição Ajax
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
            Zend_Dojo_View_Helper_Dojo::setUseDeclarative();
            // @todo Modificar Identificadores de Componentes
        }
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        // Banco de Dados
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idartigo');
        $result = $table->fetchAll($select);

        // Mensagens
        $messages = $this->_helper->flashMessenger->getMessages();

        // Camada de Visualização
        $this->view->result = $result;
        $this->view->messages = $messages;
    }

    /**
     * Store Action
     */
    public function storeAction()
    {
        // Banco de Dados
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idartigo');
        $result = $table->fetchAll($select);

        // Dojo Envelopes
        $data = new Zend_Dojo_Data();
        $data->setIdentifier('idartigo')->setMetadata('label', 'titulo')
             ->addItems($result);
        $this->_helper->json($data);
    }

    /**
     * Create Action
     */
    public function createAction()
    {
        // Formulário
        $form = new Application_Form_ArtigoTitulo();

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                $table = $this->_getDbTable();
                $element = $table->createRow();

                $element->titulo = $data['titulo'];
                $element->save();

                $this->_helper->flashMessenger('insert');
                $this->_helper->redirector('edit', null, null, array(
                    'idartigo' => $element->idartigo
                ));
            }
        }

        // Camada de Visualização
        $this->view->form = $form;
    }

    /**
     * Edit Action
     */
    public function editAction()
    {
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Mensagens Disponíveis
        // FlashMessenger sem Nova Requisição
        $messages = array();

        // Banco de Dados$dest
        $table   = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Formulário
        $form = $this->_getForm();

        // Requisição Ajax?
        if ($this->getRequest()->isXmlHttpRequest()) {
            $form->setElementsBelongTo('artigo' . $element->idartigo);
        }

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Requisição Ajax?
                if ($this->getRequest()->isXmlHttpRequest()) {
                    $belongs = $form->getElementsBelongTo();
                    $data    = $data[$belongs];
                }

                $element->titulo = $data['cabecalho']['titulo'];
                $element->conteudo = $data['conteudo'];
                $element->save();

                $messages[] = 'update';

                // Requisição Ajax?
                if ($this->getRequest()->isXmlHttpRequest()) {
                    $this->_helper->json($messages);
                }

            }
        } else {
            // População
            $form->cabecalho->titulo->setValue($element->titulo);
            $form->conteudo->setValue($element->conteudo);
        }

        // Habilitando Migalha
        $this->view->navigation()
             ->findOneBy('active', true)->setVisible(true);

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->messages = $messages;
    }

    /**
     * Remove Action
     */
    public function removeAction()
    {
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação de Elemento
        $table = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Remoção do Elemento do Banco
        $element->delete();

        // Mensagens
        $this->_helper->flashMessenger('delete');
        $this->_helper->redirector('index');
    }

    /**
     * Export Action
     */
    public function exportAction()
    {
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação de Elemento
        $table = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Dependências
        Zend_Loader::loadFile('antlr.php', null, true);
        Zend_Loader::loadClass('SubWikiParser');
        Zend_Loader::loadClass('SubWikiLexer');

        // Inicialização
        $ass = new ANTLRStringStream($element->conteudo);
        $lex = new SubWikiLexer($ass);
        $cts = new CommonTokenStream($lex);

        // Tradutor
        $parser = $this->_getParser();
        $parser->setTokenStream($cts);

        // Usuário Atual
        $usuario = $element->findParentRow('Usuario');
        $autor   = $usuario->findParentRow('Autor');
        $instituicao = $autor->findParentRow('Instituicao');

        // Preenchimento de Imagens Disponíveis
        $figuras = $usuario->findDependentRowset('Figura');
        foreach ($figuras as $figura) {
            $identifier = $figura->identificador;
            $filename   = $figura->arquivo;
            $caption    = $figura->legenda;
            $parser->addImageInfo($identifier, $filename, $caption);
        }
        $this->_images = $figuras;

        // Preenchimento de Citações Disponíveis
        $referencias = $usuario->findDependentRowset('Referencia');
        foreach ($referencias as $referencia) {
            $identifier = $referencia->identificador;
            $parser->addCiteInfo($identifier);
        }
        $this->_citations = $referencias;

        // Processamento
        $parser->wikipage();
        $this->view->document = trim($parser->render());

        // Pacotes
        $this->view->packages = $this->_getPackages();

        // Informações Pessoais e Artigo
        $this->view->title  = $element->titulo;
        $this->view->author = $autor->nome;
        $this->view->email  = $autor->email;
        $this->view->address = $instituicao->endereco;

        // Citações Inclusas?
        $citations = $parser->getCitations();
        $this->view->citations = !empty($citations);

        // Construção da Saída
        $pathname = $this->_buildOutput();

        // Tipo de Saída Esperada
        $extension = $this->_getParam('type', 'pdf');
        if (!in_array($extension, array('pdf', 'zip'))) {
            $extension = 'pdf';
        }

        // Código Completo Compactado?
        if ($extension == 'zip') {
            $filter = new Zend_Filter_Compress(array(
                'adapter' => 'Zip',
                'options' => array(
                    'archive' => $pathname . '/document.zip'
                )
            ));
            $filter->filter($pathname);
        }

        // Capturar o Conteúdo
        $content = file_get_contents($pathname . '/document.' . $extension);
        // @todo Remover Diretório Temporário

        // Preparação para Ignorar Renderização de Saída
        $renderer = $this->_helper->getHelper('ViewRenderer');
        $renderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        // Modificação de Cabeçalho
        $this->getResponse()
             ->setHeader('Content-Type', 'application/' . $extension)
             ->setHeader('Content-Disposition', "attachment;filename=document.$extension")
             ->append('content', $content);
    }

    /**
     * Captura do Tradutor
     * @return SubWikiParser Elemento Solicitado
     */
    protected function _getParser()
    {
        if ($this->_parser === null) {
            $this->_parser = new SubWikiParser(null);
        }
        return $this->_parser;
    }

    /**
     * Construção da Lista de Pacotes Utilizados
     * @return array Conjunto de Elementos
     */
    protected function _getPackages()
    {
        // Pacotes Iniciais
        $packages = array();
        $packages['inputenc'] = array('utf8');
        $packages['fontenc'] = array('T1');
        $packages['babel'] = array('brazil');
        $packages['sbc-template'] = array();
        // Imagens Inseridas?
        $images = $this->_getParser()->getImages();
        if (!empty($images)) {
            $packages['graphicx'] = array();
        }
        return $packages;
    }

    /**
     * Construção da Saída Renderizada
     * @return string Nome do Diretório com o Conteúdo Processado
     */
    protected function _buildOutput()
    {
        // Diretório para Armazenamento Temporário
        $tempdir = APPLICATION_PATH . '/../temp/build-';
        do {
            $pathname = $tempdir . str_replace('.', '', microtime(true));
        } while (is_dir($pathname));

        // Tradutor
        $parser = $this->_getParser();

        // Construção da Saída
        $output = $this->view->render('article.phtml');
        if (!@mkdir($pathname)) { // Diretório
            throw new Exception('Temp Directory Error');
        }
        $pathname = realpath($pathname);
        file_put_contents($pathname . '/document.tex', $output);

        // Imagens
        $source = APPLICATION_PATH . '/../public/images/sistema';
        $images = $parser->getImages();
        foreach ($this->_images as $image) {
            if (in_array($image->identificador, $images)) {
                $arquivo = '/' . $image->arquivo;
                copy($source . $arquivo, $pathname . $arquivo);
            }
        }

        // Citações
        $citations = $parser->getCitations();
        if (!empty($citations)) { // Citações Inclusas?
            $result    = '';
            foreach ($this->_citations as $citation) {
                if (in_array($citation->identificador, $citations)) {
                    $result .= $citation->render();
                }
            }
            file_put_contents($pathname . '/document.bib', $result);
        }

        // Compilação LaTeX
        $prefix = "cd '$pathname' && ";
        $this->_exec('pdflatex document', $prefix); // Leitura do Documento
        if (!empty($citations)) {
            $this->_exec('bibtex document', $prefix); // Bibliografia
        }
        $this->_exec('pdflatex document', $prefix); // Referências Cruzadas
        $this->_exec('pdflatex document', $prefix); // Bibliografia

        // Informa o Diretório Utilizado
        return $pathname;
    }

    /**
     * Executa Determinado Comando para Compilação
     * @param string $command Comando para Execução
     * @param string $prefix  Prefixo do Comando
     * @return ArtigoController Próprio Objeto para Encadeamento
     * @throws Exception Erro de Execução Encontrado
     */
    protected function _exec($command, $prefix = '')
    {
        exec($prefix . $command, $output, $return);
        if ($return != 0) {
            throw new Exception('LaTeX Compiler Error', $return);
        }
        return $this;
    }
}
