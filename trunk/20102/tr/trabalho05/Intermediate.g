tree grammar Intermediate;

options {
	output = AST;
	ASTLabelType = CommonTree;
	tokenVocab = Versioning;
}

classdef
	: ^(T_CLASSDEF ^(T_NAME T_IDENTIFIER) visibility ^(T_CLASSBODY classbody*))
	;

visibility
	: ^(T_VISIBILITY T_PUBLIC)
	| ^(T_VISIBILITY T_PRIVATE)
	| ^(T_VISIBILITY T_PROTECTED)
	;

classbody
	: attributedef
	| constructordef
	| methoddef
	;

attributedef
	: ^(T_ATTRIBUTEDEF declaration visibility)
	;

constructordef
	: ^(T_CONSTRUCTORDEF ^(T_TYPE T_IDENTIFIER) visibility parameter body)
	;

methoddef
	: ^(T_METHODDEF ^(T_TYPE T_IDENTIFIER) ^(T_NAME T_IDENTIFIER) visibility parameter body)
	;

declaration
	: ^(T_DECLARATION ^(T_TYPE T_IDENTIFIER) ^(T_NAME T_IDENTIFIER))
	;

parameter
	: ^(T_PARAMETER declaration*)
	;

body
	: ^(T_BODY statement*)
	;

statement
	: assignment
	| arithmetic
	| conditional
	| looping
	| call
	| create
	| declaration
	| returndef
	;

assignment
	: ^(T_ASSIGNMENT { System.out.println("<assignment>"); } variable arithmetic { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } attribute arithmetic { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } variable call { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } attribute call { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } variable create { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } attribute create { System.out.println("</assignment>"); })
	;

arithmetic
	: ^(T_ADD { System.out.println("<arithmetic type=\"add\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_SUB { System.out.println("<arithmetic type=\"sub\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_MUL { System.out.println("<arithmetic type=\"mul\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_DIV { System.out.println("<arithmetic type=\"div\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| element
	;

conditional
	: ^(T_CONDITIONAL operation body)
	;

looping
	: ^(T_LOOPING operation body)
	;

call
	: ^(T_CALL ^(T_NAME T_IDENTIFIER) ^(T_FROM T_THIS) argument)
	;

create
	: ^(T_CREATE ^(T_TYPE T_IDENTIFIER) argument)
	;

returndef
	: ^(T_RETURN element)
	;

variable
	: ^(T_VARIABLE T_IDENTIFIER)
		{ System.out.println("<element type=\"variable\">" + $T_IDENTIFIER.text + "</element>"); }
	;

attribute
	: ^(T_ATTRIBUTE T_IDENTIFIER)
		{ System.out.println("<element type=\"attribute\">" + $T_IDENTIFIER.text + "</element>"); }
	;

operation
	: ^(T_EQ { System.out.println("<operation type=\"eq\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	| ^(T_NE { System.out.println("<operation type=\"ne\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	| ^(T_LT { System.out.println("<operation type=\"lt\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	| ^(T_GT { System.out.println("<operation type=\"gt\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	| ^(T_LE { System.out.println("<operation type=\"le\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	| ^(T_GE { System.out.println("<operation type=\"ge\">"); } arithmetic arithmetic { System.out.println("</operation>"); })
	;

argument
	: ^(T_ARGUMENT element*)
	;
	
element
	: constant
	| attribute
	| variable
	;

constant
	: ^(T_CONSTANT T_NUMBER)
		{ System.out.println("<element type=\"constant\">" + $T_NUMBER.text + "</element>"); }
	;