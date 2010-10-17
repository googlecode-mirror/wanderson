README
======

1) Informar que o Happy não dá suporte para EBNF, como sequências de caracteres
utilizando expressões regulares como n+ ou n*. Porém, podemos construir esta
estrutura criando produções para elas.

prods : prod       { [$1] }
      | prods prod { $2 : $1 }

prods : {- empty -} { [] }
      | prods prod  { $2 : $1 }

Onde - empty - é um comentário

Happy é mais eficiente para tradução de regras com recursão à esquerda, onde a
explicação desta capacidade está na documentação. Traduzir e entender melhor
aquela seção.

http://www.haskell.org/happy/doc/html/sec-sequences.html

O Happy fornece a possibilidade de adicionar precedência de Tokens em gramáticas
possivelmente ambíguas. Podemos também informar se os Tokens são associativos à
esquerda ou direita através das diretivas %left %right

%left '+' '-'
%left '*' '/'
