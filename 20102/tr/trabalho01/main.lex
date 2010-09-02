%option noyywrap

%s comentario_chave
%s comentario_barra

%{

void echo(char message[])
{
    printf("%s\t%s\n", yytext, message);
}

%}

DIGIT [0-9]
ID    [a-zA-Z0-9][a-zA-Z0-9]*

%%

(?i:absolute|array|begin|case|char|const|div|do|dowto|else|end|external|file|for|forward|func|function|goto|if|implementation|in|integer|interface|label|main|mod|new|nil|nit|off|packed|proc|program|real|record|repeat|set|shl|shr|string|than|to|type|unit|until|uses|var|while|with|xor) echo("PALAVRARESERVADA");

(?i:and|or|not) echo("OPERADORLOGICO");

(?i:read|readln|write|writeln) echo("PALAVRARESERVADA");

{DIGIT}+ echo("NUMEROINTEIRO");

{DIGIT}+\.{DIGIT}+(e(\-|(\+)?){DIGIT}{2})? echo("NUMEROREAL");

{ID} echo("IDENTIFICADOR");

"+"|"-"|"*"|"/" echo("OPERADOR");

"<"|">"|"<="|">="|"<>" echo("OPERADORRELACIONAL");

"="|"("|")"|","|":"|";" echo("SIMBOLOESPECIAL");

":=" echo("ATRIBUICAO");

"." echo("FIM");

"{" BEGIN(comentario_chave);
"/*" BEGIN(comentario_barra);

<comentario_chave>[^("}")]*"}" BEGIN(INITIAL);

<comentario_barra>([^*]|(\*+[^*/]))*"*/"

'[^']*' echo("FLUXODECARACTERES");

\"[^\"]*\" echo("CONSTANTESTRING");

" " 
\n 

. echo("ERROLEXICO");


%%

int main(int argc, char *argv[])
{
    yyin = fopen(argv[1], "r");
    yylex();
    fclose(yyin);
    printf("\n");
    return 0;
}
