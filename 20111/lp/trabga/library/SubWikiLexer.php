<?php
// $ANTLR 3.1.3 ìàé 06, 2009 18:28:01 SubWiki.g 2011-06-26 12:58:33


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
function SubWikiLexer_DFA1_static(){
    $eot = array(5, 65535, 1, 18, 5, 12, 11, 65535, 1, 26, 1, 28, 5, 65535);
    $eof = array(29, 65535);
    $min = array(1, 0, 4, 65535, 1, 42, 1, 47, 1, 91, 1, 93, 1, 123, 1, 
    125, 11, 65535, 1, 123, 1, 125, 5, 65535);
    $max = array(1, 65535, 4, 65535, 1, 42, 1, 47, 1, 91, 1, 93, 1, 123, 
    1, 125, 11, 65535, 1, 123, 1, 125, 5, 65535);
    $accept = array(1, 65535, 1, 1, 1, 2, 1, 3, 1, 4, 6, 65535, 1, 14, 1, 
    15, 1, 1, 1, 2, 1, 3, 1, 4, 1, 6, 1, 5, 1, 7, 1, 8, 1, 9, 2, 65535, 
    1, 14, 1, 12, 1, 10, 1, 13, 1, 11);
    $special = array(1, 0, 28, 65535);
    $transitionS = array(array(10, 12, 1, 2, 21, 12, 1, 1, 2, 12, 1, 4, 
    6, 12, 1, 5, 4, 12, 1, 6, 13, 12, 1, 3, 29, 12, 1, 7, 1, 12, 1, 8, 3, 
    12, 26, 11, 1, 9, 1, 12, 1, 10, 65410, 12), array(), array(), array(
    ), array(), array(1, 17), array(1, 19), array(1, 20), array(1, 21), 
    array(1, 22), array(1, 23), array(), array(), array(), array(), array(
    ), array(), array(), array(), array(), array(), array(), array(1, 25), 
    array(1, 27), array(), array(), array(), array(), array());

    $arr = array();
    $arr['eot'] = DFA::unpackRLE($eot);
    $arr['eof'] = DFA::unpackRLE($eof);
    $arr['min'] = DFA::unpackRLE($min, true);
    $arr['max'] = DFA::unpackRLE($max, true);
    $arr['accept'] = DFA::unpackRLE($accept);
    $arr['special'] = DFA::unpackRLE($special);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
    }
    return $arr;
}
$SubWikiLexer_DFA1 = SubWikiLexer_DFA1_static();

class SubWikiLexer_DFA1 extends DFA {

    public function __construct($recognizer) {
        global $SubWikiLexer_DFA1;
        $DFA = $SubWikiLexer_DFA1;
        $this->recognizer = $recognizer;
        $this->decisionNumber = 1;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( T_SPACE | T_NEWLINE | T_EQUAL | T_POUND | T_STAR | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | T_CHAR | T_OTHER );";
    }
    public function specialStateTransition($s, IntStream $_input) {
        $input = $_input;
    	$_s = $s;
        switch ( $s ) {
                case 0 : 
                    $LA1_0 = $input->LA(1);

                    $s = -1;
                    if ( ($LA1_0==$this->getToken('32')) ) {$s = 1;}

                    else if ( ($LA1_0==$this->getToken('10')) ) {$s = 2;}

                    else if ( ($LA1_0==$this->getToken('61')) ) {$s = 3;}

                    else if ( ($LA1_0==$this->getToken('35')) ) {$s = 4;}

                    else if ( ($LA1_0==$this->getToken('42')) ) {$s = 5;}

                    else if ( ($LA1_0==$this->getToken('47')) ) {$s = 6;}

                    else if ( ($LA1_0==$this->getToken('91')) ) {$s = 7;}

                    else if ( ($LA1_0==$this->getToken('93')) ) {$s = 8;}

                    else if ( ($LA1_0==$this->getToken('123')) ) {$s = 9;}

                    else if ( ($LA1_0==$this->getToken('125')) ) {$s = 10;}

                    else if ( (($LA1_0>=$this->getToken('97') && $LA1_0<=$this->getToken('122'))) ) {$s = 11;}

                    else if ( (($LA1_0>=$this->getToken('0') && $LA1_0<=$this->getToken('9'))||($LA1_0>=$this->getToken('11') && $LA1_0<=$this->getToken('31'))||($LA1_0>=$this->getToken('33') && $LA1_0<=$this->getToken('34'))||($LA1_0>=$this->getToken('36') && $LA1_0<=$this->getToken('41'))||($LA1_0>=$this->getToken('43') && $LA1_0<=$this->getToken('46'))||($LA1_0>=$this->getToken('48') && $LA1_0<=$this->getToken('60'))||($LA1_0>=$this->getToken('62') && $LA1_0<=$this->getToken('90'))||$LA1_0==$this->getToken('92')||($LA1_0>=$this->getToken('94') && $LA1_0<=$this->getToken('96'))||$LA1_0==$this->getToken('124')||($LA1_0>=$this->getToken('126') && $LA1_0<=$this->getToken('65535'))) ) {$s = 12;}

                    if ( $s>=0 ) return $s;
                    break;
        }
        $nvae =
            new NoViableAltException($this->getDescription(), 1, $_s, $input);
        $this->error($nvae);
        throw $nvae;        
    }
}
      

class SubWikiLexer extends AntlrLexer {
    static $T_CITE_OPEN=11;
    static $T_IMAGE_CLOSE=14;
    static $T_POUND=6;
    static $T_CHAR=17;
    static $T_EQUAL=9;
    static $T_SPACE=10;
    static $T_OTHER=18;
    static $T_STAR=5;
    static $T_NOWIKI_CLOSE=16;
    static $T_NEWLINE=4;
    static $T_BOLD=7;
    static $T_CITE_CLOSE=12;
    static $T_NOWIKI_OPEN=15;
    static $T_ITALIC=8;
    static $EOF=-1;
    static $T_IMAGE_OPEN=13;

    // delegates
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);

        
            $this->dfa1 = new SubWikiLexer_DFA1($this);
    }
    function getGrammarFileName() { return "SubWiki.g"; }

    // $ANTLR start "T_SPACE"
    function mT_SPACE(){
        try {
            $_type = SubWikiLexer::$T_SPACE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:511:9: ( ' ' ) 
            // SubWiki.g:511:11: ' ' 
            {
            $this->matchChar(32); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_SPACE"

    // $ANTLR start "T_NEWLINE"
    function mT_NEWLINE(){
        try {
            $_type = SubWikiLexer::$T_NEWLINE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:512:11: ( '\\n' ) 
            // SubWiki.g:512:13: '\\n' 
            {
            $this->matchChar(10); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_NEWLINE"

    // $ANTLR start "T_EQUAL"
    function mT_EQUAL(){
        try {
            $_type = SubWikiLexer::$T_EQUAL;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:514:9: ( '=' ) 
            // SubWiki.g:514:11: '=' 
            {
            $this->matchChar(61); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_EQUAL"

    // $ANTLR start "T_POUND"
    function mT_POUND(){
        try {
            $_type = SubWikiLexer::$T_POUND;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:515:9: ( '#' ) 
            // SubWiki.g:515:11: '#' 
            {
            $this->matchChar(35); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_POUND"

    // $ANTLR start "T_STAR"
    function mT_STAR(){
        try {
            $_type = SubWikiLexer::$T_STAR;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:516:9: ( '*' ) 
            // SubWiki.g:516:11: '*' 
            {
            $this->matchChar(42); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_STAR"

    // $ANTLR start "T_BOLD"
    function mT_BOLD(){
        try {
            $_type = SubWikiLexer::$T_BOLD;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:518:10: ( '**' ) 
            // SubWiki.g:518:12: '**' 
            {
            $this->matchString("**"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_BOLD"

    // $ANTLR start "T_ITALIC"
    function mT_ITALIC(){
        try {
            $_type = SubWikiLexer::$T_ITALIC;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:519:10: ( '//' ) 
            // SubWiki.g:519:12: '//' 
            {
            $this->matchString("//"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_ITALIC"

    // $ANTLR start "T_CITE_OPEN"
    function mT_CITE_OPEN(){
        try {
            $_type = SubWikiLexer::$T_CITE_OPEN;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:521:14: ( '[[' ) 
            // SubWiki.g:521:16: '[[' 
            {
            $this->matchString("[["); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_CITE_OPEN"

    // $ANTLR start "T_CITE_CLOSE"
    function mT_CITE_CLOSE(){
        try {
            $_type = SubWikiLexer::$T_CITE_CLOSE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:522:14: ( ']]' ) 
            // SubWiki.g:522:16: ']]' 
            {
            $this->matchString("]]"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_CITE_CLOSE"

    // $ANTLR start "T_IMAGE_OPEN"
    function mT_IMAGE_OPEN(){
        try {
            $_type = SubWikiLexer::$T_IMAGE_OPEN;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:524:15: ( '{{' ) 
            // SubWiki.g:524:17: '{{' 
            {
            $this->matchString("{{"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_IMAGE_OPEN"

    // $ANTLR start "T_IMAGE_CLOSE"
    function mT_IMAGE_CLOSE(){
        try {
            $_type = SubWikiLexer::$T_IMAGE_CLOSE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:525:15: ( '}}' ) 
            // SubWiki.g:525:17: '}}' 
            {
            $this->matchString("}}"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_IMAGE_CLOSE"

    // $ANTLR start "T_NOWIKI_OPEN"
    function mT_NOWIKI_OPEN(){
        try {
            $_type = SubWikiLexer::$T_NOWIKI_OPEN;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:527:16: ( '{{{' ) 
            // SubWiki.g:527:18: '{{{' 
            {
            $this->matchString("{{{"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_NOWIKI_OPEN"

    // $ANTLR start "T_NOWIKI_CLOSE"
    function mT_NOWIKI_CLOSE(){
        try {
            $_type = SubWikiLexer::$T_NOWIKI_CLOSE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:528:16: ( '}}}' ) 
            // SubWiki.g:528:18: '}}}' 
            {
            $this->matchString("}}}"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_NOWIKI_CLOSE"

    // $ANTLR start "T_CHAR"
    function mT_CHAR(){
        try {
            $_type = SubWikiLexer::$T_CHAR;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:530:8: ( 'a' .. 'z' ) 
            // SubWiki.g:530:10: 'a' .. 'z' 
            {
            $this->matchRange(97,122); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_CHAR"

    // $ANTLR start "T_OTHER"
    function mT_OTHER(){
        try {
            $_type = SubWikiLexer::$T_OTHER;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:532:9: ( . ) 
            // SubWiki.g:532:11: . 
            {
            $this->matchAny(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T_OTHER"

    function mTokens(){
        // SubWiki.g:1:8: ( T_SPACE | T_NEWLINE | T_EQUAL | T_POUND | T_STAR | T_BOLD | T_ITALIC | T_CITE_OPEN | T_CITE_CLOSE | T_IMAGE_OPEN | T_IMAGE_CLOSE | T_NOWIKI_OPEN | T_NOWIKI_CLOSE | T_CHAR | T_OTHER ) 
        $alt1=15;
        $alt1 = $this->dfa1->predict($this->input);
        switch ($alt1) {
            case 1 :
                // SubWiki.g:1:10: T_SPACE 
                {
                $this->mT_SPACE(); 

                }
                break;
            case 2 :
                // SubWiki.g:1:18: T_NEWLINE 
                {
                $this->mT_NEWLINE(); 

                }
                break;
            case 3 :
                // SubWiki.g:1:28: T_EQUAL 
                {
                $this->mT_EQUAL(); 

                }
                break;
            case 4 :
                // SubWiki.g:1:36: T_POUND 
                {
                $this->mT_POUND(); 

                }
                break;
            case 5 :
                // SubWiki.g:1:44: T_STAR 
                {
                $this->mT_STAR(); 

                }
                break;
            case 6 :
                // SubWiki.g:1:51: T_BOLD 
                {
                $this->mT_BOLD(); 

                }
                break;
            case 7 :
                // SubWiki.g:1:58: T_ITALIC 
                {
                $this->mT_ITALIC(); 

                }
                break;
            case 8 :
                // SubWiki.g:1:67: T_CITE_OPEN 
                {
                $this->mT_CITE_OPEN(); 

                }
                break;
            case 9 :
                // SubWiki.g:1:79: T_CITE_CLOSE 
                {
                $this->mT_CITE_CLOSE(); 

                }
                break;
            case 10 :
                // SubWiki.g:1:92: T_IMAGE_OPEN 
                {
                $this->mT_IMAGE_OPEN(); 

                }
                break;
            case 11 :
                // SubWiki.g:1:105: T_IMAGE_CLOSE 
                {
                $this->mT_IMAGE_CLOSE(); 

                }
                break;
            case 12 :
                // SubWiki.g:1:119: T_NOWIKI_OPEN 
                {
                $this->mT_NOWIKI_OPEN(); 

                }
                break;
            case 13 :
                // SubWiki.g:1:133: T_NOWIKI_CLOSE 
                {
                $this->mT_NOWIKI_CLOSE(); 

                }
                break;
            case 14 :
                // SubWiki.g:1:148: T_CHAR 
                {
                $this->mT_CHAR(); 

                }
                break;
            case 15 :
                // SubWiki.g:1:155: T_OTHER 
                {
                $this->mT_OTHER(); 

                }
                break;

        }

    }



}
?>