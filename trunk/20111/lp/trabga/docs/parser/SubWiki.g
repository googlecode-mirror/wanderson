grammar SubWiki;

options {
	language = Php;
}

@members {
/**
 * Erros Encontrados
 * @var array
 */
protected \$_errors = array();

/**
 * Conteúdo
 * @var string
 */
protected \$_content = '';

/**
 * Profundidade de Seção
 * @var int
 */
protected \$_sectionLevel = 0;

/**
 * Profundidade de Lista
 * @var int
 */
protected \$_listLevel = 0;

/**
 * Conjunto de Imagens Utilizadas
 * @var array
 */
protected \$_images = array();

/**
 * Últimas Imagens Utilizadas no Parágrafo
 * @var array
 */
protected \$_imagesLast = array();

/**
 * Informações de Imagens
 * @var array
 */
protected \$_imagesInfo = array();

/**
 * Conjunto de Citações Utilizadas
 * @var array
 */
protected \$_cites = array();

/**
 * Informações de Citações
 * @var array
 */
protected \$_citesInfo = array();

/**
 * Filtro Slugger
 * @var Hazel_Filter_Slugger
 */
protected \$_slugger = null;

/**
 * Filtro de CamerCase para Slugger
 * @var Zend_Filter_Word_CamelCaseToSeparator
 */
protected \$_camelFilter = null;

/**
 * Sobrescrita para Manipulação de Erros
 * @param string \$message Mensagem de Erro
 * @return void
 */
public function emitErrorMessage(\$message) {
	\$this->_errors[] = \$message;
}

/**
 * Sobrescrita para Reinicialização de Erros e Armazenamentos
 * @return void
 */
public function reset() {
	parent::reset();
	\$this->_errors = array();
	\$this->_images = array();
	\$this->_cites  = array();
}

/**
 * Adiciona ao Final do Conteúdo
 * @param \$content Conteúdo para Anexo
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
public function append(\$content) {
	\$this->_content .= \$content;
	return \$this;
}

/**
 * Renderização Final
 * @return string Conteúdo Solicitado
 */
public function render() {
	return \$this->_content;
}

/**
 * Construção de Seção
 * @param \$content Conteúdo do Título de Seção
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _section(\$content) {
	// Inicialização
	\$content = trim(\$content);
	// Construção da Seção
	\$level  = \$this->_getSectionLevel();
	\$sub    = str_repeat('sub', (int) \$level);
	\$result = '\\' . \$sub . 'section{' . \$content . '}' . PHP_EOL;
	\$this->append(\$result);
	// Criação da Etiqueta de Referência
	\$filter = \$this->getSlugger();
	\$slug   = \$filter->filter(\$content);
	\$result = sprintf('\\label{sec:\%s}', \$slug);
	\$this->append(\$result);
	return \$this;
}

/**
 * Renderização de Referência Cruzada para Seções
 * @param string \$content Conteúdo para Renderização
 * @return string Valor Traduzido para Referência Cruzada
 */
protected function _sectionReference(\$content) {
	\$filter  = \$this->getCamelFilter();
	\$slugger = \$this->getSlugger();
	\$content = \$filter->filter(\$content);
	\$content = \$slugger->filter(\$content);
	\$result  = sprintf('\\ref{sec:\%s}', \$content);
	\$this->append(\$result);
	return \$this;
}

/**
 * Nivelamento de Seção
 * @param \$modifier Modificador
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _addSectionLevel(\$modifier) {
	\$this->_sectionLevel += (int) \$modifier;
	return \$this;
}

/**
 * Configura o Nivelamento de Seção
 * @param \$level Valor para Configuração
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _setSectionLevel(\$level) {
	\$this->_sectionLevel = (int) \$level;
	return \$this;
}

/**
 * Informa o Nivelamento de Seção
 * @return int Valor do Nível Atual
 */
protected function _getSectionLevel() {
	return \$this->_sectionLevel;
}

/**
 * Inclui uma Imagem para Utilização
 * @param \$content Identificador da Imagem
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _image(\$content) {
	\$content = trim(\$content);
	// Imagem já inserida no documento?
	if (!in_array(\$content, \$this->_images)) {
		\$this->_imagesLast[] = \$content;
	}
	// Inclui Referência Cruzada
	\$result = '\\ref{fig:' . \$content . '}';
	\$this->append(\$result);
	return \$this;
}

/**
 * Adiciona no Documento as Últimas Imagens Inseridas
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _appendImagesLast() {
	// Seleciona as Últimas Imagens Inseridas
	foreach (\$this->_imagesLast as \$identifier) {
		\$result = \$this->_renderImage(\$identifier);
		if (\$result !== false) {
			\$this->append("\n\n"); // Duplo Espaçamento
			\$this->append(\$result);
		}
		// Confirmar Inserção da Imagem
		\$this->_images[] = \$identifier;
	}
	// Limpa as Últimas Imagens
	\$this->_imagesLast = array();
}

/**
 * Renderiza uma Imagem pelo Identificador
 * @param \$identifier Identificador da Imagem
 * @return string Conteúdo Resultante da Renderização
 */
protected function _renderImage(\$identifier) {
	// Imagem Registrada nas Informações?
	if (!array_key_exists(\$identifier, \$this->_imagesInfo)) {
		\$this->emitErrorMessage("Invalid Image: '\$identifier'");
		return false;
	}
	// Informações da Imagem
	\$filename = \$this->_imagesInfo[\$identifier]['filename'];
	\$caption  = \$this->_imagesInfo[\$identifier]['caption'];
	// Montagem da Renderização
	\$result = \$this->_environment('figure','begin') . PHP_EOL;
	\$result.= "\t\\centering{}\n";
	\$result.= sprintf("\t\\includegraphics[\\textwidth]{\%s}\n", \$filename);
	\$result.= sprintf("\t\\caption{\%s}\n", \$caption);
	\$result.= sprintf("\t\\label{fig:\%s}\n", \$identifier);
	\$result.= \$this->_environment('figure','end');
	// Resultado do Processamento
	return \$result;
}

/**
 * Inclui uma Citação para Utilização
 * @param \$content Identificador da Citação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _cite(\$content) {
	\$content = trim(\$content);
	if (!in_array(\$content, \$this->_citesInfo)) {
		\$this->emitErrorMessage("Invalid Citation: '\$content'");
	} else {
		\$this->_cites[] = \$content;
	}
	\$result = '\\cite{' . \$content . '}';
	\$this->append(\$result);
	return \$this;
}

/**
 * Formatação em Negrito
 * @param \$content Conteúdo para Formatação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _bold(\$content) {
	\$result = '\\textbf{' . \$content . '}';
	\$this->append(\$result);
	return \$this;
}

/**
 * Formatação em Itálico
 * @param \$content Conteúdo para Formatação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _italic(\$content) {
	\$result = '\\textit{' . \$content . '}';
	\$this->append(\$result);
	return \$this;
}

/**
 * Item de Listagem
 * @param \$content Conteúdo do Item
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _listItem(\$content) {
	\$content = trim(\$content); 
	\$level   = \$this->_getListLevel();
	\$ident   = str_repeat("\t", \$level);
	\$result  = \$ident . '\item ' . \$content;
	\$this->append(\$result);
	return \$this;
}

/**
 * Nivelamento de Listas
 * @param \$modifier Modificador
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _addListLevel(\$modifier) {
	\$this->_listLevel += (int) \$modifier;
	return \$this;
}

/**
 * Configura o Nivelamento de Lista
 * @param \$level Valor para Configuração
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _setListLevel(\$level) {
	\$this->_listLevel = (int) \$level;
	return \$this;
}

/**
 * Informa o Nivelamento de Lista
 * @return int Valor Solicitado
 */
protected function _getListLevel() {
	return \$this->_listLevel;
}

/**
 * Montagem de Ambiente Configurável
 * @param \$type     Tipo de Ambiente
 * @param \$location Localização da Instrução
 * @return string Resultado Solicitado
 */
protected function _environment(\$type, \$location) {
	\$result = sprintf('\\\%s{\%s}', \$location, \$type);
	return \$result;
}

/**
 * Monta um Ambiente de Lista
 * @param \$type     enumerate|itemize
 * @param \$location begin|end
 * @return SubWikiLexer Próprio Objeto para Encadeamento
 */
protected function _list(\$type, \$location) {
	// Menor Identação ao Final
	if (\$location == 'end') {
			\$this->_addListLevel(-1);
	}
	// Atualização da Identação
	\$level  = \$this->_getListLevel();
	// Maior Identação no Início
	if (\$location == 'begin') {
		\$this->_addListLevel(1);
	}
	// Construção da Saída
	\$ident  = str_repeat("\t", \$level);
	\$env    = \$this->_environment(\$type, \$location);
	\$result = \$ident . \$env;
	\$this->append(\$result);
	return \$this;
}

/**
 * Adiciona Informações sobre Imagens
 * @param \$identifier Identificador da Imagem
 * @param \$filename   Nome do Arquivo para Utilização
 * @param \$caption    Legenda da Imagem
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
public function addImageInfo(\$identifier, \$filename, \$caption) {
	\$this->_imagesInfo[\$identifier] = array(
		'filename' => \$filename,
		'caption'  => \$caption,
	);
	return \$this;
}

/**
 * Adiciona Informações sobre Citações
 * @param string \$identifier Identificador da Citação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
public function addCiteInfo(\$identifier) {
	\$this->_citesInfo[] = \$identifier;
	return \$this;
}

/**
 * Configura o Filtro de Slug
 * @param Hazel_Filter_Slugger \$slugger Elemento para Configuração
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
public function setSlugger(Hazel_Filter_Slugger \$slugger) {
	\$this->_slugger = \$slugger;
	return \$this;
}

/**
 * Informa o Filtro de Slug
 * @return Hazel_Filter_Slugger Elemento Solicitado
 */
public function getSlugger() {
	if (\$this->_slugger === null) {
		\$slugger = new Hazel_Filter_Slugger();
		\$this->setSlugger(\$slugger);
	}
	return \$this->_slugger;
}

/**
 * Configura o Filtro de CamelCase
 * @param Zend_Filter_Word_CamelCaseToSeparator \$filter Elemento para Configuração
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
public function setCamelFilter(Zend_Filter_Word_CamelCaseToSeparator \$filter) {
	\$this->_camelFilter = \$filter;
	return \$this;
}

/**
 * Informa o Filtro de CamelCase
 * @return Zend_Filter_Word_CamelCaseToSeparator Elemento Solicitado
 */
public function getCamelFilter() {
	if (\$this->_camelFilter === null) {
		\$filter = new Zend_Filter_Word_CamelCaseToSeparator();
		\$this->setCamelFilter(\$filter);
	}
	return \$this->_camelFilter;
}

/**
 * Informa os Identificadores de Imagens Utilizadas no Documento
 * @return array Conjunto de Valores Solicitados
 */
public function getImages() {
	return \$this->_images;
}

/**
 * Informa os Identificadores de Citações Utilizadas no Documento
 * @return array Conjunto de Valores Solicitados
 */
public function getCitations() {
	return \$this->_cites;
}

/**
 * Informa os Erros Encontrados
 * @return array Valores Solicitados
 */
public function getErrors() {
	return \$this->_errors;
}

}

// Página ----------------------------------------------------------------------

wikipage
	: ( container | nowiki )+ EOF;
container
@after { \$this->append("\n\n"); }
	: ( heading | lists | paragraph ) container_end;
container_end
	: T_NEWLINE+
	| EOF;

// Parágrafo -------------------------------------------------------------------

paragraph
@after { \$this->_appendImagesLast(); }
	: ( text_paragraph )+;

// Parágrafo de Texto ----------------------------------------------------------

text_paragraph
	: text_line ( text_eol text_line )*;
text_line
	: ( text_element )+;
text_eol
	: T_NEWLINE { \$this->append(' '); };
text_element
	: text_formatted
	| text_unformatted { \$this->append($text_unformatted.text); }
	| cite
	| image
	| headingref;

// Listas ----------------------------------------------------------------------

lists
	: list_ord
	| list_unord;
list_eol
	: T_NEWLINE;
list_item
@after { \$this->append("\n"); }
	: text_unformatted { \$this->_listItem($text_unformatted.text); };

// Lista não Numerada ----------------------------------------------------------

list_unord
@init  { \$this->_list('itemize', 'begin'); \$this->append("\n"); }
@after { \$this->_list('itemize', 'end'); }
	: list_unord_element ( list_eol list_unord_element )*;
list_unord_element
	: T_STAR list_item;

// Lista Numerada --------------------------------------------------------------

list_ord
@init  { \$this->_list('enumerate', 'begin'); \$this->append("\n"); }
@after { \$this->_list('enumerate', 'end'); }
	: list_ord_element ( list_eol list_ord_element )*;
list_ord_element
	: T_POUND list_item;

// Negrito e Itálico -----------------------------------------------------------

text_formatted
	: markup_bold bold_content
		markup_bold { \$this->_bold($bold_content.text); }
	| markup_italic italic_content
		markup_italic { \$this->_italic($italic_content.text); };
markup_bold
	: T_BOLD;
markup_italic
	: T_ITALIC;

bold_content
	: text_unformatted;
italic_content
	: text_unformatted;

// Seção -----------------------------------------------------------------------

heading
	: T_EQUAL heading_content T_EQUAL { \$this->_setSectionLevel(0); };
heading_content
	: T_EQUAL { \$this->_addSectionLevel(1); }
		heading_content T_EQUAL
	| text_unformatted { \$this->_section($text_unformatted.text); };

// Referência Cruzada para Seções ----------------------------------------------

headingref
	: T_POUND headingref_content
		{ \$this->_sectionReference($headingref_content.text); };
headingref_content
	: ~( T_SPACE )+;

// Texto não Formatado ---------------------------------------------------------

text_unformatted
	: ~( T_NEWLINE | T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC
		| T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE
		| T_NOWIKI_OPEN | T_NOWIKI_CLOSE | EOF )+;

// Referências Bibliográficas --------------------------------------------------

cite
	: T_CITE_OPEN cite_content
		T_CITE_CLOSE { \$this->_cite($cite_content.text); };
cite_content
	: identifier;

// Imagem ----------------------------------------------------------------------

image
	: T_IMAGE_OPEN image_content
		T_IMAGE_CLOSE { \$this->_image($image_content.text); };
image_content
	: identifier;

// Identificador ---------------------------------------------------------------

identifier
	: ( T_CHAR )+;

// Texto sem Processamento -----------------------------------------------------

nowiki
	: T_NOWIKI_OPEN nowiki_content T_NOWIKI_CLOSE;
nowiki_content
	: ~( T_NOWIKI_CLOSE )+;

// Análise Léxica --------------------------------------------------------------

T_SPACE : ' ';
T_NEWLINE : '\r'?'\n';

T_EQUAL : '=';
T_POUND : '#';
T_STAR  : '*';

T_BOLD   : '**';
T_ITALIC : '//';

T_CITE_OPEN  : '[[';
T_CITE_CLOSE : ']]';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_CHAR : 'a'..'z';

T_OTHER : . ;
