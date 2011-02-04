<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once 'NodeInterface.php';
require_once 'NodeException.php';
require_once 'NodeAbstract.php';
require_once 'HtmlNode.php';
require_once 'HtmlPage.php';
require_once 'HtmlText.php';

NodeAbstract::setIndentElement(' ');
NodeAbstract::setIndentSize(4);

$page = new HtmlPage();

echo $page;