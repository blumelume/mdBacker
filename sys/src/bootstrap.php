<?php
namespace mdBacker\sys;

/*
Constant System-Paths
*/
chdir('../../../');
define('ROOTPATH', getcwd());
// relative to root-dir
define('locSys', ROOTPATH.'/sys/');
define('locLogs', ROOTPATH.'/logs/');
define('locFiles', ROOTPATH.'/files/');

define('locDef', locSys.'def/');

define('locConfigs', locFiles.'configs/');
define('locTemplates', locFiles.'templates/');
define('locPages', locFiles.'pages/');
define('locComponents', locFiles.'components/');


/*
including all classes specified in loader
*/
function includeClasses( $dir ) {
  requireFilesFromLoader($dir, 'classes');
}

/* error / exception handling */
require('ExceptionHandler.inc.php');
$exceptionHandler = new \ExceptionHandler();
set_exception_handler([$exceptionHandler, 'handle']);

/*
global functions
*/
function redirect($loc) {
  header('Location: '.$loc);
  die();
}

/*
requireFilesFromLoader()
requires all files from specified loader file of specfied kind
* $loaderDir -> base-directory of the targeted loader (e.g.: absolute path to lectern)
* $kind -> kind of files to require (e.g. classes, footerScripts, ...)
*/
function requireFilesFromLoader($loaderDir, $kind) {
  $loaderContent = require($loaderDir.'/loader.inc.php');

  if (is_array($loaderContent) && array_key_exists($kind, $loaderContent)) {
    foreach($loaderContent[$kind] as $file) {
      require($file);
    }
  }
}
?>