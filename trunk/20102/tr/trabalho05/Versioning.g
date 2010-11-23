grammar Versioning;

/**
 * CLASS DEFINITION -----------------------------------------------------------
 */

classdef
	: visibility T_CLASS T_IDENTIFIER T_OSB classbody T_CSB
	;

classbody
	: (attributedef|constructordef|methoddef)*
	;

/**
 * ATTRIBUTE DEFINITION -------------------------------------------------------
 */

attributedef
	: visibility type declaration T_SEMICOLON
	;

/**
 * CONSTRUCTOR DEFINITION -----------------------------------------------------
 */

constructordef
	: visibility T_IDENTIFIER T_OPB parameter T_CPB body
	;

/**
 * METHOD DEFINITION ----------------------------------------------------------
 */

visibility
	: T_PUBLIC
	| T_PRIVATE
	| T_PROTECTED
	;

type
	: T_STATIC
	|
	;

methoddef
	: visibility type T_IDENTIFIER T_IDENTIFIER T_OPB parameter T_CPB body
	;

parameter
	: declaration (T_COMMA declaration)*
	|
	;

/**
 * CREATE ---------------------------------------------------------------------
 */

create
	: T_NEW T_IDENTIFIER T_OPB argument T_CPB
	| T_NEW T_IDENTIFIER T_OVB T_NUMBER T_CVB
	;

/**
 * CALL -----------------------------------------------------------------------
 */

call
	: (variable|T_THIS) T_ACCESS T_IDENTIFIER T_OPB argument T_CPB
	;

argument
	: element (T_COMMA element)*
	|
	;

returndef
	: T_RETURN element
	;

/**
 * LOOPING --------------------------------------------------------------------
 */

looping
	: T_WHILE T_OPB operation T_CPB body
	;

/**
 * CONDITIONAL ----------------------------------------------------------------
 */

conditional
	: T_IF T_OPB operation T_CPB body
	;

/**
 * STATEMENT ------------------------------------------------------------------
 */

body
	: T_OSB statement+ T_CSB
	;

statement
	: assignment T_SEMICOLON
	| arithmetic T_SEMICOLON
	| conditional
	| looping
	| call T_SEMICOLON
	| create T_SEMICOLON
	| declaration T_SEMICOLON
	| returndef T_SEMICOLON
	;

/**
 * ASSIGNMENT -----------------------------------------------------------------
 */

assignment
	: variable T_ASSIGN arithmetic
	| attribute T_ASSIGN arithmetic
	| variable T_ASSIGN call
	| attribute T_ASSIGN call
	| variable T_ASSIGN create
	| attribute T_ASSIGN create
	;

declaration
	: T_IDENTIFIER T_IDENTIFIER (T_OVB T_CVB)?
	;

/**
 * OPERATION ------------------------------------------------------------------
 */

operation
	: arithmetic T_EQ arithmetic
	| arithmetic T_NE arithmetic
	| arithmetic T_LT arithmetic
	| arithmetic T_GT arithmetic
	| arithmetic T_LE arithmetic
	| arithmetic T_GE arithmetic
	;

/**
 * ARITHMETIC -----------------------------------------------------------------
 */

arithmetic
	: term ((T_ADD|T_SUB) term)*
	;

term
	: element ((T_MUL|T_DIV) element)*
	;

/**
 * ELEMENT --------------------------------------------------------------------
 */

element
	: constant
	| attribute
	| variable
	;

constant
	: T_NUMBER
	;

attribute
	: T_THIS T_ACCESS T_IDENTIFIER
	;

variable
	: T_IDENTIFIER
	;

/**
 * Lexer ----------------------------------------------------------------------
 */

fragment T_DIGIT: '0'..'9';
fragment T_CHAR: 'a'..'z'|'A'..'Z';

T_OSB: '{'; // Open Scope Bracket
T_CSB: '}'; // Close Scope Bracket
T_OPB: '('; // Open Parameter Bracket
T_CPB: ')'; // Close Parameter Bracket
T_OVB: '['; // Open Vector Bracket
T_CVB: ']'; // Close Vector Bracket

T_SEMICOLON: ';';
T_COMMA: ',';

T_ADD: '+';
T_SUB: '-';
T_MUL: '*';
T_DIV: '/';
T_ACCESS: '.';
T_ASSIGN: '=';

T_EQ: '==';
T_NE: '!=';
T_LT: '<';
T_GT: '>';
T_LE: '<=';
T_GE: '>=';

T_IF: 'if';
T_ELSE: 'else';
T_THIS: 'this';
T_WHILE: 'while';
T_NEW: 'new';

T_PUBLIC: 'public';
T_PROTECTED: 'protected';
T_PRIVATE: 'private';
T_STATIC: 'static';
T_CLASS: 'class';
T_RETURN: 'return';

T_NUMBER: T_DIGIT+;
T_IDENTIFIER: T_CHAR (T_CHAR|T_DIGIT)*;

T_WHITESPACE: ('\n'|'\r'|'\t'|' ')+ { skip(); };