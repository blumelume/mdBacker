<?php
namespace mdBacker\cabinet\classes;

class Config {
  
  public $path;
  public $content;
  public $data;

  function __construct($path) {
    $this->path = $path;
    $this->content = file_get_contents( $this->path );
    $this->decode();
  }

  function decode() {
    $this->data = json_decode($this->content, true);
  }

}
?>