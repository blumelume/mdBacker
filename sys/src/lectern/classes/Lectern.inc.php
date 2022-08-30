<?php
namespace mdBacker\lectern\classes;

class Lectern {

  function __construct() {
    $this->parseUrl();
  }

  public function compileScss( $scss ) {
    $this->css = $GLOBALS['scssParser']->compileString( $scss )->getCss();
    return $this->css;
  }

  protected function parseUrl() {
    if (!isset($_GET['p'])) {
      header('HTTP/1.1 404 Not Found');
      die();
    }
    
    $url = str_replace('lectern', '', $_GET['p']); // removing 'lectern' from url
    $url = (substr($url, 0, 1) == '/') ? substr($url, 1) : $url; // removing leading slash
    $url = (substr($url, -1, 1) == '/') ? substr($url, 0, -1) : $url; // remove trailing slash
    $url = explode('/', $url);

    $this->section = $url['0'];
    switch ($this->section) {
      case 'pages':
        $pagePath = implode('/', array_slice($url, 1));

        \mdBacker\sys\requireFilesFromLoader(locSys.'src/cabinet', 'classes');
        
        require_once ROOTPATH.'/vendor/autoload.php';
        $GLOBALS['mdParser'] = new \Parsedown();

        $this->object = new \mdBacker\cabinet\classes\Page( $url[count($url)-1], locPages.$pagePath.'/' );
    }
  }

  public function insert() {
    switch ($this->section) {
      case 'pages':
        require_once(locSys.'src/lectern/templates/pages.inc.php');
    }
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