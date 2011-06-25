# Makefile

subwiki:
	java -cp "antlr-2.7.7.jar:antlr-3.1.3-php.jar:antlr-runtime-3.1.3.jar:gunit.jar:stringtemplate-3.2.jar" org.antlr.Tool SubWiki.g && php -l SubWikiLexer.php && php -l SubWikiParser.php

clean:
	rm -rf SubWikiParser.php SubWikiLexer.php SubWiki.tokens

