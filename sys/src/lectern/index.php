<?php
/**/

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <!-- head : external scripts -->

    <!-- head : internal scripts -->
    <script type='text/javascript'>
      <?php \mdBacker\sys\requireFilesFromLoader(__DIR__, 'headerScripts'); ?>
    </script>

    <!-- css -->
    <style type='text/css'>
      <?= $lectern->compileScss( '@import "'.__DIR__.'/css/global.scss"' ); ?>
    </style>
  </head>

  <body class='mdBacker lectern'>

    <header class='w1 header'>
      <h1 id='name'>scribunus</h1>
      <span class='diagonal light'></span>
      <span id='module'>lectern</span>
    </header>

    <main class='w1'>

      <nav id='main'>
        <div id='sections' class='accordion'>
          
          <div class='section' id='files'>
            <h2 class='label'>pages</h2>
            <?= $lectern->displayPages() ?>
          </div>

        </div>
      </nav>

      <div class='content'>
      </div>

    </main>


    <!-- footer : external scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- footer : internal scripts -->
    <script type='text/javascript'>
      <?php \mdBacker\sys\requireFilesFromLoader(__DIR__, 'footerScripts'); ?>
    </script>

  </body>
</html>