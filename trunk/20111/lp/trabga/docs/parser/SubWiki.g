grammar SubWiki;

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

// Texto Não Formatado ---------------------------------------------------------

text_unformatted
	: ~( T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN
		| T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE )+;

// Referências Bibliográficas --------------------------------------------------

cite
	: T_CITE_OPEN cite_content T_CITE_CLOSE;
cite_content
	: T_IDENTIFIER;

// Imagem ----------------------------------------------------------------------

image
	: T_IMAGE_OPEN image_content T_IMAGE_CLOSE;
image_content
	: T_IDENTIFIER;

// Texto não Formatado ---------------------------------------------------------

nowiki
	: T_NOWIKI_OPEN nowiki_content T_NOWIKI_CLOSE;
nowiki_content
	: ~( T_NOWIKI_CLOSE )+;

// Análise Léxica --------------------------------------------------------------

T_SPACE : ' '; // Não gera Token

T_EQUAL : '=';

T_BOLD   : '**';
T_ITALIC : '//';

T_CITE_OPEN  : '[[';
T_CITE_CLOSE : ']]';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_IDENTIFIER : ('a'..'z')+;