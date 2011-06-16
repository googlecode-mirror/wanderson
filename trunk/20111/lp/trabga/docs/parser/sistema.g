grammar sistema;

/**
 * Gramática para Sublinguagem Wiki Creole
 * Baseado em Martin Junghans [JUNGHANS 2007]
 * @author Wanderson Henrique Camargo Rosa
 */

// Texto Wiki -----------------------------------------------------------------

wikipage
	: paragraphs EOF;
paragraphs
	: ( paragraph )*;

// Parágrafo ------------------------------------------------------------------

paragraph
	: nowiki
	| ( heading | text_paragraph );
paragraph_separator
	: ( newline )+
	| EOF; 
text_paragraph
	: ( text_line )+;
text_line
	: ( text_element )+ text_lineseparator;
text_element
	: text_formatted_element
	| text_unformatted;
text_lineseparator
	: newline ( blanks )? 
	| EOF;

// Elemento de Lista e Marcadores ---------------------------------------------

list_element
	: text_line; // @todo Melhorar Captura

// Lista Numerada -------------------------------------------------------------

list_ord
	: ( list_ord_element )+;
markup_list_ord
	: T_POUND;
list_ord_element
	: markup_list_ord list_element;

// Lista Não Numerada ---------------------------------------------------------

list_unord
	: ( list_unord_element )+;
markup_list_unord
	: T_STAR;
list_unord_element
	: markup_list_unord list_element;

// Negrito e Itálico ----------------------------------------------------------

text_formatted_element
	: markup_bold text_bold_content markup_bold
	| markup_italic text_italic_content markup_italic;

text_bold_content
	: ( markup_italic text_bolditalic_content markup_italic
		| text_bold_formatted )+;

text_bold_formatted
	: text_unformatted; // @todo Verificar

text_italic_content
	: ( markup_bold text_bolditalic_content markup_bold
		| text_italic_formatted );

text_italic_formatted
	: text_unformatted; // @todo Verificar

text_bolditalic_content
	: text_unformatted;

text_unformatted 
	: ~( T_ITALIC | T_STAR | T_LINK_OPEN | T_IMAGE_OPEN
		| T_NOWIKI_OPEN | T_NEWLINE | T_EQUAL | EOF )+;

markup_bold
	: T_BOLD;
markup_italic
	: T_ITALIC;

// Seção do Documento ---------------------------------------------------------

heading
	: markup_heading heading_content ( markup_heading )? ( blanks )?;
heading_content
	: markup_heading heading_content markup_heading
	| ( text_unformatted )+; // @todo Capturar Elementos Corretos
markup_heading
	: T_EQUAL;

// Imagem ---------------------------------------------------------------------

image
	: markup_image_open image_identifier markup_image_close;
image_identifier
	: T_IDENTIFIER;
markup_image_open
	: T_IMAGE_OPEN;
markup_image_close
	: T_IMAGE_CLOSE;

// Referência Bibliográfica ---------------------------------------------------

link
	: markup_link_open link_content markup_link_close ( blanks )?;
link_content
	: T_IDENTIFIER;
markup_link_open
	: T_LINK_OPEN;
markup_link_close
	: T_LINK_CLOSE;

// Sem Formatação -------------------------------------------------------------

nowiki
	: markup_nowiki_open nowiki_content markup_nowiki_close;
nowiki_content
	: ~( T_NOWIKI_CLOSE )+;
markup_nowiki_open
	: T_NOWIKI_OPEN;
markup_nowiki_close
	: T_NOWIKI_CLOSE;

// Capturas -------------------------------------------------------------------

whitespaces
	: ( blanks | newline )+;
blanks
	: T_BLANKS;
newline
	: T_NEWLINE;

/**
 * Analisador Léxico
 * @author Wanderson Henrique Camargo Rosa
 */

// Marcação de Texto ----------------------------------------------------------

fragment T_SPACE     : ' ';
fragment T_CR        : '\r';
fragment T_LF        : '\n';
fragment T_TABULATOR : '\t';

T_BLANKS          : ( T_SPACE | T_TABULATOR )+;
T_NEWLINE         : ( T_CR )? T_LF | T_CR;

T_IDENTIFIER : ('a'..'z')+;

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';
T_LINK_OPEN   : '[[';
T_LINK_CLOSE  : ']]';

T_BOLD   : '**';
T_ITALIC : '//';
T_EQUAL  : '=';
T_POUND  : '#';
T_STAR   : '*';
T_OTHER  : .;
