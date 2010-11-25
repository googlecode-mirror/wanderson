tree grammar Intermediate;

options {
	output = AST;
	ASTLabelType = CommonTree;
	tokenVocab = Versioning;
}

@members {
	/*
	 * Número Atual da Profundidade
	 */
	public int depth     = 0;
	/*
	 * Quantidade de Elementos de Indentação
	 */
	public int size      = 4;
	/*
	 * Elemento para Indentação
	 */
	public String indent = " ";
	/*
	 * Abertura de Tag com Fechamento Posterior
	 */
	public void open(String content)
	{
		open(content, false);
	}
	/*
	 * Abertura de Tag com Fechamento no Mesmo Local
	 */
	public void open(String content, boolean closed)
	{
		indent();
		System.out.print(content);
		if (!closed) {
			depth = depth + size;
		}
		System.out.print("\n");
	}
	/*
	 * Fechamento de Tag Posteriormente Aberta
	 */
	public void close(String content)
	{
		depth = depth - size;
		indent();
		System.out.print(content + "\n");
	}
	/*
	 * Método para Indentação
	 */
	public void indent()
	{
		for (int i = 0; i < depth; i++) {
			System.out.print(indent);
		}
	}
}

classdef
@after {
	close("</class>");
}
	: ^(T_CLASSDEF ^(T_NAME T_IDENTIFIER) visibility { open("<class name=\"" + $T_IDENTIFIER.text + "\" visibility=\"" + $visibility.value + "\">"); } ^(T_CLASSBODY classbody*))
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
	: ^(T_ATTRIBUTEDEF ^(T_ACCESSTYPE T_STATIC) visibility { open("<attribute type=\"static\" visibility=\"" + $visibility.value + "\">"); } declaration { close("</attribute>"); })
	| ^(T_ATTRIBUTEDEF ^(T_ACCESSTYPE T_INSTANCE) visibility { open("<attribute type=\"instance\" visibility=\"" + $visibility.value + "\">"); } declaration { close("</attribute>"); })
	;


methoddef
	: ^(T_METHODDEF ^(T_ACCESSTYPE T_STATIC) ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) visibility { open("<method name=\"" + $n.text + "\" type=\"static\" visibility=\"" + $visibility.value + "\" return=\"" + $t.text + "\">"); } parameter body { close("</method>"); })
	| ^(T_METHODDEF ^(T_ACCESSTYPE T_INSTANCE) ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) visibility { open("<method name=\"" + $n.text + "\" type=\"instance\" visibility=\"" + $visibility.value + "\" return=\"" + $t.text + "\">"); } parameter body { close("</method>"); })
	;
constructordef
	: ^(T_CONSTRUCTORDEF ^(T_TYPE T_IDENTIFIER) visibility { open("<constructor visibility=\"" + $visibility.value + "\">"); } parameter body { close("</constructor>"); })
	;


declaration
	: ^(T_DECLARATION ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) { open("<declaration type=\"" + $t.text + "\">" + $n.text + "</declaration>", true); } )
	| ^(T_DECLARATION ^(T_TYPE t=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER) T_VECTOR { open("<declaration type=\"" + $t.text + "\" vector=\"vector\">" + $n.text + "</declaration>", true); } )
	;

parameter
@after {
	close("</parameter>");
}
	: ^(T_PARAMETER { open("<parameter>"); } declaration*)
	;

body
@after {
	close("</body>");
}
	: ^(T_BODY { open("<body>"); } statement*)
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
	: ^(T_ASSIGNMENT { open("<assignment>"); } variable arithmetic { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } attribute arithmetic { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } variable call { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } attribute call { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } variable create { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } attribute create { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } declaration arithmetic { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } declaration call { close("</assignment>"); })
	| ^(T_ASSIGNMENT { open("<assignment>"); } declaration create { close("</assignment>"); })
	;

arithmetic
	: ^(T_ADD { open("<arithmetic type=\"add\">"); } arithmetic arithmetic { close("</arithmetic>"); })
	| ^(T_SUB { open("<arithmetic type=\"sub\">"); } arithmetic arithmetic { close("</arithmetic>"); })
	| ^(T_MUL { open("<arithmetic type=\"mul\">"); } arithmetic arithmetic { close("</arithmetic>"); })
	| ^(T_DIV { open("<arithmetic type=\"div\">"); } arithmetic arithmetic { close("</arithmetic>"); })
	| element
	;

conditional
	: ^(T_CONDITIONAL { open("<conditional>"); } operation body body { close("</conditional>"); })
	;

looping
	: ^(T_LOOPING { open("<looping>"); } operation body { close("</looping>"); })
	;

call
	: ^(T_CALL ^(T_NAME T_IDENTIFIER) ^(T_FROM T_THIS) { open("<call id=\"" + $T_IDENTIFIER.text + "\" from=\"" + $T_THIS.text + "\">"); } argument { close("</call>"); })
	| ^(T_CALL ^(T_NAME m=T_IDENTIFIER) ^(T_FROM f=T_IDENTIFIER) { open("<call id=\"" + $m.text + "\" from=\"" + $f.text + "\">"); } argument { close("</call>"); })
	;

create
	: ^(T_CREATE ^(T_TYPE T_IDENTIFIER) { open("<create instance=\"" + $T_IDENTIFIER.text + "\">"); } argument { close("</create>"); })
	| ^(T_CREATE ^(T_TYPE T_IDENTIFIER) { open("<create instance=\"" + $T_IDENTIFIER.text + "\" vector=\"vector\">"); } ^(T_VECTOR constant) { close("</create>"); })
	;

returndef
	: ^(T_RETURN { open("<return>"); } element { close("</return>"); })
	;

variable
	: ^(T_VARIABLE T_IDENTIFIER)
		{ open("<element type=\"variable\">" + $T_IDENTIFIER.text + "</element>", true); }
	;

attribute
	: ^(T_ATTRIBUTE ^(T_FROM T_THIS) ^(T_NAME T_IDENTIFIER))
		{ open("<element type=\"attribute\" from=\"this\">" + $T_IDENTIFIER.text + "</element>", true); }
	| ^(T_ATTRIBUTE ^(T_FROM f=T_IDENTIFIER) ^(T_NAME n=T_IDENTIFIER))
		{ open("<element type=\"attribute\" from=\"" + $f.text + "\">" + $n.text + "</element>", true); }
	;

operation
	: ^(T_EQ { open("<operation type=\"eq\">"); } arithmetic arithmetic { close("</operation>"); })
	| ^(T_NE { open("<operation type=\"ne\">"); } arithmetic arithmetic { close("</operation>"); })
	| ^(T_LT { open("<operation type=\"lt\">"); } arithmetic arithmetic { close("</operation>"); })
	| ^(T_GT { open("<operation type=\"gt\">"); } arithmetic arithmetic { close("</operation>"); })
	| ^(T_LE { open("<operation type=\"le\">"); } arithmetic arithmetic { close("</operation>"); })
	| ^(T_GE { open("<operation type=\"ge\">"); } arithmetic arithmetic { close("</operation>"); })
	;

argument
@after {
	close("</argument>");
}
	: ^(T_ARGUMENT { open("<argument>"); } element*)
	;
	
element
	: constant
	| attribute
	| variable
	;

constant
	: ^(T_CONSTANT T_NUMBER)
		{ open("<element type=\"constant\">" + $T_NUMBER.text + "</element>", true); }
	;