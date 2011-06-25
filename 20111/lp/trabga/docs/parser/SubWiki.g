grammar SubWiki;

options {
	language = Php;
}

@members {
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
 * Conjunto de Citações Utilizadas
 * @var array
 */
protected \$_cites = array();

/**
 * Adiciona ao Final do Conteúdo
 * @param \$content Conteúdo para Anexo
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _append(\$content, \$separator = '') {
	\$this->_content .= \$content . \$separator;
	return \$this;
}

/**
 * Renderização Final
 * @return string Conteúdo Solicitado
 */
protected function _render() {
	return \$this->_content;
}

/**
 * Construção de Seção
 * @param \$content Conteúdo do Título de Seção
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _section(\$content) {
	\$level  = \$this->_getSectionLevel();
	\$sub    = str_repeat('sub', (int) \$level);
	\$result = '\\' . \$sub . 'section{' . trim(\$content) . '}';
	\$this->_append(\$result, PHP_EOL);
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
	\$this->_images[] = \$content;
	\$result = '\\ref{fig:' . \$content . '}';
	\$this->_append(\$result);
	return \$this;
}

/**
 * Inclui uma Citação para Utilização
 * @param \$content Identificador da Citação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _cite(\$content) {
	\$content = trim(\$content);
	\$this->_cites[] = \$content;
	\$result = '\\cite{' . \$content . '}';
	\$this->_append(\$result);
	return \$this;
}

/**
 * Formatação em Negrito
 * @param \$content Conteúdo para Formatação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _bold(\$content) {
	\$result = '\\textbf{' . \$content . '}';
	\$this->_append(\$result);
	return \$this;
}

/**
 * Formatação em Itálico
 * @param \$content Conteúdo para Formatação
 * @return SubWikiParser Próprio Objeto para Encadeamento
 */
protected function _italic(\$content) {
	\$result = '\\textit{' . \$content . '}';
	\$this->_append(\$result);
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
	\$this->_append(\$result, PHP_EOL);
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
	\$this->_append(\$result, PHP_EOL);
	return \$this;
}

}

// Página ----------------------------------------------------------------------

wikipage
	: ( container | nowiki )+ EOF { echo \$this->_render(); };
container
	: ( heading | lists | paragraph ) container_end;
container_end
	: T_NEWLINE+
	| EOF;

// Parágrafo -------------------------------------------------------------------

paragraph
	: ( text_paragraph )+;

// Parágrafo de Texto ----------------------------------------------------------

text_paragraph
	: text_line ( text_eol text_line )*;
text_line
	: ( text_element )+;
text_eol
	: T_NEWLINE;
text_element
	: text_formatted
	| text_unformatted
	| cite
	| image;

// Listas ----------------------------------------------------------------------

lists
	: list_ord
	| list_unord;
list_eol
	: T_NEWLINE;
list_item
	: text_unformatted { \$this->_listItem($text_unformatted.text); };

// Lista não Numerada ----------------------------------------------------------

list_unord
@init  { \$this->_list('itemize', 'begin'); }
@after { \$this->_list('itemize', 'end'); }
	: list_unord_element ( list_eol list_unord_element )*;
list_unord_element
	: T_STAR list_item;

// Lista Numerada --------------------------------------------------------------

list_ord
@init  { \$this->_list('enumerate', 'begin'); }
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
T_NEWLINE : '\n';

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
