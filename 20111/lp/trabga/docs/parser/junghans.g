grammar junghans;

wikipage
    : ( whitespaces )? paragraphs EOF;

paragraphs
    : ( paragraph )*;

paragraph
    : blanks paragraph_separator
    | ( blanks )? ( heading | text_paragraph ) ( paragraph_separator )?;

paragraph_separator
    : ( newline )+
    | EOF;

// -----------------------------------------------------------------------------

heading
    : heading_markup heading_content ( heading_markup )? ( blanks )?
        paragraph_separator;

heading_content
    : heading_markup heading_content ( heading_markup )?
    | ( ~( T_EQUAL | T_ESCAPE | T_NEWLINE | EOF ) | escaped )+;

escaped
    : T_ESCAPE T_STAR T_STAR
    | T_ESCAPE .;

heading_markup
    : T_EQUAL;

// -----------------------------------------------------------------------------

text_paragraph
    : ( text_line )+;

text_line
    : text_firstelement ( text_element )* text_lineseparator
    ;

text_element
	: onestar text_unformattedelement
	| text_unformattedelement onestar
	| text_formattedcontent;

text_firstelement
    : { input.LA(1) != T_STAR || 
        input.LA(1) == T_STAR && input.LA(2) == T_STAR }? text_formattedelement
    | text_first_unformattedelement;

text_first_unformattedelement
    : text_first_unformatted
    | text_first_inlineelement;

text_first_unformatted
    : ( ~( T_POUND | T_STAR | T_EQUAL | T_ITALIC | T_LINKOPEN | T_IMAGEOPEN |
        T_NOWIKIOPEN | T_ESCAPE | T_NEWLINE | EOF ) | escaped )+;

text_formattedelement
    : italic_markup text_italiccontent ( ( T_NEWLINE )? italic_markup )?
    | bold_markup text_boldcontent ( ( T_NEWLINE )? bold_markup)?;

bold_markup
    : T_STAR T_STAR;

italic_markup
    : T_ITALIC;

text_boldcontent
    : ( T_NEWLINE )? ( text_boldcontentpart )*
    | EOF;

text_boldcontentpart
    : italic_markup text_bolditaliccontent ( italic_markup )?
    | text_formattedcontent;

text_formattedcontent
    : onestar ( text_unformattedelement onestar ( text_linebreak )? )+;

text_unformattedelement
    : text_unformatted
    | text_inlineelement;

text_unformatted
    : ( ~( T_ITALIC | T_STAR | T_IMAGEOPEN | T_NOWIKIOPEN | T_ESCAPE | T_NEWLINE | EOF )
        | escaped )+;

text_inlineelement
    : text_first_inlineelement
    | nowiki_inline;

text_first_inlineelement
    : link
    | image;

text_linebreak
    : { input.LA(2) != T_DASH && input.LA(2) != T_POUND &&
        input.LA(2) != T_EQUAL && input.LA(2) != T_NEWLINE }?
        text_lineseparator;

text_lineseparator
    : newline ( blanks )?
    | EOF;

text_italiccontent
    : ( T_NEWLINE )? ( text_italiccontentpart )*;

text_italiccontentpart
    : bold_markup text_bolditaliccontent ( bold_markup )?
    | text_formattedcontent;

text_bolditaliccontent
	: ( T_NEWLINE )? ( text_formattedcontent )?
	| EOF;

// -----------------------------------------------------------------------------

link
    : link_open_markup link_identifier link_close_markup;

link_identifier
    : T_IDENTIFIER;

link_open_markup
    : T_LINKOPEN;

link_close_markup
    : T_LINKCLOSE;

// -----------------------------------------------------------------------------

image
    : image_open_markup image_identifier image_close_markup;

image_identifier
    : T_IDENTIFIER;

image_open_markup
    : T_IMAGEOPEN;

image_close_markup
    : T_IMAGECLOSE;

// -----------------------------------------------------------------------------

nowiki_inline
    : nowiki_open_markup ( ~( T_NOWIKICLOSE | T_NEWLINE | EOF ) )*
        nowiki_close_markup;

nowiki_open_markup
    : T_NOWIKIOPEN;

nowiki_close_markup
    : T_NOWIKICLOSE;

// -----------------------------------------------------------------------------

onestar
    : ( {input.LA(2) != T_STAR }? T_STAR? )
    | ;

whitespaces
    : ( blanks | newline)+;
blanks
    : T_BLANKS;
newline
    : T_NEWLINE;

T_NEWLINE : ( T_CR )? T_LF | T_CR;
T_BLANKS : ( T_SPACE | T_TABULATOR )+;

fragment T_SPACE : ' ';
fragment T_TABULATOR : '\t';
fragment T_CR : '\r';
fragment T_LF : '\n';

T_EQUAL: '=';
T_ESCAPE: '~';
T_STAR: '*';
T_POUND: '#';

T_ITALIC: '//';

T_IMAGEOPEN: '{{';
T_IMAGECLOSE: '}}';
T_LINKOPEN: '[[';
T_LINKCLOSE: ']]';

T_NOWIKIOPEN: '{{{';
T_NOWIKICLOSE: '}}}';

T_IDENTIFIER: ('a'..'z')+;
INSIGNIFICANT_CHAR : .;
