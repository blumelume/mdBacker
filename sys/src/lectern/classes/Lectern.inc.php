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

  protected function loopPageDir( $parent = '' ) {
    $filename = basename(getcwd());
    
    $pages = '';
    if ($parent !== '' ) {
      if (!file_exists($filename.'.json')) {
        return '';
      }
      $pages .= '<li class="file" id="pages/'.$parent.'"><button>'.$filename.'</button>';
    }

    $dir = glob('*');
    $ulOpen = false;
    for ($i = count($dir)-1; $i >= 0; $i--) {
      $c = $dir[$i];

      if (is_dir($c)) {
        chdir($c);

        if (!$ulOpen && $parent !== '') {
          $pages .= '<ul>';
          $ulOpen = true;
        }
        $pages .= $this->loopPageDir( (($parent == '') ? '' : $parent.'/' ).$c );

        chdir('../');
      }
    }
    if ($ulOpen) {
      $pages .= '</ul>';
      $ulOpen = false;
    }
    $pages .= ($parent !== '') ? '</li>' : '';

    return $pages;
  }

  public function displayPages() {
    $prevDir = getcwd();
    chdir(locPages);

    $pages = '<ul class="content">'.$this->loopPageDir().'</ul>';
    echo $pages;

    chdir($prevDir);
  }

}
?>