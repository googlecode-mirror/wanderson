grammar subwiki;

options{
    language = Php;
}

@members {
/**
 * Conteúdo Renderizado
 * @var string
 */
protected \$_content = '';
/**
 * Referências Bibliográficas
 * @var array
 */
protected \$_references = array();
/**
 * Imagens
 * @var array
 */
protected \$_images = array();
/**
 * Inclusão de Conteúdo Reconhecido
 * @param string \$content Valor para Inclusão
 * @return subwikiParser Próprio Objeto para Encadeamento
 */
public function attach(\$content) {
	\$this->_content .= \$content;
	return \$this;
}
/**
 * Requisição do Conteúdo Capturado
 * @return string Valor Solicitado
 */
public function getContent() {
	return \$this->_content;
}
/**
 * Inclui uma Nova Referência Bibliográfica Capturada
 * @param string \$identifier Identificador
 * @return subwikiParser Próprio Objeto para Encadeamento
 */
public function addReference(\$identifier) {
	if (!in_array(\$identifier, \$this->_references)) {
		\$this->_references[] = \$identifier;
	}
	return \$this;
}
/**
 * Informa as Referências Utilizadas
 * @return string Conteúdo Solicitado
 */
public function getReferences() {
	return \$this->_references;
}
/**
 * Inclui uma Nova Imagem Capturada
 * @param string \$identifier Identificador
 * @return subwikiParser Próprio Objeto para Encadeamento
 */
public function addImage(\$identifier) {
	if (!in_array(\$identifier, \$this->_images)) {
		\$this->_images[] = \$images;
	}
	return \$this;
}
/**
 * Informa as Imagens Utilizadas
 * @return array Conteúdo Solicitado
 */
public function getImages() {
	return \$this->_images;
}
}

// Página ---------------------------------------------------------------------

wikipage
	: ( paragraphs )+ EOF;

// Parágrafo ------------------------------------------------------------------

paragraphs
	: ( heading | lists |paragraph ) paragraph_end;

paragraph
	: ( text_paragraph )+ ;
paragraph_end
	: T_NEWLINE+
	| EOF;

// Parágrafo de Texto ---------------------------------------------------------

text_paragraph
	: text_line ( text_eol text_line )*;
text_line
	: ( text_element )+;
text_eol
	: T_NEWLINE;
text_element
	: text_formatted
	| text_unformatted
	| link
	| image;

// Listas ---------------------------------------------------------------------

lists
	: list_ord
	| list_unord;
list_eol
	: T_NEWLINE;

// Lista Não Numerada ---------------------------------------------------------

list_unord
	: list_unord_element ( list_eol list_unord_element )*;
list_unord_element
	: T_STAR ( list_ord_element | text_unformatted );

// Lista Numerada -------------------------------------------------------------

list_ord
	: list_ord_element ( list_eol list_ord_element)*;
list_ord_element
	: T_POUND ( list_unord_element | text_unformatted );

// Negrito e Itálico ----------------------------------------------------------

text_formatted
	: markup_bold text_bold_content markup_bold
	| markup_italic text_italic_content markup_italic;

text_bold_content
	: text_unformatted;
markup_bold
	: T_BOLD;

text_italic_content
	: text_unformatted;
markup_italic
	: T_ITALIC;

// Texto não Formatado --------------------------------------------------------

text_unformatted
	: ~( T_LINK_OPEN | T_IMAGE_OPEN | T_BOLD | T_ITALIC
		| T_EQUAL | T_NEWLINE )+ ;


// Seção do Documento ---------------------------------------------------------

heading
	: markup_heading heading_content markup_heading;
heading_content
	: markup_heading heading_content markup_heading
	| text_unformatted;
markup_heading
	: T_EQUAL;

// Imagem ---------------------------------------------------------------------

image
	: markup_image_open
		image_identifier markup_image_close;
image_identifier
	: T_WORD;
markup_image_open
	: T_IMAGE_OPEN;
markup_image_close
	: T_IMAGE_CLOSE;

// Referências Bibliográficas --------------------------------------------------

link
	: markup_link_open
		link_content { \$this->addReference($link_content.text); }
		markup_link_close;
link_content
	: T_WORD;
markup_link_open
	: T_LINK_OPEN;
markup_link_close
	: T_LINK_CLOSE;


// Análise Léxica --------------------------------------------------------------

T_WORD         : ('a'..'z')+;
T_LINK_OPEN    : '[[';
T_LINK_CLOSE   : ']]';
T_IMAGE_OPEN   : '{{';
T_IMAGE_CLOSE  : '}}';
T_BOLD         : '**';
T_ITALIC       : '//';
T_SPACE        : ' ';
T_EQUAL        : '=';
T_STAR         : '*';
T_POUND        : '#';
T_NEWLINE      : '\n';