grammar wiki2sbc;

wikitext
	: paragraph+ EOF;

paragraph
	: paragraph_content+ T_EOL;

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

T_WORD: ('a'..'z')+;
T_EOL: '\n';

T_BLANK: (' ')+ {$channel = HIDDEN;};