<?php
// $ANTLR 3.1.3 ìàé 06, 2009 18:28:01 SubWiki.g 2011-06-26 17:51:43


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class SubWikiParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "T_NEWLINE", "T_STAR", "T_POUND", "T_BOLD", "T_ITALIC", "T_EQUAL", "T_SPACE", "T_CITE_OPEN", "T_CITE_CLOSE", "T_IMAGE_OPEN", "T_IMAGE_CLOSE", "T_NOWIKI_OPEN", "T_NOWIKI_CLOSE", "T_CHAR", "T_OTHER"
    );
    public $T_CITE_OPEN=11;
    public $T_IMAGE_CLOSE=14;
    public $T_POUND=6;
    public $T_CHAR=17;
    public $T_SPACE=10;
    public $T_EQUAL=9;
    public $T_OTHER=18;
    public $T_NOWIKI_CLOSE=16;
    public $T_STAR=5;
    public $T_NEWLINE=4;
    public $T_BOLD=7;
    public $T_CITE_CLOSE=12;
    public $T_NOWIKI_OPEN=15;
    public $T_ITALIC=8;
    public $EOF=-1;
    public $T_IMAGE_OPEN=13;

    // delegates
    // delegators

    
    static $FOLLOW_container_in_wikipage34;
    static $FOLLOW_nowiki_in_wikipage38;
    static $FOLLOW_EOF_in_wikipage43;
    static $FOLLOW_heading_in_container58;
    static $FOLLOW_lists_in_container62;
    static $FOLLOW_paragraph_in_container66;
    static $FOLLOW_container_end_in_container70;
    static $FOLLOW_T_NEWLINE_in_container_end78;
    static $FOLLOW_EOF_in_container_end84;
    static $FOLLOW_text_paragraph_in_paragraph102;
    static $FOLLOW_text_line_in_text_paragraph116;
    static $FOLLOW_text_eol_in_text_paragraph120;
    static $FOLLOW_text_line_in_text_paragraph122;
    static $FOLLOW_text_element_in_text_line135;
    static $FOLLOW_T_NEWLINE_in_text_eol146;
    static $FOLLOW_text_formatted_in_text_element156;
    static $FOLLOW_text_unformatted_in_text_element161;
    static $FOLLOW_cite_in_text_element168;
    static $FOLLOW_image_in_text_element173;
    static $FOLLOW_headingref_in_text_element178;
    static $FOLLOW_list_ord_in_lists189;
    static $FOLLOW_list_unord_in_lists194;
    static $FOLLOW_T_NEWLINE_in_list_eol202;
    static $FOLLOW_text_unformatted_in_list_item215;
    static $FOLLOW_list_unord_element_in_list_unord239;
    static $FOLLOW_list_eol_in_list_unord243;
    static $FOLLOW_list_unord_element_in_list_unord245;
    static $FOLLOW_T_STAR_in_list_unord_element256;
    static $FOLLOW_list_item_in_list_unord_element258;
    static $FOLLOW_list_ord_element_in_list_ord280;
    static $FOLLOW_list_eol_in_list_ord284;
    static $FOLLOW_list_ord_element_in_list_ord286;
    static $FOLLOW_T_POUND_in_list_ord_element297;
    static $FOLLOW_list_item_in_list_ord_element299;
    static $FOLLOW_markup_bold_in_text_formatted310;
    static $FOLLOW_bold_content_in_text_formatted312;
    static $FOLLOW_markup_bold_in_text_formatted316;
    static $FOLLOW_markup_italic_in_text_formatted323;
    static $FOLLOW_italic_content_in_text_formatted325;
    static $FOLLOW_markup_italic_in_text_formatted329;
    static $FOLLOW_T_BOLD_in_markup_bold339;
    static $FOLLOW_T_ITALIC_in_markup_italic347;
    static $FOLLOW_text_unformatted_in_bold_content356;
    static $FOLLOW_text_unformatted_in_italic_content364;
    static $FOLLOW_T_EQUAL_in_heading375;
    static $FOLLOW_heading_content_in_heading377;
    static $FOLLOW_T_EQUAL_in_heading379;
    static $FOLLOW_T_EQUAL_in_heading_content389;
    static $FOLLOW_heading_content_in_heading_content395;
    static $FOLLOW_T_EQUAL_in_heading_content397;
    static $FOLLOW_text_unformatted_in_heading_content402;
    static $FOLLOW_T_POUND_in_headingref415;
    static $FOLLOW_headingref_content_in_headingref417;
    static $FOLLOW_set_in_headingref_content429;
    static $FOLLOW_set_in_text_unformatted446;
    static $FOLLOW_T_CITE_OPEN_in_cite515;
    static $FOLLOW_cite_content_in_cite517;
    static $FOLLOW_T_CITE_CLOSE_in_cite521;
    static $FOLLOW_identifier_in_cite_content531;
    static $FOLLOW_T_IMAGE_OPEN_in_image542;
    static $FOLLOW_image_content_in_image544;
    static $FOLLOW_T_IMAGE_CLOSE_in_image548;
    static $FOLLOW_identifier_in_image_content558;
    static $FOLLOW_T_CHAR_in_identifier571;
    static $FOLLOW_T_NOWIKI_OPEN_in_nowiki585;
    static $FOLLOW_nowiki_content_in_nowiki587;
    static $FOLLOW_T_NOWIKI_CLOSE_in_nowiki589;
    static $FOLLOW_set_in_nowiki_content597;

    
    protected $dfa6;
    protected $dfa14;
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
             
            
            $this->dfa6 = new SubWikiParser_DFA6($this);
            $this->dfa14 = new SubWikiParser_DFA14($this);
            
        }
        

    public function getTokenNames() { return SubWikiParser::$tokenNames; }
    public function getGrammarFileName() { return "SubWiki.g"; }


    /**
     * Conteúdo
     * @var string
     */
    protected $_content = '';

    /**
     * Profundidade de Seção
     * @var int
     */
    protected $_sectionLevel = 0;

    /**
     * Profundidade de Lista
     * @var int
     */
    protected $_listLevel = 0;

    /**
     * Conjunto de Imagens Utilizadas
     * @var array
     */
    protected $_images = array();

    /**
     * Últimas Imagens Utilizadas no Parágrafo
     * @var array
     */
    protected $_imagesLast = array();

    /**
     * Informações de Imagens
     * @var array
     */
    protected $_imagesInfo = array();

    /**
     * Conjunto de Citações Utilizadas
     * @var array
     */
    protected $_cites = array();

    /**
     * Filtro Slugger
     * @var Hazel_Filter_Slugger
     */
    protected $_slugger = null;

    /**
     * Filtro de CamerCase para Slugger
     * @var Zend_Filter_Word_CamelCaseToSeparator
     */
    protected $_camelFilter = null;

    /**
     * Adiciona ao Final do Conteúdo
     * @param $content Conteúdo para Anexo
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    public function append($content) {
    	$this->_content .= $content;
    	return $this;
    }

    /**
     * Renderização Final
     * @return string Conteúdo Solicitado
     */
    public function render() {
    	return $this->_content;
    }

    /**
     * Construção de Seção
     * @param $content Conteúdo do Título de Seção
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _section($content) {
    	// Inicialização
    	$content = trim($content);
    	// Construção da Seção
    	$level  = $this->_getSectionLevel();
    	$sub    = str_repeat('sub', (int) $level);
    	$result = '\\' . $sub . 'section{' . $content . '}' . PHP_EOL;
    	$this->append($result);
    	// Criação da Etiqueta de Referência
    	$filter = $this->getSlugger();
    	$slug   = $filter->filter($content);
    	$result = sprintf('\\label{sec:%s}', $slug);
    	$this->append($result);
    	return $this;
    }

    /**
     * Renderização de Referência Cruzada para Seções
     * @param string $content Conteúdo para Renderização
     * @return string Valor Traduzido para Referência Cruzada
     * @throws Exception Referência Inválida
     */
    protected function _sectionReference($content) {
    	$filter  = $this->getCamelFilter();
    	$slugger = $this->getSlugger();
    	$content = $filter->filter($content);
    	$content = $slugger->filter($content);
    	$result  = sprintf('\\ref{sec:%s}', $content);
    	$this->append($result);
    	return $this;
    }

    /**
     * Nivelamento de Seção
     * @param $modifier Modificador
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _addSectionLevel($modifier) {
    	$this->_sectionLevel += (int) $modifier;
    	return $this;
    }

    /**
     * Configura o Nivelamento de Seção
     * @param $level Valor para Configuração
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _setSectionLevel($level) {
    	$this->_sectionLevel = (int) $level;
    	return $this;
    }

    /**
     * Informa o Nivelamento de Seção
     * @return int Valor do Nível Atual
     */
    protected function _getSectionLevel() {
    	return $this->_sectionLevel;
    }

    /**
     * Inclui uma Imagem para Utilização
     * @param $content Identificador da Imagem
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _image($content) {
    	$content = trim($content);
    	// Imagem já inserida no documento?
    	if (!in_array($content, $this->_images)) {
    		$this->_imagesLast[] = $content;
    	}
    	// Inclui Referência Cruzada
    	$result = '\\ref{fig:' . $content . '}';
    	$this->append($result);
    	return $this;
    }

    /**
     * Adiciona no Documento as Últimas Imagens Inseridas
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _appendImagesLast() {
    	// Seleciona as Últimas Imagens Inseridas
    	foreach ($this->_imagesLast as $identifier) {
    		$result = $this->_renderImage($identifier);
    		$this->append("\n\n"); // Duplo Espaçamento
    		$this->append($result);
    		// Confirmar Inserção da Imagem
    		$this->_images[] = $identifier;
    	}
    	// Limpa as Últimas Imagens
    	$this->_imagesLast = array();
    }

    /**
     * Renderiza uma Imagem pelo Identificador
     * @param $identifier Identificador da Imagem
     * @return string Conteúdo Resultante da Renderização
     * @throws Exception Identificador de Imagem Inválido
     */
    protected function _renderImage($identifier) {
    	// Imagem Registrada nas Informações?
    	if (!array_key_exists($identifier, $this->_imagesInfo)) {
    		throw new Exception("Invalid Image: { img: '$identifier' }");
    	}
    	// Informações da Imagem
    	$filename = $this->_imagesInfo[$identifier]['filename'];
    	$caption  = $this->_imagesInfo[$identifier]['caption'];
    	// Montagem da Renderização
    	$result = $this->_environment('figure','begin') . PHP_EOL;
    	$result.= "\t\\centering{}\n";
    	$result.= sprintf("\t\\includegraphics[\\textwidth]{%s}\n", $filename);
    	$result.= sprintf("\t\\caption{%s}\n", $caption);
    	$result.= sprintf("\t\\label{fig:%s}\n", $identifier);
    	$result.= $this->_environment('figure','end');
    	// Resultado do Processamento
    	return $result;
    }

    /**
     * Inclui uma Citação para Utilização
     * @param $content Identificador da Citação
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _cite($content) {
    	$content = trim($content);
    	$this->_cites[] = $content;
    	$result = '\\cite{' . $content . '}';
    	$this->append($result);
    	return $this;
    }

    /**
     * Formatação em Negrito
     * @param $content Conteúdo para Formatação
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _bold($content) {
    	$result = '\\textbf{' . $content . '}';
    	$this->append($result);
    	return $this;
    }

    /**
     * Formatação em Itálico
     * @param $content Conteúdo para Formatação
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _italic($content) {
    	$result = '\\textit{' . $content . '}';
    	$this->append($result);
    	return $this;
    }

    /**
     * Item de Listagem
     * @param $content Conteúdo do Item
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _listItem($content) {
    	$content = trim($content); 
    	$level   = $this->_getListLevel();
    	$ident   = str_repeat("\t", $level);
    	$result  = $ident . '\item ' . $content;
    	$this->append($result);
    	return $this;
    }

    /**
     * Nivelamento de Listas
     * @param $modifier Modificador
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _addListLevel($modifier) {
    	$this->_listLevel += (int) $modifier;
    	return $this;
    }

    /**
     * Configura o Nivelamento de Lista
     * @param $level Valor para Configuração
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    protected function _setListLevel($level) {
    	$this->_listLevel = (int) $level;
    	return $this;
    }

    /**
     * Informa o Nivelamento de Lista
     * @return int Valor Solicitado
     */
    protected function _getListLevel() {
    	return $this->_listLevel;
    }

    /**
     * Montagem de Ambiente Configurável
     * @param $type     Tipo de Ambiente
     * @param $location Localização da Instrução
     * @return string Resultado Solicitado
     */
    protected function _environment($type, $location) {
    	$result = sprintf('\\%s{%s}', $location, $type);
    	return $result;
    }

    /**
     * Monta um Ambiente de Lista
     * @param $type     enumerate|itemize
     * @param $location begin|end
     * @return SubWikiLexer Próprio Objeto para Encadeamento
     */
    protected function _list($type, $location) {
    	// Menor Identação ao Final
    	if ($location == 'end') {
    			$this->_addListLevel(-1);
    	}
    	// Atualização da Identação
    	$level  = $this->_getListLevel();
    	// Maior Identação no Início
    	if ($location == 'begin') {
    		$this->_addListLevel(1);
    	}
    	// Construção da Saída
    	$ident  = str_repeat("\t", $level);
    	$env    = $this->_environment($type, $location);
    	$result = $ident . $env;
    	$this->append($result);
    	return $this;
    }

    /**
     * Adiciona Informações sobre Imagens
     * @param $identifier Identificador da Imagem
     * @param $filename   Nome do Arquivo para Utilização
     * @param $caption    Legenda da Imagem
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    public function addImageInfo($identifier, $filename, $caption) {
    	$this->_imagesInfo[$identifier] = array(
    		'filename' => $filename,
    		'caption'  => $caption,
    	);
    	return $this;
    }

    /**
     * Configura o Filtro de Slug
     * @param Hazel_Filter_Slugger $slugger Elemento para Configuração
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    public function setSlugger(Hazel_Filter_Slugger $slugger) {
    	$this->_slugger = $slugger;
    	return $this;
    }

    /**
     * Informa o Filtro de Slug
     * @return Hazel_Filter_Slugger Elemento Solicitado
     */
    public function getSlugger() {
    	if ($this->_slugger === null) {
    		$slugger = new Hazel_Filter_Slugger();
    		$this->setSlugger($slugger);
    	}
    	return $this->_slugger;
    }

    /**
     * Configura o Filtro de CamelCase
     * @param Zend_Filter_Word_CamelCaseToSeparator $filter Elemento para Configuração
     * @return SubWikiParser Próprio Objeto para Encadeamento
     */
    public function setCamelFilter(Zend_Filter_Word_CamelCaseToSeparator $filter) {
    	$this->_camelFilter = $filter;
    	return $this;
    }

    /**
     * Informa o Filtro de CamelCase
     * @return Zend_Filter_Word_CamelCaseToSeparator Elemento Solicitado
     */
    public function getCamelFilter() {
    	if ($this->_camelFilter === null) {
    		$filter = new Zend_Filter_Word_CamelCaseToSeparator();
    		$this->setCamelFilter($filter);
    	}
    	return $this->_camelFilter;
    }




    // $ANTLR start "wikipage"
    // SubWiki.g:380:1: wikipage : ( container | nowiki )+ EOF ; 
    public function wikipage(){
        try {
            // SubWiki.g:381:2: ( ( container | nowiki )+ EOF ) 
            // SubWiki.g:381:4: ( container | nowiki )+ EOF 
            {
            // SubWiki.g:381:4: ( container | nowiki )+ 
            $cnt1=0;
            //loop1:
            do {
                $alt1=3;
                $LA1_0 = $this->input->LA(1);

                if ( (($LA1_0>=$this->getToken('T_STAR') && $LA1_0<=$this->getToken('T_CITE_OPEN'))||$LA1_0==$this->getToken('T_IMAGE_OPEN')||($LA1_0>=$this->getToken('T_CHAR') && $LA1_0<=$this->getToken('T_OTHER'))) ) {
                    $alt1=1;
                }
                else if ( ($LA1_0==$this->getToken('T_NOWIKI_OPEN')) ) {
                    $alt1=2;
                }


                switch ($alt1) {
            	case 1 :
            	    // SubWiki.g:381:6: container 
            	    {
            	    $this->pushFollow(self::$FOLLOW_container_in_wikipage34);
            	    $this->container();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // SubWiki.g:381:18: nowiki 
            	    {
            	    $this->pushFollow(self::$FOLLOW_nowiki_in_wikipage38);
            	    $this->nowiki();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt1 >= 1 ) break 2;//loop1;
                        $eee =
                            new EarlyExitException(1, $this->input);
                        throw $eee;
                }
                $cnt1++;
            } while (true);

            $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_wikipage43); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "wikipage"


    // $ANTLR start "container"
    // SubWiki.g:382:1: container : ( heading | lists | paragraph ) container_end ; 
    public function container(){
        try {
            // SubWiki.g:384:2: ( ( heading | lists | paragraph ) container_end ) 
            // SubWiki.g:384:4: ( heading | lists | paragraph ) container_end 
            {
            // SubWiki.g:384:4: ( heading | lists | paragraph ) 
            $alt2=3;
            $LA2 = $this->input->LA(1);
            if($this->getToken('T_EQUAL')== $LA2)
                {
                $alt2=1;
                }
            else if($this->getToken('T_POUND')== $LA2)
                {
                $LA2_2 = $this->input->LA(2);

                if ( ($LA2_2==$this->getToken('T_SPACE')||($LA2_2>=$this->getToken('T_CHAR') && $LA2_2<=$this->getToken('T_OTHER'))) ) {
                    $alt2=2;
                }
                else if ( (($LA2_2>=$this->getToken('T_NEWLINE') && $LA2_2<=$this->getToken('T_EQUAL'))||($LA2_2>=$this->getToken('T_CITE_OPEN') && $LA2_2<=$this->getToken('T_NOWIKI_CLOSE'))) ) {
                    $alt2=3;
                }
                else {
                    $nvae = new NoViableAltException("", 2, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('T_STAR')== $LA2)
                {
                $alt2=2;
                }
            else if($this->getToken('T_BOLD')== $LA2||$this->getToken('T_ITALIC')== $LA2||$this->getToken('T_SPACE')== $LA2||$this->getToken('T_CITE_OPEN')== $LA2||$this->getToken('T_IMAGE_OPEN')== $LA2||$this->getToken('T_CHAR')== $LA2||$this->getToken('T_OTHER')== $LA2)
                {
                $alt2=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 2, 0, $this->input);

                throw $nvae;
            }

            switch ($alt2) {
                case 1 :
                    // SubWiki.g:384:6: heading 
                    {
                    $this->pushFollow(self::$FOLLOW_heading_in_container58);
                    $this->heading();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // SubWiki.g:384:16: lists 
                    {
                    $this->pushFollow(self::$FOLLOW_lists_in_container62);
                    $this->lists();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // SubWiki.g:384:24: paragraph 
                    {
                    $this->pushFollow(self::$FOLLOW_paragraph_in_container66);
                    $this->paragraph();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_container_end_in_container70);
            $this->container_end();

            $this->state->_fsp--;


            }

               $this->append("\n\n"); 
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "container"


    // $ANTLR start "container_end"
    // SubWiki.g:385:1: container_end : ( ( T_NEWLINE )+ | EOF ); 
    public function container_end(){
        try {
            // SubWiki.g:386:2: ( ( T_NEWLINE )+ | EOF ) 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( ($LA4_0==$this->getToken('T_NEWLINE')) ) {
                $alt4=1;
            }
            else if ( ($LA4_0==$this->getToken('EOF')) ) {
                $alt4=2;
            }
            else {
                $nvae = new NoViableAltException("", 4, 0, $this->input);

                throw $nvae;
            }
            switch ($alt4) {
                case 1 :
                    // SubWiki.g:386:4: ( T_NEWLINE )+ 
                    {
                    // SubWiki.g:386:4: ( T_NEWLINE )+ 
                    $cnt3=0;
                    //loop3:
                    do {
                        $alt3=2;
                        $LA3_0 = $this->input->LA(1);

                        if ( ($LA3_0==$this->getToken('T_NEWLINE')) ) {
                            $alt3=1;
                        }


                        switch ($alt3) {
                    	case 1 :
                    	    // SubWiki.g:386:4: T_NEWLINE 
                    	    {
                    	    $this->match($this->input,$this->getToken('T_NEWLINE'),self::$FOLLOW_T_NEWLINE_in_container_end78); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt3 >= 1 ) break 2;//loop3;
                                $eee =
                                    new EarlyExitException(3, $this->input);
                                throw $eee;
                        }
                        $cnt3++;
                    } while (true);


                    }
                    break;
                case 2 :
                    // SubWiki.g:387:4: EOF 
                    {
                    $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_container_end84); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "container_end"


    // $ANTLR start "paragraph"
    // SubWiki.g:391:1: paragraph : ( text_paragraph )+ ; 
    public function paragraph(){
        try {
            // SubWiki.g:393:2: ( ( text_paragraph )+ ) 
            // SubWiki.g:393:4: ( text_paragraph )+ 
            {
            // SubWiki.g:393:4: ( text_paragraph )+ 
            $cnt5=0;
            //loop5:
            do {
                $alt5=2;
                $LA5_0 = $this->input->LA(1);

                if ( (($LA5_0>=$this->getToken('T_POUND') && $LA5_0<=$this->getToken('T_ITALIC'))||($LA5_0>=$this->getToken('T_SPACE') && $LA5_0<=$this->getToken('T_CITE_OPEN'))||$LA5_0==$this->getToken('T_IMAGE_OPEN')||($LA5_0>=$this->getToken('T_CHAR') && $LA5_0<=$this->getToken('T_OTHER'))) ) {
                    $alt5=1;
                }


                switch ($alt5) {
            	case 1 :
            	    // SubWiki.g:393:6: text_paragraph 
            	    {
            	    $this->pushFollow(self::$FOLLOW_text_paragraph_in_paragraph102);
            	    $this->text_paragraph();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt5 >= 1 ) break 2;//loop5;
                        $eee =
                            new EarlyExitException(5, $this->input);
                        throw $eee;
                }
                $cnt5++;
            } while (true);


            }

               $this->_appendImagesLast(); 
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "paragraph"


    // $ANTLR start "text_paragraph"
    // SubWiki.g:397:1: text_paragraph : text_line ( text_eol text_line )* ; 
    public function text_paragraph(){
        try {
            // SubWiki.g:398:2: ( text_line ( text_eol text_line )* ) 
            // SubWiki.g:398:4: text_line ( text_eol text_line )* 
            {
            $this->pushFollow(self::$FOLLOW_text_line_in_text_paragraph116);
            $this->text_line();

            $this->state->_fsp--;

            // SubWiki.g:398:14: ( text_eol text_line )* 
            //loop6:
            do {
                $alt6=2;
                $alt6 = $this->dfa6->predict($this->input);
                switch ($alt6) {
            	case 1 :
            	    // SubWiki.g:398:16: text_eol text_line 
            	    {
            	    $this->pushFollow(self::$FOLLOW_text_eol_in_text_paragraph120);
            	    $this->text_eol();

            	    $this->state->_fsp--;

            	    $this->pushFollow(self::$FOLLOW_text_line_in_text_paragraph122);
            	    $this->text_line();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop6;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "text_paragraph"


    // $ANTLR start "text_line"
    // SubWiki.g:399:1: text_line : ( text_element )+ ; 
    public function text_line(){
        try {
            // SubWiki.g:400:2: ( ( text_element )+ ) 
            // SubWiki.g:400:4: ( text_element )+ 
            {
            // SubWiki.g:400:4: ( text_element )+ 
            $cnt7=0;
            //loop7:
            do {
                $alt7=2;
                $LA7 = $this->input->LA(1);
                if($this->getToken('T_BOLD')== $LA7)
                    {
                    $alt7=1;
                    }
                else if($this->getToken('T_ITALIC')== $LA7)
                    {
                    $alt7=1;
                    }
                else if($this->getToken('T_SPACE')== $LA7||$this->getToken('T_CHAR')== $LA7||$this->getToken('T_OTHER')== $LA7)
                    {
                    $alt7=1;
                    }
                else if($this->getToken('T_CITE_OPEN')== $LA7)
                    {
                    $alt7=1;
                    }
                else if($this->getToken('T_IMAGE_OPEN')== $LA7)
                    {
                    $alt7=1;
                    }
                else if($this->getToken('T_POUND')== $LA7)
                    {
                    $alt7=1;
                    }



                switch ($alt7) {
            	case 1 :
            	    // SubWiki.g:400:6: text_element 
            	    {
            	    $this->pushFollow(self::$FOLLOW_text_element_in_text_line135);
            	    $this->text_element();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt7 >= 1 ) break 2;//loop7;
                        $eee =
                            new EarlyExitException(7, $this->input);
                        throw $eee;
                }
                $cnt7++;
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "text_line"


    // $ANTLR start "text_eol"
    // SubWiki.g:401:1: text_eol : T_NEWLINE ; 
    public function text_eol(){
        try {
            // SubWiki.g:402:2: ( T_NEWLINE ) 
            // SubWiki.g:402:4: T_NEWLINE 
            {
            $this->match($this->input,$this->getToken('T_NEWLINE'),self::$FOLLOW_T_NEWLINE_in_text_eol146); 
               $this->append(' '); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "text_eol"


    // $ANTLR start "text_element"
    // SubWiki.g:403:1: text_element : ( text_formatted | text_unformatted | cite | image | headingref ); 
    public function text_element(){
        $text_unformatted1 = null;


        try {
            // SubWiki.g:404:2: ( text_formatted | text_unformatted | cite | image | headingref ) 
            $alt8=5;
            $LA8 = $this->input->LA(1);
            if($this->getToken('T_BOLD')== $LA8||$this->getToken('T_ITALIC')== $LA8)
                {
                $alt8=1;
                }
            else if($this->getToken('T_SPACE')== $LA8||$this->getToken('T_CHAR')== $LA8||$this->getToken('T_OTHER')== $LA8)
                {
                $alt8=2;
                }
            else if($this->getToken('T_CITE_OPEN')== $LA8)
                {
                $alt8=3;
                }
            else if($this->getToken('T_IMAGE_OPEN')== $LA8)
                {
                $alt8=4;
                }
            else if($this->getToken('T_POUND')== $LA8)
                {
                $alt8=5;
                }
            else{
                $nvae =
                    new NoViableAltException("", 8, 0, $this->input);

                throw $nvae;
            }

            switch ($alt8) {
                case 1 :
                    // SubWiki.g:404:4: text_formatted 
                    {
                    $this->pushFollow(self::$FOLLOW_text_formatted_in_text_element156);
                    $this->text_formatted();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // SubWiki.g:405:4: text_unformatted 
                    {
                    $this->pushFollow(self::$FOLLOW_text_unformatted_in_text_element161);
                    $text_unformatted1=$this->text_unformatted();

                    $this->state->_fsp--;

                       $this->append(($text_unformatted1!=null?$this->input->toStringBetweenTokens($text_unformatted1->start,$text_unformatted1->stop):null)); 

                    }
                    break;
                case 3 :
                    // SubWiki.g:406:4: cite 
                    {
                    $this->pushFollow(self::$FOLLOW_cite_in_text_element168);
                    $this->cite();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // SubWiki.g:407:4: image 
                    {
                    $this->pushFollow(self::$FOLLOW_image_in_text_element173);
                    $this->image();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // SubWiki.g:408:4: headingref 
                    {
                    $this->pushFollow(self::$FOLLOW_headingref_in_text_element178);
                    $this->headingref();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "text_element"


    // $ANTLR start "lists"
    // SubWiki.g:412:1: lists : ( list_ord | list_unord ); 
    public function lists(){
        try {
            // SubWiki.g:413:2: ( list_ord | list_unord ) 
            $alt9=2;
            $LA9_0 = $this->input->LA(1);

            if ( ($LA9_0==$this->getToken('T_POUND')) ) {
                $alt9=1;
            }
            else if ( ($LA9_0==$this->getToken('T_STAR')) ) {
                $alt9=2;
            }
            else {
                $nvae = new NoViableAltException("", 9, 0, $this->input);

                throw $nvae;
            }
            switch ($alt9) {
                case 1 :
                    // SubWiki.g:413:4: list_ord 
                    {
                    $this->pushFollow(self::$FOLLOW_list_ord_in_lists189);
                    $this->list_ord();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // SubWiki.g:414:4: list_unord 
                    {
                    $this->pushFollow(self::$FOLLOW_list_unord_in_lists194);
                    $this->list_unord();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "lists"


    // $ANTLR start "list_eol"
    // SubWiki.g:415:1: list_eol : T_NEWLINE ; 
    public function list_eol(){
        try {
            // SubWiki.g:416:2: ( T_NEWLINE ) 
            // SubWiki.g:416:4: T_NEWLINE 
            {
            $this->match($this->input,$this->getToken('T_NEWLINE'),self::$FOLLOW_T_NEWLINE_in_list_eol202); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_eol"


    // $ANTLR start "list_item"
    // SubWiki.g:417:1: list_item : text_unformatted ; 
    public function list_item(){
        $text_unformatted2 = null;


        try {
            // SubWiki.g:419:2: ( text_unformatted ) 
            // SubWiki.g:419:4: text_unformatted 
            {
            $this->pushFollow(self::$FOLLOW_text_unformatted_in_list_item215);
            $text_unformatted2=$this->text_unformatted();

            $this->state->_fsp--;

               $this->_listItem(($text_unformatted2!=null?$this->input->toStringBetweenTokens($text_unformatted2->start,$text_unformatted2->stop):null)); 

            }

               $this->append("\n"); 
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_item"


    // $ANTLR start "list_unord"
    // SubWiki.g:423:1: list_unord : list_unord_element ( list_eol list_unord_element )* ; 
    public function list_unord(){
         $this->_list('itemize', 'begin'); $this->append("\n"); 
        try {
            // SubWiki.g:426:2: ( list_unord_element ( list_eol list_unord_element )* ) 
            // SubWiki.g:426:4: list_unord_element ( list_eol list_unord_element )* 
            {
            $this->pushFollow(self::$FOLLOW_list_unord_element_in_list_unord239);
            $this->list_unord_element();

            $this->state->_fsp--;

            // SubWiki.g:426:23: ( list_eol list_unord_element )* 
            //loop10:
            do {
                $alt10=2;
                $LA10_0 = $this->input->LA(1);

                if ( ($LA10_0==$this->getToken('T_NEWLINE')) ) {
                    $LA10_1 = $this->input->LA(2);

                    if ( ($LA10_1==$this->getToken('T_STAR')) ) {
                        $LA10_3 = $this->input->LA(3);

                        if ( ($LA10_3==$this->getToken('T_SPACE')||($LA10_3>=$this->getToken('T_CHAR') && $LA10_3<=$this->getToken('T_OTHER'))) ) {
                            $alt10=1;
                        }


                    }


                }


                switch ($alt10) {
            	case 1 :
            	    // SubWiki.g:426:25: list_eol list_unord_element 
            	    {
            	    $this->pushFollow(self::$FOLLOW_list_eol_in_list_unord243);
            	    $this->list_eol();

            	    $this->state->_fsp--;

            	    $this->pushFollow(self::$FOLLOW_list_unord_element_in_list_unord245);
            	    $this->list_unord_element();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop10;
                }
            } while (true);


            }

               $this->_list('itemize', 'end'); 
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_unord"


    // $ANTLR start "list_unord_element"
    // SubWiki.g:427:1: list_unord_element : T_STAR list_item ; 
    public function list_unord_element(){
        try {
            // SubWiki.g:428:2: ( T_STAR list_item ) 
            // SubWiki.g:428:4: T_STAR list_item 
            {
            $this->match($this->input,$this->getToken('T_STAR'),self::$FOLLOW_T_STAR_in_list_unord_element256); 
            $this->pushFollow(self::$FOLLOW_list_item_in_list_unord_element258);
            $this->list_item();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_unord_element"


    // $ANTLR start "list_ord"
    // SubWiki.g:432:1: list_ord : list_ord_element ( list_eol list_ord_element )* ; 
    public function list_ord(){
         $this->_list('enumerate', 'begin'); $this->append("\n"); 
        try {
            // SubWiki.g:435:2: ( list_ord_element ( list_eol list_ord_element )* ) 
            // SubWiki.g:435:4: list_ord_element ( list_eol list_ord_element )* 
            {
            $this->pushFollow(self::$FOLLOW_list_ord_element_in_list_ord280);
            $this->list_ord_element();

            $this->state->_fsp--;

            // SubWiki.g:435:21: ( list_eol list_ord_element )* 
            //loop11:
            do {
                $alt11=2;
                $LA11_0 = $this->input->LA(1);

                if ( ($LA11_0==$this->getToken('T_NEWLINE')) ) {
                    $LA11_1 = $this->input->LA(2);

                    if ( ($LA11_1==$this->getToken('T_POUND')) ) {
                        $LA11_3 = $this->input->LA(3);

                        if ( (($LA11_3>=$this->getToken('T_CHAR') && $LA11_3<=$this->getToken('T_OTHER'))) ) {
                            $alt11=1;
                        }
                        else if ( ($LA11_3==$this->getToken('T_SPACE')) ) {
                            $alt11=1;
                        }


                    }


                }


                switch ($alt11) {
            	case 1 :
            	    // SubWiki.g:435:23: list_eol list_ord_element 
            	    {
            	    $this->pushFollow(self::$FOLLOW_list_eol_in_list_ord284);
            	    $this->list_eol();

            	    $this->state->_fsp--;

            	    $this->pushFollow(self::$FOLLOW_list_ord_element_in_list_ord286);
            	    $this->list_ord_element();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop11;
                }
            } while (true);


            }

               $this->_list('enumerate', 'end'); 
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_ord"


    // $ANTLR start "list_ord_element"
    // SubWiki.g:436:1: list_ord_element : T_POUND list_item ; 
    public function list_ord_element(){
        try {
            // SubWiki.g:437:2: ( T_POUND list_item ) 
            // SubWiki.g:437:4: T_POUND list_item 
            {
            $this->match($this->input,$this->getToken('T_POUND'),self::$FOLLOW_T_POUND_in_list_ord_element297); 
            $this->pushFollow(self::$FOLLOW_list_item_in_list_ord_element299);
            $this->list_item();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "list_ord_element"


    // $ANTLR start "text_formatted"
    // SubWiki.g:441:1: text_formatted : ( markup_bold bold_content markup_bold | markup_italic italic_content markup_italic ); 
    public function text_formatted(){
        $bold_content3 = null;

        $italic_content4 = null;


        try {
            // SubWiki.g:442:2: ( markup_bold bold_content markup_bold | markup_italic italic_content markup_italic ) 
            $alt12=2;
            $LA12_0 = $this->input->LA(1);

            if ( ($LA12_0==$this->getToken('T_BOLD')) ) {
                $alt12=1;
            }
            else if ( ($LA12_0==$this->getToken('T_ITALIC')) ) {
                $alt12=2;
            }
            else {
                $nvae = new NoViableAltException("", 12, 0, $this->input);

                throw $nvae;
            }
            switch ($alt12) {
                case 1 :
                    // SubWiki.g:442:4: markup_bold bold_content markup_bold 
                    {
                    $this->pushFollow(self::$FOLLOW_markup_bold_in_text_formatted310);
                    $this->markup_bold();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_bold_content_in_text_formatted312);
                    $bold_content3=$this->bold_content();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_markup_bold_in_text_formatted316);
                    $this->markup_bold();

                    $this->state->_fsp--;

                       $this->_bold(($bold_content3!=null?$this->input->toStringBetweenTokens($bold_content3->start,$bold_content3->stop):null)); 

                    }
                    break;
                case 2 :
                    // SubWiki.g:444:4: markup_italic italic_content markup_italic 
                    {
                    $this->pushFollow(self::$FOLLOW_markup_italic_in_text_formatted323);
                    $this->markup_italic();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_italic_content_in_text_formatted325);
                    $italic_content4=$this->italic_content();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_markup_italic_in_text_formatted329);
                    $this->markup_italic();

                    $this->state->_fsp--;

                       $this->_italic(($italic_content4!=null?$this->input->toStringBetweenTokens($italic_content4->start,$italic_content4->stop):null)); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "text_formatted"


    // $ANTLR start "markup_bold"
    // SubWiki.g:446:1: markup_bold : T_BOLD ; 
    public function markup_bold(){
        try {
            // SubWiki.g:447:2: ( T_BOLD ) 
            // SubWiki.g:447:4: T_BOLD 
            {
            $this->match($this->input,$this->getToken('T_BOLD'),self::$FOLLOW_T_BOLD_in_markup_bold339); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "markup_bold"


    // $ANTLR start "markup_italic"
    // SubWiki.g:448:1: markup_italic : T_ITALIC ; 
    public function markup_italic(){
        try {
            // SubWiki.g:449:2: ( T_ITALIC ) 
            // SubWiki.g:449:4: T_ITALIC 
            {
            $this->match($this->input,$this->getToken('T_ITALIC'),self::$FOLLOW_T_ITALIC_in_markup_italic347); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "markup_italic"

    public static function bold_content_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "bold_content"
    // SubWiki.g:451:1: bold_content : text_unformatted ; 
    public function bold_content(){
        $retval = $this->bold_content_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:452:2: ( text_unformatted ) 
            // SubWiki.g:452:4: text_unformatted 
            {
            $this->pushFollow(self::$FOLLOW_text_unformatted_in_bold_content356);
            $this->text_unformatted();

            $this->state->_fsp--;


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "bold_content"

    public static function italic_content_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "italic_content"
    // SubWiki.g:453:1: italic_content : text_unformatted ; 
    public function italic_content(){
        $retval = $this->italic_content_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:454:2: ( text_unformatted ) 
            // SubWiki.g:454:4: text_unformatted 
            {
            $this->pushFollow(self::$FOLLOW_text_unformatted_in_italic_content364);
            $this->text_unformatted();

            $this->state->_fsp--;


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "italic_content"


    // $ANTLR start "heading"
    // SubWiki.g:458:1: heading : T_EQUAL heading_content T_EQUAL ; 
    public function heading(){
        try {
            // SubWiki.g:459:2: ( T_EQUAL heading_content T_EQUAL ) 
            // SubWiki.g:459:4: T_EQUAL heading_content T_EQUAL 
            {
            $this->match($this->input,$this->getToken('T_EQUAL'),self::$FOLLOW_T_EQUAL_in_heading375); 
            $this->pushFollow(self::$FOLLOW_heading_content_in_heading377);
            $this->heading_content();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('T_EQUAL'),self::$FOLLOW_T_EQUAL_in_heading379); 
               $this->_setSectionLevel(0); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "heading"


    // $ANTLR start "heading_content"
    // SubWiki.g:460:1: heading_content : ( T_EQUAL heading_content T_EQUAL | text_unformatted ); 
    public function heading_content(){
        $text_unformatted5 = null;


        try {
            // SubWiki.g:461:2: ( T_EQUAL heading_content T_EQUAL | text_unformatted ) 
            $alt13=2;
            $LA13_0 = $this->input->LA(1);

            if ( ($LA13_0==$this->getToken('T_EQUAL')) ) {
                $alt13=1;
            }
            else if ( ($LA13_0==$this->getToken('T_SPACE')||($LA13_0>=$this->getToken('T_CHAR') && $LA13_0<=$this->getToken('T_OTHER'))) ) {
                $alt13=2;
            }
            else {
                $nvae = new NoViableAltException("", 13, 0, $this->input);

                throw $nvae;
            }
            switch ($alt13) {
                case 1 :
                    // SubWiki.g:461:4: T_EQUAL heading_content T_EQUAL 
                    {
                    $this->match($this->input,$this->getToken('T_EQUAL'),self::$FOLLOW_T_EQUAL_in_heading_content389); 
                       $this->_addSectionLevel(1); 
                    $this->pushFollow(self::$FOLLOW_heading_content_in_heading_content395);
                    $this->heading_content();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('T_EQUAL'),self::$FOLLOW_T_EQUAL_in_heading_content397); 

                    }
                    break;
                case 2 :
                    // SubWiki.g:463:4: text_unformatted 
                    {
                    $this->pushFollow(self::$FOLLOW_text_unformatted_in_heading_content402);
                    $text_unformatted5=$this->text_unformatted();

                    $this->state->_fsp--;

                       $this->_section(($text_unformatted5!=null?$this->input->toStringBetweenTokens($text_unformatted5->start,$text_unformatted5->stop):null)); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "heading_content"


    // $ANTLR start "headingref"
    // SubWiki.g:467:1: headingref : T_POUND headingref_content ; 
    public function headingref(){
        $headingref_content6 = null;


        try {
            // SubWiki.g:468:2: ( T_POUND headingref_content ) 
            // SubWiki.g:468:4: T_POUND headingref_content 
            {
            $this->match($this->input,$this->getToken('T_POUND'),self::$FOLLOW_T_POUND_in_headingref415); 
            $this->pushFollow(self::$FOLLOW_headingref_content_in_headingref417);
            $headingref_content6=$this->headingref_content();

            $this->state->_fsp--;

               $this->_sectionReference(($headingref_content6!=null?$this->input->toStringBetweenTokens($headingref_content6->start,$headingref_content6->stop):null)); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "headingref"

    public static function headingref_content_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "headingref_content"
    // SubWiki.g:470:1: headingref_content : (~ ( T_SPACE ) )+ ; 
    public function headingref_content(){
        $retval = $this->headingref_content_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:471:2: ( (~ ( T_SPACE ) )+ ) 
            // SubWiki.g:471:4: (~ ( T_SPACE ) )+ 
            {
            // SubWiki.g:471:4: (~ ( T_SPACE ) )+ 
            $cnt14=0;
            //loop14:
            do {
                $alt14=2;
                $alt14 = $this->dfa14->predict($this->input);
                switch ($alt14) {
            	case 1 :
            	    // SubWiki.g:471:4: ~ ( T_SPACE ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('T_NEWLINE') && $this->input->LA(1)<=$this->getToken('T_EQUAL'))||($this->input->LA(1)>=$this->getToken('T_CITE_OPEN') && $this->input->LA(1)<=$this->getToken('T_OTHER')) ) {
            	        $this->input->consume();
            	        $this->state->errorRecovery=false;
            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        throw $mse;
            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt14 >= 1 ) break 2;//loop14;
                        $eee =
                            new EarlyExitException(14, $this->input);
                        throw $eee;
                }
                $cnt14++;
            } while (true);


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "headingref_content"

    public static function text_unformatted_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "text_unformatted"
    // SubWiki.g:475:1: text_unformatted : (~ ( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF ) )+ ; 
    public function text_unformatted(){
        $retval = $this->text_unformatted_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:476:2: ( (~ ( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF ) )+ ) 
            // SubWiki.g:476:4: (~ ( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF ) )+ 
            {
            // SubWiki.g:476:4: (~ ( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF ) )+ 
            $cnt15=0;
            //loop15:
            do {
                $alt15=2;
                $LA15_0 = $this->input->LA(1);

                if ( ($LA15_0==$this->getToken('T_SPACE')||($LA15_0>=$this->getToken('T_CHAR') && $LA15_0<=$this->getToken('T_OTHER'))) ) {
                    $alt15=1;
                }


                switch ($alt15) {
            	case 1 :
            	    // SubWiki.g:476:4: ~ ( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF ) 
            	    {
            	    if ( $this->input->LA(1)==$this->getToken('T_SPACE')||($this->input->LA(1)>=$this->getToken('T_CHAR') && $this->input->LA(1)<=$this->getToken('T_OTHER')) ) {
            	        $this->input->consume();
            	        $this->state->errorRecovery=false;
            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        throw $mse;
            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt15 >= 1 ) break 2;//loop15;
                        $eee =
                            new EarlyExitException(15, $this->input);
                        throw $eee;
                }
                $cnt15++;
            } while (true);


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "text_unformatted"


    // $ANTLR start "cite"
    // SubWiki.g:482:1: cite : T_CITE_OPEN cite_content T_CITE_CLOSE ; 
    public function cite(){
        $cite_content7 = null;


        try {
            // SubWiki.g:483:2: ( T_CITE_OPEN cite_content T_CITE_CLOSE ) 
            // SubWiki.g:483:4: T_CITE_OPEN cite_content T_CITE_CLOSE 
            {
            $this->match($this->input,$this->getToken('T_CITE_OPEN'),self::$FOLLOW_T_CITE_OPEN_in_cite515); 
            $this->pushFollow(self::$FOLLOW_cite_content_in_cite517);
            $cite_content7=$this->cite_content();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('T_CITE_CLOSE'),self::$FOLLOW_T_CITE_CLOSE_in_cite521); 
               $this->_cite(($cite_content7!=null?$this->input->toStringBetweenTokens($cite_content7->start,$cite_content7->stop):null)); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "cite"

    public static function cite_content_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "cite_content"
    // SubWiki.g:485:1: cite_content : identifier ; 
    public function cite_content(){
        $retval = $this->cite_content_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:486:2: ( identifier ) 
            // SubWiki.g:486:4: identifier 
            {
            $this->pushFollow(self::$FOLLOW_identifier_in_cite_content531);
            $this->identifier();

            $this->state->_fsp--;


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "cite_content"


    // $ANTLR start "image"
    // SubWiki.g:490:1: image : T_IMAGE_OPEN image_content T_IMAGE_CLOSE ; 
    public function image(){
        $image_content8 = null;


        try {
            // SubWiki.g:491:2: ( T_IMAGE_OPEN image_content T_IMAGE_CLOSE ) 
            // SubWiki.g:491:4: T_IMAGE_OPEN image_content T_IMAGE_CLOSE 
            {
            $this->match($this->input,$this->getToken('T_IMAGE_OPEN'),self::$FOLLOW_T_IMAGE_OPEN_in_image542); 
            $this->pushFollow(self::$FOLLOW_image_content_in_image544);
            $image_content8=$this->image_content();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('T_IMAGE_CLOSE'),self::$FOLLOW_T_IMAGE_CLOSE_in_image548); 
               $this->_image(($image_content8!=null?$this->input->toStringBetweenTokens($image_content8->start,$image_content8->stop):null)); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "image"

    public static function image_content_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "image_content"
    // SubWiki.g:493:1: image_content : identifier ; 
    public function image_content(){
        $retval = $this->image_content_return();
        $retval->start = $this->input->LT(1);

        try {
            // SubWiki.g:494:2: ( identifier ) 
            // SubWiki.g:494:4: identifier 
            {
            $this->pushFollow(self::$FOLLOW_identifier_in_image_content558);
            $this->identifier();

            $this->state->_fsp--;


            }

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "image_content"


    // $ANTLR start "identifier"
    // SubWiki.g:498:1: identifier : ( T_CHAR )+ ; 
    public function identifier(){
        try {
            // SubWiki.g:499:2: ( ( T_CHAR )+ ) 
            // SubWiki.g:499:4: ( T_CHAR )+ 
            {
            // SubWiki.g:499:4: ( T_CHAR )+ 
            $cnt16=0;
            //loop16:
            do {
                $alt16=2;
                $LA16_0 = $this->input->LA(1);

                if ( ($LA16_0==$this->getToken('T_CHAR')) ) {
                    $alt16=1;
                }


                switch ($alt16) {
            	case 1 :
            	    // SubWiki.g:499:6: T_CHAR 
            	    {
            	    $this->match($this->input,$this->getToken('T_CHAR'),self::$FOLLOW_T_CHAR_in_identifier571); 

            	    }
            	    break;

            	default :
            	    if ( $cnt16 >= 1 ) break 2;//loop16;
                        $eee =
                            new EarlyExitException(16, $this->input);
                        throw $eee;
                }
                $cnt16++;
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "identifier"


    // $ANTLR start "nowiki"
    // SubWiki.g:503:1: nowiki : T_NOWIKI_OPEN nowiki_content T_NOWIKI_CLOSE ; 
    public function nowiki(){
        try {
            // SubWiki.g:504:2: ( T_NOWIKI_OPEN nowiki_content T_NOWIKI_CLOSE ) 
            // SubWiki.g:504:4: T_NOWIKI_OPEN nowiki_content T_NOWIKI_CLOSE 
            {
            $this->match($this->input,$this->getToken('T_NOWIKI_OPEN'),self::$FOLLOW_T_NOWIKI_OPEN_in_nowiki585); 
            $this->pushFollow(self::$FOLLOW_nowiki_content_in_nowiki587);
            $this->nowiki_content();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('T_NOWIKI_CLOSE'),self::$FOLLOW_T_NOWIKI_CLOSE_in_nowiki589); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "nowiki"


    // $ANTLR start "nowiki_content"
    // SubWiki.g:505:1: nowiki_content : (~ ( T_NOWIKI_CLOSE ) )+ ; 
    public function nowiki_content(){
        try {
            // SubWiki.g:506:2: ( (~ ( T_NOWIKI_CLOSE ) )+ ) 
            // SubWiki.g:506:4: (~ ( T_NOWIKI_CLOSE ) )+ 
            {
            // SubWiki.g:506:4: (~ ( T_NOWIKI_CLOSE ) )+ 
            $cnt17=0;
            //loop17:
            do {
                $alt17=2;
                $LA17_0 = $this->input->LA(1);

                if ( (($LA17_0>=$this->getToken('T_NEWLINE') && $LA17_0<=$this->getToken('T_NOWIKI_OPEN'))||($LA17_0>=$this->getToken('T_CHAR') && $LA17_0<=$this->getToken('T_OTHER'))) ) {
                    $alt17=1;
                }


                switch ($alt17) {
            	case 1 :
            	    // SubWiki.g:506:4: ~ ( T_NOWIKI_CLOSE ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('T_NEWLINE') && $this->input->LA(1)<=$this->getToken('T_NOWIKI_OPEN'))||($this->input->LA(1)>=$this->getToken('T_CHAR') && $this->input->LA(1)<=$this->getToken('T_OTHER')) ) {
            	        $this->input->consume();
            	        $this->state->errorRecovery=false;
            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        throw $mse;
            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt17 >= 1 ) break 2;//loop17;
                        $eee =
                            new EarlyExitException(17, $this->input);
                        throw $eee;
                }
                $cnt17++;
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "nowiki_content"

    // Delegated rules


    
}

function SubWikiParser_DFA6_static(){
    $eot = array(19, 65535);
    $eof = array(2, 2, 17, 65535);
    $min = array(2, 4, 1, 65535, 1, 4, 2, 10, 1, 65535, 2, 17, 2, 65535, 
    1, 7, 1, 8, 1, 12, 1, 14, 4, 65535);
    $max = array(2, 18, 1, 65535, 3, 18, 1, 65535, 2, 17, 2, 65535, 2, 18, 
    2, 17, 4, 65535);
    $accept = array(2, 65535, 1, 2, 3, 65535, 1, 1, 2, 65535, 2, 1, 4, 65535, 
    4, 1);
    $special = array(19, 65535);
    $transitionS = array(array(1, 1, 1, 65535, 3, 2, 1, 65535, 2, 2, 1, 
    65535, 1, 2, 3, 65535, 2, 2), array(2, 2, 1, 3, 1, 4, 1, 5, 1, 2, 1, 
    6, 1, 7, 1, 65535, 1, 8, 1, 65535, 1, 2, 1, 65535, 2, 6), array(), array(
    6, 10, 1, 2, 6, 10, 2, 9), array(1, 11, 6, 65535, 2, 11), array(1, 12, 
    6, 65535, 2, 12), array(), array(1, 13), array(1, 14), array(), array(
    ), array(1, 15, 2, 65535, 1, 11, 6, 65535, 2, 11), array(1, 16, 1, 65535, 
    1, 12, 6, 65535, 2, 12), array(1, 17, 4, 65535, 1, 13), array(1, 18, 
    2, 65535, 1, 14), array(), array(), array(), array());

    $arr = array();
    $arr['eot'] = DFA::unpackRLE($eot);
    $arr['eof'] = DFA::unpackRLE($eof);
    $arr['min'] = DFA::unpackRLE($min, true);
    $arr['max'] = DFA::unpackRLE($max, true);
    $arr['accept'] = DFA::unpackRLE($accept);
    $arr['special'] = DFA::unpackRLE($special);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
    }
    return $arr;
}
$SubWikiParser_DFA6 = SubWikiParser_DFA6_static();

class SubWikiParser_DFA6 extends DFA {

    public function __construct($recognizer) {
        //global $SubWikiParser_DFA6;
        $DFA = SubWikiParser_DFA6_static();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 6;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "()* loopback of 398:14: ( text_eol text_line )*";
    }
}
function SubWikiParser_DFA14_static(){
    $eot = array(25, 65535);
    $eof = array(1, 2, 2, 65535, 2, 8, 1, 65535, 2, 8, 1, 65535, 1, 8, 2, 
    15, 1, 17, 2, 19, 1, 65535, 1, 2, 1, 65535, 1, 2, 2, 65535, 2, 2, 2, 
    20);
    $min = array(1, 4, 2, 65535, 2, 4, 1, 65535, 2, 4, 1, 65535, 6, 4, 1, 
    65535, 1, 4, 1, 65535, 1, 4, 2, 65535, 4, 4);
    $max = array(1, 18, 2, 65535, 2, 18, 1, 65535, 2, 18, 1, 65535, 6, 18, 
    1, 65535, 1, 18, 1, 65535, 1, 18, 2, 65535, 4, 18);
    $accept = array(1, 65535, 1, 1, 1, 2, 2, 65535, 1, 1, 2, 65535, 1, 1, 
    6, 65535, 1, 1, 1, 65535, 1, 1, 1, 65535, 2, 1, 4, 65535);
    $special = array(25, 65535);
    $transitionS = array(array(1, 1, 2, 8, 1, 3, 1, 4, 1, 8, 1, 2, 1, 6, 
    1, 8, 1, 7, 3, 8, 2, 5), array(), array(), array(6, 8, 1, 10, 6, 8, 
    2, 9), array(6, 8, 1, 12, 6, 8, 2, 11), array(), array(13, 8, 1, 13, 
    1, 8), array(13, 8, 1, 14, 1, 8), array(), array(1, 8, 5, 15, 1, 10, 
    6, 15, 2, 9), array(1, 15, 1, 65535, 1, 15, 1, 16, 1, 15, 1, 65535, 
    1, 10, 1, 15, 1, 65535, 1, 15, 3, 65535, 2, 10), array(1, 15, 2, 17, 
    1, 15, 2, 17, 1, 12, 6, 17, 2, 11), array(1, 17, 1, 65535, 2, 17, 1, 
    18, 1, 65535, 1, 12, 1, 17, 1, 65535, 1, 17, 3, 65535, 2, 12), array(
    13, 19, 1, 13, 1, 19), array(1, 19, 1, 20, 3, 19, 2, 20, 1, 19, 1, 20, 
    1, 19, 3, 20, 1, 14, 1, 20), array(), array(1, 2, 1, 65535, 3, 2, 1, 
    65535, 1, 21, 1, 2, 1, 65535, 1, 2, 3, 65535, 2, 21), array(), array(
    1, 2, 1, 65535, 3, 2, 1, 65535, 1, 22, 1, 2, 1, 65535, 1, 2, 3, 65535, 
    2, 22), array(), array(), array(1, 2, 1, 65535, 1, 2, 1, 23, 1, 2, 1, 
    65535, 1, 21, 1, 2, 1, 65535, 1, 2, 3, 65535, 2, 21), array(1, 2, 1, 
    65535, 2, 2, 1, 24, 1, 65535, 1, 22, 1, 2, 1, 65535, 1, 2, 3, 65535, 
    2, 22), array(1, 20, 1, 65535, 3, 20, 1, 65535, 1, 10, 1, 20, 1, 65535, 
    1, 20, 3, 65535, 2, 10), array(1, 20, 1, 65535, 3, 20, 1, 65535, 1, 
    12, 1, 20, 1, 65535, 1, 20, 3, 65535, 2, 12));

    $arr = array();
    $arr['eot'] = DFA::unpackRLE($eot);
    $arr['eof'] = DFA::unpackRLE($eof);
    $arr['min'] = DFA::unpackRLE($min, true);
    $arr['max'] = DFA::unpackRLE($max, true);
    $arr['accept'] = DFA::unpackRLE($accept);
    $arr['special'] = DFA::unpackRLE($special);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
    }
    return $arr;
}
$SubWikiParser_DFA14 = SubWikiParser_DFA14_static();

class SubWikiParser_DFA14 extends DFA {

    public function __construct($recognizer) {
        //global $SubWikiParser_DFA14;
        $DFA = SubWikiParser_DFA14_static();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 14;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "()+ loopback of 471:4: (~ ( T_SPACE ) )+";
    }
}
 



SubWikiParser::$FOLLOW_container_in_wikipage34 = new Set(array(5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 18));
SubWikiParser::$FOLLOW_nowiki_in_wikipage38 = new Set(array(5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 18));
SubWikiParser::$FOLLOW_EOF_in_wikipage43 = new Set(array(1));
SubWikiParser::$FOLLOW_heading_in_container58 = new Set(array(4));
SubWikiParser::$FOLLOW_lists_in_container62 = new Set(array(4));
SubWikiParser::$FOLLOW_paragraph_in_container66 = new Set(array(4));
SubWikiParser::$FOLLOW_container_end_in_container70 = new Set(array(1));
SubWikiParser::$FOLLOW_T_NEWLINE_in_container_end78 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_EOF_in_container_end84 = new Set(array(1));
SubWikiParser::$FOLLOW_text_paragraph_in_paragraph102 = new Set(array(1, 5, 6, 7, 8, 9, 10, 11, 13, 17, 18));
SubWikiParser::$FOLLOW_text_line_in_text_paragraph116 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_text_eol_in_text_paragraph120 = new Set(array(5, 6, 7, 8, 9, 10, 11, 13, 17, 18));
SubWikiParser::$FOLLOW_text_line_in_text_paragraph122 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_text_element_in_text_line135 = new Set(array(1, 5, 6, 7, 8, 9, 10, 11, 13, 17, 18));
SubWikiParser::$FOLLOW_T_NEWLINE_in_text_eol146 = new Set(array(1));
SubWikiParser::$FOLLOW_text_formatted_in_text_element156 = new Set(array(1));
SubWikiParser::$FOLLOW_text_unformatted_in_text_element161 = new Set(array(1));
SubWikiParser::$FOLLOW_cite_in_text_element168 = new Set(array(1));
SubWikiParser::$FOLLOW_image_in_text_element173 = new Set(array(1));
SubWikiParser::$FOLLOW_headingref_in_text_element178 = new Set(array(1));
SubWikiParser::$FOLLOW_list_ord_in_lists189 = new Set(array(1));
SubWikiParser::$FOLLOW_list_unord_in_lists194 = new Set(array(1));
SubWikiParser::$FOLLOW_T_NEWLINE_in_list_eol202 = new Set(array(1));
SubWikiParser::$FOLLOW_text_unformatted_in_list_item215 = new Set(array(1));
SubWikiParser::$FOLLOW_list_unord_element_in_list_unord239 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_list_eol_in_list_unord243 = new Set(array(5, 6));
SubWikiParser::$FOLLOW_list_unord_element_in_list_unord245 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_T_STAR_in_list_unord_element256 = new Set(array(10, 17, 18));
SubWikiParser::$FOLLOW_list_item_in_list_unord_element258 = new Set(array(1));
SubWikiParser::$FOLLOW_list_ord_element_in_list_ord280 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_list_eol_in_list_ord284 = new Set(array(6));
SubWikiParser::$FOLLOW_list_ord_element_in_list_ord286 = new Set(array(1, 4));
SubWikiParser::$FOLLOW_T_POUND_in_list_ord_element297 = new Set(array(10, 17, 18));
SubWikiParser::$FOLLOW_list_item_in_list_ord_element299 = new Set(array(1));
SubWikiParser::$FOLLOW_markup_bold_in_text_formatted310 = new Set(array(10, 17, 18));
SubWikiParser::$FOLLOW_bold_content_in_text_formatted312 = new Set(array(7));
SubWikiParser::$FOLLOW_markup_bold_in_text_formatted316 = new Set(array(1));
SubWikiParser::$FOLLOW_markup_italic_in_text_formatted323 = new Set(array(10, 17, 18));
SubWikiParser::$FOLLOW_italic_content_in_text_formatted325 = new Set(array(7, 8));
SubWikiParser::$FOLLOW_markup_italic_in_text_formatted329 = new Set(array(1));
SubWikiParser::$FOLLOW_T_BOLD_in_markup_bold339 = new Set(array(1));
SubWikiParser::$FOLLOW_T_ITALIC_in_markup_italic347 = new Set(array(1));
SubWikiParser::$FOLLOW_text_unformatted_in_bold_content356 = new Set(array(1));
SubWikiParser::$FOLLOW_text_unformatted_in_italic_content364 = new Set(array(1));
SubWikiParser::$FOLLOW_T_EQUAL_in_heading375 = new Set(array(9, 10, 17, 18));
SubWikiParser::$FOLLOW_heading_content_in_heading377 = new Set(array(9));
SubWikiParser::$FOLLOW_T_EQUAL_in_heading379 = new Set(array(1));
SubWikiParser::$FOLLOW_T_EQUAL_in_heading_content389 = new Set(array(9, 10, 17, 18));
SubWikiParser::$FOLLOW_heading_content_in_heading_content395 = new Set(array(9));
SubWikiParser::$FOLLOW_T_EQUAL_in_heading_content397 = new Set(array(1));
SubWikiParser::$FOLLOW_text_unformatted_in_heading_content402 = new Set(array(1));
SubWikiParser::$FOLLOW_T_POUND_in_headingref415 = new Set(array(4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18));
SubWikiParser::$FOLLOW_headingref_content_in_headingref417 = new Set(array(1));
SubWikiParser::$FOLLOW_set_in_headingref_content429 = new Set(array(1, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18));
SubWikiParser::$FOLLOW_set_in_text_unformatted446 = new Set(array(1, 10, 17, 18));
SubWikiParser::$FOLLOW_T_CITE_OPEN_in_cite515 = new Set(array(17));
SubWikiParser::$FOLLOW_cite_content_in_cite517 = new Set(array(12));
SubWikiParser::$FOLLOW_T_CITE_CLOSE_in_cite521 = new Set(array(1));
SubWikiParser::$FOLLOW_identifier_in_cite_content531 = new Set(array(1));
SubWikiParser::$FOLLOW_T_IMAGE_OPEN_in_image542 = new Set(array(17));
SubWikiParser::$FOLLOW_image_content_in_image544 = new Set(array(14));
SubWikiParser::$FOLLOW_T_IMAGE_CLOSE_in_image548 = new Set(array(1));
SubWikiParser::$FOLLOW_identifier_in_image_content558 = new Set(array(1));
SubWikiParser::$FOLLOW_T_CHAR_in_identifier571 = new Set(array(1, 17));
SubWikiParser::$FOLLOW_T_NOWIKI_OPEN_in_nowiki585 = new Set(array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18));
SubWikiParser::$FOLLOW_nowiki_content_in_nowiki587 = new Set(array(16));
SubWikiParser::$FOLLOW_T_NOWIKI_CLOSE_in_nowiki589 = new Set(array(1));
SubWikiParser::$FOLLOW_set_in_nowiki_content597 = new Set(array(1, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18));

?>