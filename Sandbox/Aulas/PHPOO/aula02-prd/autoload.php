<?php

function __autoload($classname)
{
    require_once dirname(__FILE__) . "/classes/$classname.php";
}