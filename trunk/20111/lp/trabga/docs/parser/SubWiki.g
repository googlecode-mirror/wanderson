grammar SubWiki;

// Listas ----------------------------------------------------------------------

list
	: list_ord
	| list_unord;
list_eol
	: T_NEWLINE;

// Lista não Numerada ----------------------------------------------------------

list_unord
	: list_unord_element ( list_eol list_unord_element )*;
list_unord_element
	: T_STAR text_unformatted;

// Lista Numerada --------------------------------------------------------------

list_ord
	: list_ord_element ( list_eol list_ord_element )*;
list_ord_element
	: T_POUND text_unformatted;

// Negrito e Itálico -----------------------------------------------------------

text_formatted
	: markup_bold   bold_content   markup_bold
	| markup_italic italic_content markup_italic;
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
	: T_EQUAL heading_content T_EQUAL;
heading_content
	: T_EQUAL heading_content T_EQUAL
	| text_unformatted;

// Texto não Formatado ---------------------------------------------------------

text_unformatted
	: ~( T_STAR | T_EQUAL | T_POUND | T_BOLD | T_ITALIC | T_CITE_OPEN
		| T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN
		| T_NOWIKI_CLOSE )+;

// Referências Bibliográficas --------------------------------------------------

cite
	: T_CITE_OPEN cite_content T_CITE_CLOSE;
cite_content
	: identifier;

// Imagem ----------------------------------------------------------------------

image
	: T_IMAGE_OPEN image_content T_IMAGE_CLOSE;
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
