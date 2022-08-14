<?php
chdir( $_SERVER['DOCUMENT_ROOT'] );
require('sys.php');

if (!isset($_GET['p'])) {
  die('this page could not be found!');
}

$pagePath = $_GET['p'];
$pagePath = (mb_substr($pagePath, -1) !== '/') ? $pagePath : substr($pagePath, 0, -1); // removing trailing slash (if existing)
$pagePathArray = explode('/', $pagePath);
$pageName = $pagePathArray[ count($pagePathArray)-1 ];

chdir(locPages);
foreach( $pagePathArray as $page ) {
  
  if (! chdir($page) ) {
    die( 'this page could not be found' );
  }

}
chdir(ROOTPATH); // Changing back to the system-root

/*
Setting up the page
*/
$page = new Page(
  $pageName,
  locPages.$pagePath
);
$page->insert();
?>