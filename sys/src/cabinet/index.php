<?php
/**/

error_reporting(E_ALL);
ini_set("display_errors", 1);

require('../bootstrap.php');
\mdBacker\sys\includeClasses( __DIR__ );

require_once ROOTPATH.'/vendor/autoload.php';
$GLOBALS['mdParser'] = new Parsedown();

/**/

function getPageFromString( $string ) {
  $a = array(
    'path' => (mb_substr($string, -1) !== '/') ? $string : substr($string, 0, -1) // removing trailing slash (if existing)
  );
  $a['pathArray'] = explode('/', $a['path']);
  $a['name'] = $a['pathArray'][ count($a['pathArray'])-1 ];

  return $a;
}

if (!isset($_GET['p'])) {
   header('HTTP/1.1 404 Not Found');
   $pageObject = getPageFromString( '404' );
}

if ($_GET['p'] === '') { // root-directory to home-page
  \mdBacker\sys\redirect('home');
} else {
  $pageObject = getPageFromString( $_GET['p'] );
}

chdir(locPages);
foreach( $pageObject['pathArray'] as $page ) {

  if (!file_exists($page) ) {
    header('HTTP/1.1 404 Not Found');
    $pageObject = getPageFromString( '404' );
  }

}
chdir(ROOTPATH); // Changing back to the system-root


/*
Setting up the page
*/
$GLOBALS['page'] = new \mdBacker\cabinet\classes\Page(
  $pageObject['name'],
  locPages.$pageObject['path'].'/'
);
if ($page) {
  $page->parseFields( $page );
  $page->insert();
} else {
  throw $page;
}
?>