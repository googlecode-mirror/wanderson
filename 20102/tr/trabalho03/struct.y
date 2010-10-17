{
module Main where
import Data.Char
}

%name struct
%tokentype { Token }
%error     { parseError}

%token
    end    { TokenEnd }
    record { TokenRecord }
    id     { TokenId }
    ';'    { TokenDelimiter }
    ':'    { TokenTypeOf }
    ','    { TokenList }

%%

S
    : record FieldList end { }

FieldList
    : Field Recursion      { }

Recursion
    : ';' Field Recursion  { }
    | {- empty -}          { }

Field
    : IdList ':' Id        { }

IdList
    : Id Factoring         { }

Factoring
    : ',' IdList           { }
    | {- empty -}          { }

{

parseError :: [Token] -> a
parseError _ = error "Parse Error"

}
