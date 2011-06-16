# Makefile

subwiki:
	java -cp "antlr-2.7.7.jar:antlr-3.1.3-php.jar:antlr-runtime-3.1.3.jar:gunit.jar:stringtemplate-3.2.jar" org.antlr.Tool subwiki.g && php -l subwikiLexer.php && php -l subwikiParser.php

clean:
	rm -rf subwikiParser.php subwikiLexer.php subwiki.tokens

