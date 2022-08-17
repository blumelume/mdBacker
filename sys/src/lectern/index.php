<?php
/**/

error_reporting(E_ALL);
ini_set("display_errors", 1);

require('../bootstrap.php');
\mdBacker\sys\includeClasses( __DIR__ );

require_once ROOTPATH.'/vendor/autoload.php';
use ScssPhp\ScssPhp\Compiler;
$GLOBALS['scssParser'] = new Compiler();

$lectern = new \mdBacker\lectern\classes\Lectern();

/**/
?>  

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <style type="text/css">
      <?= $lectern->compileScss( '@import "'.__DIR__.'/css/global.scss"' ); ?>
    </style>
  </head>

  <body class="mdBacker lectern">

    <header class="header">
      <p class="h5 bold c-primary">scribunus</p>
      <p class="h4 light c-dim ">/</p>
      <p class="h5 light c-grey">lectern</p>
    </header>

  </body>
</html>