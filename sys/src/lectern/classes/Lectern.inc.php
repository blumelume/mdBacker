<?php
namespace mdBacker\lectern\classes;

class Lectern {

  function __construct() {
    $this->page = $this->parsePageFromUrl();
  }

  public function compileScss( $scss ) {
    $this->css = $GLOBALS['scssParser']->compileString( $scss )->getCss();
    return $this->css;
  }

  protected function parsePageFromUrl() {
    if (!isset($_GET['p'])) {
      header('HTTP/1.1 404 Not Found');
      die();
    }
    
    $p = str_replace('lectern', '', $_GET['p']); // removing 'lectern' from url
    $p = (substr($p, 0, 1) == '/') ? substr($p, 1) : $p; // removing leading slash
    $p = (substr($p, -1, 1) == '/') ? substr($p, 0, -1) : $p; // remove trailing slash
    return explode('/', $p);
  }

}
?>