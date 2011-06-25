grammar SubWiki;

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

T_CITE_OPEN  : '[[';
T_CITE_CLOSE : ']]';

T_IMAGE_OPEN  : '{{';
T_IMAGE_CLOSE : '}}';

T_NOWIKI_OPEN  : '{{{';
T_NOWIKI_CLOSE : '}}}';

T_IDENTIFIER : ('a'..'z')+;