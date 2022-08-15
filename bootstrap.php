<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// including all classes
require(locSys.'php/classes/classes.inc');

/*
Constant System-Paths
*/
define('ROOTPATH', __DIR__);
// relative to root-dir
define('locSys', ROOTPATH.'/sys/');
define('locFiles', ROOTPATH.'/files/');

define('locConfigs', locFiles.'configs/');
define('locTemplates', locFiles.'templates/');
define('locPages', locFiles.'pages/');
define('locComponents', locFiles.'components/');


/*
error / exception handling
*/
set_exception_handler(['ExceptionHandler', 'handle']);


/*
local dependencies
*/

require(locSys.'php/lib/Parsedown.php');
$GLOBALS['pd'] = new Parsedown();

/*
global functions
*/
function recursiveRemove($dir) {
  $structure = glob(rtrim($dir, "/").'/*');
  if (is_array($structure)) {
      foreach($structure as $file) {
          if (is_dir($file)) recursiveRemove($file);
          elseif (is_file($file)) unlink($file);
      }
  }
  rmdir($dir);
}

function backToRoot() {
  if (getcwd() != '/') {
    chdir('../');
  }
  return (getcwd() == '/') ? true : backToRoot();
}
?>