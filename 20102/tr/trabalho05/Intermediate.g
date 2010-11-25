tree grammar Intermediate;

options {
	output = AST;
	ASTLabelType = CommonTree;
	tokenVocab = Versioning;
}

classdef
@after {
	System.out.println("</class>");
}
	: ^(T_CLASSDEF ^(T_NAME T_IDENTIFIER) visibility { System.out.println("<class name=\"" + $T_IDENTIFIER.text + "\" visibility=\"" + $visibility.value + "\">"); } ^(T_CLASSBODY classbody*))
	;

visibility returns [ String value ]
	: ^(T_VISIBILITY T_PUBLIC { $value = $T_PUBLIC.text; })
	| ^(T_VISIBILITY T_PRIVATE { $value = $T_PRIVATE.text; })
	| ^(T_VISIBILITY T_PROTECTED { $value = $T_PROTECTED.text; })
	;

classbody
	: attributedef
	| constructordef
	| methoddef
	;

attributedef
	: ^(T_ATTRIBUTEDEF ^(T_ACCESSTYPE T_STATIC) visibility { System.out.println("<attribute type=\"static\" visibility=\"" + $visibility.value + "\">"); } declaration { System.out.println("</attribute>"); })
	| ^(T_ATTRIBUTEDEF ^(T_ACCESSTYPE T_INSTANCE) visibility { System.out.println("<attribute type=\"instance\" visibility=\"" + $visibility.value + "\">"); } declaration { System.out.println("</attribute>"); })
	;

constructordef
	: ^(T_CONSTRUCTORDEF ^(T_TYPE T_IDENTIFIER) visibility { System.out.println("<constructor visibility=\"" + $visibility.value + "\">"); } parameter body { System.out.println("</constructor>"); })
	;

methoddef
	: ^(T_METHODDEF ^(T_ACCESSTYPE T_STATIC) ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) visibility { System.out.println("<method name=\"" + $n.text + "\" type=\"static\" visibility=\"" + $visibility.value + "\" return=\"" + $t.text + "\">"); } parameter body { System.out.println("</method>"); })
	| ^(T_METHODDEF ^(T_ACCESSTYPE T_INSTANCE) ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) visibility { System.out.println("<method name=\"" + $n.text + "\" type=\"instance\" visibility=\"" + $visibility.value + "\" return=\"" + $t.text + "\">"); } parameter body { System.out.println("</method>"); })
	;

declaration
	: ^(T_DECLARATION ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) { System.out.println("<declaration type=\"" + $t.text + "\">" + $n.text + "</declaration>"); } )
	| ^(T_DECLARATION ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) T_VECTOR { System.out.println("<declaration type=\"" + $t.text + "\" vector=\"vector\">" + $n.text + "</declaration>"); } )
	;

parameter
@after {
	System.out.println("</parameter>");
}
	: ^(T_PARAMETER { System.out.println("<parameter>"); } declaration*)
	;

body
@after {
	System.out.println("</body>");
}
	: ^(T_BODY { System.out.println("<body>"); } statement*)
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
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } declaration arithmetic { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } declaration call { System.out.println("</assignment>"); })
	| ^(T_ASSIGNMENT { System.out.println("<assignment>"); } declaration create { System.out.println("</assignment>"); })
	;

arithmetic
	: ^(T_ADD { System.out.println("<arithmetic type=\"add\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_SUB { System.out.println("<arithmetic type=\"sub\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_MUL { System.out.println("<arithmetic type=\"mul\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| ^(T_DIV { System.out.println("<arithmetic type=\"div\">"); } arithmetic arithmetic { System.out.println("</arithmetic>"); })
	| element
	;

conditional
	: ^(T_CONDITIONAL { System.out.println("<conditional>"); } operation body body { System.out.println("</conditional>"); })
	;

looping
	: ^(T_LOOPING { System.out.println("<looping>"); } operation body { System.out.println("</looping>"); })
	;

call
	: ^(T_CALL ^(T_NAME T_IDENTIFIER) ^(T_FROM T_THIS) { System.out.println("<call id=\"" + $T_IDENTIFIER.text + "\" from=\"" + $T_THIS.text + "\">"); } argument { System.out.println("</call>"); })
	| ^(T_CALL ^(T_NAME m=T_IDENTIFIER) ^(T_FROM f=T_IDENTIFIER) { System.out.println("<call id=\"" + $m.text + "\" from=\"" + $f.text + "\">"); } argument { System.out.println("</call>"); })
	;

create
	: ^(T_CREATE ^(T_TYPE T_IDENTIFIER) { System.out.println("<create instance=\"" + $T_IDENTIFIER.text + "\">"); } argument { System.out.println("</create>"); })
	| ^(T_CREATE ^(T_TYPE T_IDENTIFIER) { System.out.println("<create instance=\"" + $T_IDENTIFIER.text + "\" vector=\"vector\">"); } ^(T_VECTOR constant) { System.out.println("</create>"); })
	;

returndef
	: ^(T_RETURN { System.out.println("<return>"); } element { System.out.println("</return>"); })
	;

variable
	: ^(T_VARIABLE T_IDENTIFIER)
		{ System.out.println("<element type=\"variable\">" + $T_IDENTIFIER.text + "</element>"); }
	;

attribute
	: ^(T_ATTRIBUTE ^(T_FROM T_THIS) ^(T_NAME T_IDENTIFIER))
		{ System.out.println("<element type=\"attribute\" from=\"this\">" + $T_IDENTIFIER.text + "</element>"); }
	| ^(T_ATTRIBUTE ^(T_FROM f=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER))
		{ System.out.println("<element type=\"attribute\" from=\"" + $f.text + "\">" + $n.text + "</element>"); }
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
@after {
	System.out.println("</argument>");
}
	: ^(T_ARGUMENT { System.out.println("<argument>"); } element*)
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