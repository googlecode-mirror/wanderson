#!/bin/bash
bison -d pascal.y && flex pascal.l && gcc lex.yy.c pascal.tab.c -o pascal && ./pascal < input.txt && rm lex.yy.c pascal pascal.tab.c pascal.tab.h
