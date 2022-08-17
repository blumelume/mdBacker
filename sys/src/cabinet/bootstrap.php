<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
Constant System-Paths
*/
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'].'/mdBacker/');
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
$classes = array(
  array(locSys.'src/ExceptionHandler.inc.php'),
  require(locSys.'src/cabinet/loader.inc.php')
);
foreach($classes as $c) {
  foreach ($c as $class) {
    require($class);
  }
}


/*
error / exception handling
*/
$exceptionHandler = new ExceptionHandler();
set_exception_handler([$exceptionHandler, 'handle']);


/*
local dependencies
*/
require_once ROOTPATH.'/vendor/autoload.php';
$GLOBALS['mdParser'] = new Parsedown();

/*
global functions
*/
function redirect($loc) {
  header('Location: '.$loc);
  die();
}
?>