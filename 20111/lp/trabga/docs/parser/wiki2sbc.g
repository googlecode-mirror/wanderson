grammar wiki2sbc;

wikitext
	: paragraph+ EOF;

paragraph
	: markup+ T_EOL;

markup
	: bold
	| italic
	| unformatted;

bold
	: T_BOLD bold_content T_BOLD;

bold_content
	: text;

italic
	: T_ITALIC italic_content T_ITALIC;

italic_content
	: text;

unformatted
	: text;

text
	: (T_WORD|T_BLANK)+;

T_BOLD: '**';
T_ITALIC: '//';

T_WORD: ('a'..'z')+;
T_EOL: '\n';

T_BLANK: (' ')+ {$channel = HIDDEN;};