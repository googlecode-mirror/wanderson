parser:
	bison -d parser.y && flex lexer.l && gcc -lfl -o parser parser.tab.c lex.yy.c

clean:
	rm -rf parser.tab.c parser.tab.h parser lex.yy.c lexer
