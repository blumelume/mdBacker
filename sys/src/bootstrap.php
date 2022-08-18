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
  $loaderContent = require($dir.'/loader.inc.php');
  $classes = array(
    array(locSys.'src/ExceptionHandler.inc.php'),
    $loaderContent['classes']
  );
  foreach($classes as $c) {
    foreach ($c as $class) {
      require($class);
    }
  }

  /*
  error / exception handling
  */
  $exceptionHandler = new \ExceptionHandler();
  set_exception_handler([$exceptionHandler, 'handle']);
}

/*
global functions
*/
function redirect($loc) {
  header('Location: '.$loc);
  die();
}
?>