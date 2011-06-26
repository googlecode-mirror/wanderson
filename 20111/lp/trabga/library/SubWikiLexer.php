<?php
// $ANTLR 3.1.3 ìàé 06, 2009 18:28:01 SubWiki.g 2011-06-26 19:14:10


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
function SubWikiLexer_DFA2_static(){
    $eot = array(2, 65535, 1, 13, 3, 65535, 1, 19, 5, 13, 11, 65535, 1, 
    27, 1, 29, 5, 65535);
    $eof = array(30, 65535);
    $min = array(1, 0, 1, 65535, 1, 10, 3, 65535, 1, 42, 1, 47, 1, 91, 1, 
    93, 1, 123, 1, 125, 11, 65535, 1, 123, 1, 125, 5, 65535);
    $max = array(1, 65535, 1, 65535, 1, 10, 3, 65535, 1, 42, 1, 47, 1, 91, 
    1, 93, 1, 123, 1, 125, 11, 65535, 1, 123, 1, 125, 5, 65535);
    $accept = array(1, 65535, 1, 1, 1, 65535, 1, 2, 1, 3, 1, 4, 6, 65535, 
    1, 14, 1, 15, 1, 1, 1, 2, 1, 3, 1, 4, 1, 6, 1, 5, 1, 7, 1, 8, 1, 9, 
    2, 65535, 1, 14, 1, 12, 1, 10, 1, 13, 1, 11);
    $special = array(1, 0, 29, 65535);
    $transitionS = array(array(10, 13, 1, 3, 2, 13, 1, 2, 18, 13, 1, 1, 
    2, 13, 1, 5, 6, 13, 1, 6, 4, 13, 1, 7, 13, 13, 1, 4, 29, 13, 1, 8, 1, 
    13, 1, 9, 3, 13, 26, 12, 1, 10, 1, 13, 1, 11, 65410, 13), array(), array(
    1, 15), array(), array(), array(), array(1, 18), array(1, 20), array(
    1, 21), array(1, 22), array(1, 23), array(1, 24), array(), array(), 
    array(), array(), array(), array(), array(), array(), array(), array(
    ), array(), array(1, 26), array(1, 28), array(), array(), array(), array(
    ), array());

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
$SubWikiLexer_DFA2 = SubWikiLexer_DFA2_static();

class SubWikiLexer_DFA2 extends DFA {

    public function __construct($recognizer) {
        //global $SubWikiLexer_DFA2;
        $DFA = SubWikiLexer_DFA2_static();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 2;
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
                    $LA2_0 = $input->LA(1);

                    $s = -1;
                    if ( ($LA2_0==$this->getToken('32')) ) {$s = 1;}

                    else if ( ($LA2_0==$this->getToken('13')) ) {$s = 2;}

                    else if ( ($LA2_0==$this->getToken('10')) ) {$s = 3;}

                    else if ( ($LA2_0==$this->getToken('61')) ) {$s = 4;}

                    else if ( ($LA2_0==$this->getToken('35')) ) {$s = 5;}

                    else if ( ($LA2_0==$this->getToken('42')) ) {$s = 6;}

                    else if ( ($LA2_0==$this->getToken('47')) ) {$s = 7;}

                    else if ( ($LA2_0==$this->getToken('91')) ) {$s = 8;}

                    else if ( ($LA2_0==$this->getToken('93')) ) {$s = 9;}

                    else if ( ($LA2_0==$this->getToken('123')) ) {$s = 10;}

                    else if ( ($LA2_0==$this->getToken('125')) ) {$s = 11;}

                    else if ( (($LA2_0>=$this->getToken('97') && $LA2_0<=$this->getToken('122'))) ) {$s = 12;}

                    else if ( (($LA2_0>=$this->getToken('0') && $LA2_0<=$this->getToken('9'))||($LA2_0>=$this->getToken('11') && $LA2_0<=$this->getToken('12'))||($LA2_0>=$this->getToken('14') && $LA2_0<=$this->getToken('31'))||($LA2_0>=$this->getToken('33') && $LA2_0<=$this->getToken('34'))||($LA2_0>=$this->getToken('36') && $LA2_0<=$this->getToken('41'))||($LA2_0>=$this->getToken('43') && $LA2_0<=$this->getToken('46'))||($LA2_0>=$this->getToken('48') && $LA2_0<=$this->getToken('60'))||($LA2_0>=$this->getToken('62') && $LA2_0<=$this->getToken('90'))||$LA2_0==$this->getToken('92')||($LA2_0>=$this->getToken('94') && $LA2_0<=$this->getToken('96'))||$LA2_0==$this->getToken('124')||($LA2_0>=$this->getToken('126') && $LA2_0<=$this->getToken('65535'))) ) {$s = 13;}

                    if ( $s>=0 ) return $s;
                    break;
        }
        $nvae =
            new NoViableAltException($this->getDescription(), 2, $_s, $input);
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

        
            $this->dfa2 = new SubWikiLexer_DFA2($this);
    }
    function getGrammarFileName() { return "SubWiki.g"; }

    // $ANTLR start "T_SPACE"
    function mT_SPACE(){
        try {
            $_type = SubWikiLexer::$T_SPACE;
            $_channel = SubWikiLexer::$DEFAULT_TOKEN_CHANNEL;
            // SubWiki.g:581:9: ( ' ' ) 
            // SubWiki.g:581:11: ' ' 
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
            // SubWiki.g:582:11: ( ( '\\r' )? '\\n' ) 
            // SubWiki.g:582:13: ( '\\r' )? '\\n' 
            {
            // SubWiki.g:582:13: ( '\\r' )? 
            $alt1=2;
            $LA1_0 = $this->input->LA(1);

            if ( ($LA1_0==$this->getToken('13')) ) {
                $alt1=1;
            }
            switch ($alt1) {
                case 1 :
                    // SubWiki.g:582:13: '\\r' 
                    {
                    $this->matchChar(13); 

                    }
                    break;

            }

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
            // SubWiki.g:584:9: ( '=' ) 
            // SubWiki.g:584:11: '=' 
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
            // SubWiki.g:585:9: ( '#' ) 
            // SubWiki.g:585:11: '#' 
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
            // SubWiki.g:586:9: ( '*' ) 
            // SubWiki.g:586:11: '*' 
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
            // SubWiki.g:588:10: ( '**' ) 
            // SubWiki.g:588:12: '**' 
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
            // SubWiki.g:589:10: ( '//' ) 
            // SubWiki.g:589:12: '//' 
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
            // SubWiki.g:591:14: ( '[[' ) 
            // SubWiki.g:591:16: '[[' 
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
            // SubWiki.g:592:14: ( ']]' ) 
            // SubWiki.g:592:16: ']]' 
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
            // SubWiki.g:594:15: ( '{{' ) 
            // SubWiki.g:594:17: '{{' 
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
            // SubWiki.g:595:15: ( '}}' ) 
            // SubWiki.g:595:17: '}}' 
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
            // SubWiki.g:597:16: ( '{{{' ) 
            // SubWiki.g:597:18: '{{{' 
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
            // SubWiki.g:598:16: ( '}}}' ) 
            // SubWiki.g:598:18: '}}}' 
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
            // SubWiki.g:600:8: ( 'a' .. 'z' ) 
            // SubWiki.g:600:10: 'a' .. 'z' 
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
            // SubWiki.g:602:9: ( . ) 
            // SubWiki.g:602:11: . 
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
        $alt2=15;
        $alt2 = $this->dfa2->predict($this->input);
        switch ($alt2) {
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