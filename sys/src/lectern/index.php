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
    <?= $lectern->compileScss( '@import "'.__DIR__.'/css/main.scss"' ); ?>
  </head>

  <body>

    <?php var_dump($lectern->page); ?>

  </body>
</html>