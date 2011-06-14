grammar wiki2sbc;

wiki
	: wikitext+ EOF;

wikitext
	: heading T_EOL (T_EOL)+
	| paragraph (T_EOL)+;

heading
	: T_HEADING heading_content T_HEADING;

heading_content
	: heading
	| unformatted;

paragraph
	: paragraph_content+;

paragraph_content
	: unformatted
	| bold
	| italic;

bold
	: T_BOLD bold_content+ T_BOLD;

bold_content
	: unformatted
	| T_ITALIC bold_content_italic + T_ITALIC;

bold_content_italic
	: unformatted;

italic
	: T_ITALIC italic_content+ T_ITALIC;

italic_content
	: unformatted
	| T_BOLD italic_content_bold+ T_BOLD;

italic_content_bold
	: unformatted;

unformatted
	: T_WORD;

T_BOLD: '**';
T_ITALIC: '//';

T_HEADING : '=';

T_WORD: ('a'..'z')+;
T_EOL: '\n';

T_BLANK: (' ')+ {$channel = HIDDEN;};