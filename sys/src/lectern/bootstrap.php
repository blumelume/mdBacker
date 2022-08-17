<?php
require( '../bootstrap.php' );

/*
local dependencies
*/
require_once ROOTPATH.'/vendor/autoload.php';
use ScssPhp\ScssPhp\Compiler;
$GLOBALS['scssParser'] = new Compiler();
?>