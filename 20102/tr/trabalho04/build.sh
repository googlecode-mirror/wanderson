#!/bin/bash
bison -d pascal.y
flex pascal.l
gcc -g lex.yy.c pascal.tab.c -o pascal
rm pascal.tab.c lex.yy.c pascal.tab.h
