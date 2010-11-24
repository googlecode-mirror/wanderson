grammar Versioning;

options {
	output = AST;
}

tokens {
	T_CLASSDEF;
	T_CLASSBODY;
	T_ATTRIBUTEDEF;
	T_CONSTRUCTORDEF;
	T_METHODDEF;
	T_VISIBILITY;
	T_PARAMETER;
	T_ARGUMENT;
	T_CREATE;
	T_CALL;
	T_LOOPING;
	T_CONDITIONAL;
	T_BODY;
	T_STATEMENT;
	T_ASSIGNMENT;
	T_DECLARATION;
	T_CONSTANT;
	T_ATTRIBUTE;
	T_VARIABLE;
	T_NAME;
	T_TYPE;
	T_FROM;
}

/*
 * CLASS DEFINITION -----------------------------------------------------------
 */

classdef
	: visibility T_CLASS T_IDENTIFIER T_OSB classbody* T_CSB
		-> ^(T_CLASSDEF ^(T_NAME T_IDENTIFIER) visibility ^(T_CLASSBODY classbody*))
	;

classbody
	: attributedef
	| constructordef
	| methoddef
	;

/*
 * ATTRIBUTE DEFINITION -------------------------------------------------------
 */

attributedef
	: visibility type declaration T_SEMICOLON
		-> ^(T_ATTRIBUTEDEF declaration visibility)
	;

/*
 * CONSTRUCTOR DEFINITION -----------------------------------------------------
 */

constructordef
	: visibility T_IDENTIFIER T_OPB parameter T_CPB body
		-> ^(T_CONSTRUCTORDEF ^(T_TYPE T_IDENTIFIER) visibility parameter body)
	;

/*
 * METHOD DEFINITION ----------------------------------------------------------
 */

visibility
	: T_PUBLIC
		-> ^(T_VISIBILITY T_PUBLIC)
	| T_PRIVATE
		-> ^(T_VISIBILITY T_PRIVATE)
	| T_PROTECTED
		-> ^(T_VISIBILITY T_PROTECTED)
	;

type
	: (T_STATIC)?
	;

/**
 * @todo Incluir na Árvore de Sintaxe o Tipo do Método
 */
methoddef
	: visibility type r=T_IDENTIFIER n=T_IDENTIFIER T_OPB parameter T_CPB body
		-> ^(T_METHODDEF ^(T_TYPE $r) ^(T_NAME $n) visibility parameter body)
	;

parameter
	: (declaration (T_COMMA declaration)*)?
		-> ^(T_PARAMETER declaration*)
	;

/*
 * CREATE ---------------------------------------------------------------------
 */

/**
 * @todo Produção para Criação de Instâncias de Vetores
 */
create
	: T_NEW T_IDENTIFIER T_OPB argument T_CPB
		-> ^(T_CREATE ^(T_TYPE T_IDENTIFIER) argument)
	;

/*
 * CALL -----------------------------------------------------------------------
 */

/**
 * @todo Produção para Chamada de Métodos de Outros Objetos
 */
call
	: T_THIS T_ACCESS T_IDENTIFIER T_OPB argument T_CPB
		-> ^(T_CALL ^(T_NAME T_IDENTIFIER) ^(T_FROM T_THIS) argument)
	;

argument
	: (element (T_COMMA element)*)?
		-> ^(T_ARGUMENT element*)
	;

returndef
	: T_RETURN element
		-> ^(T_RETURN element)
	;

/*
 * LOOPING --------------------------------------------------------------------
 */

looping
	: T_WHILE T_OPB operation T_CPB body
		-> ^(T_LOOPING operation body)
	;

/*
 * CONDITIONAL ----------------------------------------------------------------
 */

conditional
	: T_IF T_OPB operation T_CPB body
		-> ^(T_CONDITIONAL operation body)
	;

/*
 * STATEMENT ------------------------------------------------------------------
 */

body
	: T_OSB statement* T_CSB
		-> ^(T_BODY statement*)
	;

statement
	: assignment T_SEMICOLON
		-> ^(assignment)
	| arithmetic T_SEMICOLON
		-> ^(arithmetic)
	| conditional
		-> ^(conditional)
	| looping
		-> ^(looping)
	| call T_SEMICOLON
		-> ^(call)
	| create T_SEMICOLON
		-> ^(create)
	| declaration T_SEMICOLON
		-> ^(declaration)
	| returndef T_SEMICOLON
		-> ^(returndef)
	;

/*
 * ASSIGNMENT -----------------------------------------------------------------
 */

assignment
	: variable  T_ASSIGN arithmetic
		-> ^(T_ASSIGNMENT variable arithmetic)
	| attribute T_ASSIGN arithmetic
		-> ^(T_ASSIGNMENT attribute arithmetic)
	| variable  T_ASSIGN call
		-> ^(T_ASSIGNMENT variable call)
	| attribute T_ASSIGN call
		-> ^(T_ASSIGNMENT attribute call)
	| variable  T_ASSIGN create
		-> ^(T_ASSIGNMENT variable create)
	| attribute T_ASSIGN create
		-> ^(T_ASSIGNMENT attribute create)
	;

/**
 * @todo Árvore de Sintaxe para Vetores
 */
declaration
	: t=T_IDENTIFIER n=T_IDENTIFIER (T_OVB T_CVB)?
		-> ^(T_DECLARATION ^(T_TYPE $t) ^(T_NAME $n))
	;

/*
 * OPERATION ------------------------------------------------------------------
 */

operation
	: arithmetic T_EQ^ arithmetic
	| arithmetic T_NE^ arithmetic
	| arithmetic T_LT^ arithmetic
	| arithmetic T_GT^ arithmetic
	| arithmetic T_LE^ arithmetic
	| arithmetic T_GE^ arithmetic
	;

/*
 * ARITHMETIC -----------------------------------------------------------------
 */

arithmetic
	: term ((T_ADD^|T_SUB^) term)*
	;

term
	: element ((T_MUL^|T_DIV^) element)*
	;

/*
 * ELEMENT --------------------------------------------------------------------
 */

element
	: constant
	| attribute
	| variable
	;

constant
	: T_NUMBER
		-> ^(T_CONSTANT T_NUMBER)
	;

attribute
	: T_THIS T_ACCESS T_IDENTIFIER
		-> ^(T_ATTRIBUTE T_IDENTIFIER)
	;

variable
	: T_IDENTIFIER
		-> ^(T_VARIABLE T_IDENTIFIER)
	;

/*
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
T_NULL: 'null';

T_NUMBER: T_DIGIT+;
T_IDENTIFIER: T_CHAR (T_CHAR|T_DIGIT)*;

T_WHITESPACE: ('\n'|'\r'|'\t'|' ')+ { skip(); };
