<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
Constant System-Paths
*/
define('ROOTPATH', __DIR__);
// relative to root-dir
define('locSys', ROOTPATH.'/sys/');
define('locLogs', ROOTPATH.'/logs/');
define('locFiles', ROOTPATH.'/files/');

define('locDef', locSys.'def/');

define('locConfigs', locFiles.'configs/');
define('locTemplates', locFiles.'templates/');
define('locPages', locFiles.'pages/');
define('locComponents', locFiles.'components/');

// including all required classes
require(locSys.'php/classes/classes.inc');


/*
error / exception handling
*/
$exceptionHandler = new ExceptionHandler();
set_exception_handler([$exceptionHandler, 'handle']);


/*
local dependencies
*/
require(locSys.'php/lib/Parsedown.php');
$GLOBALS['mdParser'] = new Parsedown();

/*
global functions
*/
function redirect($loc) {
  header('Location: '.$loc);
  die();
}
?>