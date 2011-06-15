grammar sistema;

/**
 * Gramática para Sublinguagem Wiki Creole
 * @author Wanderson Henrique Camargo Rosa
 */

// Elemento de Lista e Marcadores ---------------------------------------------

list_element
	: T_IDENTIFIER; // @todo Melhorar Captura

// Lista Numerada -------------------------------------------------------------

list_ord
	: ( list_ord_element T_EOL )+;
markup_list_ord
	: T_POUND;
list_ord_element
	: markup_list_ord list_element;

// Lista Não Numerada ---------------------------------------------------------

list_unord
	: ( list_unord_element T_EOL )+;
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
	: ~( T_BOLD | T_ITALIC | T_IMAGE_OPEN | T_LINK_OPEN )+;

markup_bold
	: T_BOLD;
markup_italic
	: T_ITALIC;

// Seção do Documento ---------------------------------------------------------

heading
	: markup_heading heading_content ( markup_heading )? ( blanks )?;
heading_content
	: markup_heading heading_content markup_heading
	| ~( T_EQUAL )+; // @todo Capturar Elementos Corretos
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

blanks
	: T_SPACE+;

/**
 * Analisador Léxico
 * @author Wanderson Henrique Camargo Rosa
 */

// Marcação de Texto ----------------------------------------------------------

T_IDENTIFIER : ('a'..'z')+;

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';
T_LINK_OPEN   : '[[';
T_LINK_CLOSE  : ']]';

T_EOL    : '\n';

T_BOLD   : '**';
T_ITALIC : '//';
T_EQUAL  : '=';
T_POUND  : '#';
T_STAR   : '*';
T_SPACE  : ' ';
T_OTHER  : .;