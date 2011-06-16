grammar teste;

/**
 * Sublinguagem de Wiki Creole
 * Baseado em Martin Junghans [JUNGHANS 2007]
 * @author Wanderson Henrique Camargo Rosa
 */

// Página ---------------------------------------------------------------------

wikipage
	: ( paragraphs )+ EOF;

// Parágrafo ------------------------------------------------------------------

paragraphs
	: ( heading | paragraph ) paragraph_end;

paragraph
	: ( text_paragraph )+ ;
paragraph_end
	: T_NEWLINE+
	| EOF;

// Parágrafo de Texto ---------------------------------------------------------

text_paragraph
	: text_first_line ( text_eol text_line )*;
text_first_line
	: text_line;
text_line
	: ( text_element )+;
text_eol
	: T_NEWLINE;
text_element
	: text_formatted
	| text_unformatted;

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
	: ~( T_NOWIKI_OPEN | T_IMAGE_OPEN | T_LINK_OPEN | T_BOLD | T_ITALIC
		| T_EQUAL | T_NEWLINE )+ ;

// Seção do Documento ---------------------------------------------------------

heading
	: markup_heading heading_content markup_heading;
heading_content
	: markup_heading heading_content markup_heading
	| text_unformatted;
markup_heading
	: T_EQUAL;

// Identificador --------------------------------------------------------------

identifier
	: T_LETTER;

// Imagem ---------------------------------------------------------------------

image
	: markup_image_open image_identifier markup_image_close;
image_identifier
	: identifier+;
markup_image_open
	: T_IMAGE_OPEN;
markup_image_close
	: T_IMAGE_CLOSE;

// Referência Bibliográfica ---------------------------------------------------

link
	: markup_link_open link_content markup_link_close;
link_content
	: identifier+;
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

// Tokens ---------------------------------------------------------------------

fragment T_CR : '\r';
fragment T_LF : '\n';

T_NEWLINE    : ( T_CR )? T_LF | T_CR;

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';
T_LINK_OPEN   : '[[';
T_LINK_CLOSE  : ']]';
T_BOLD        : '**';
T_ITALIC      : '//';

T_EQUAL  : '=';
T_TAB    : '\t';
T_LETTER : 'a'..'z';
T_SPACE  : ' ';
T_CHAR   : .;