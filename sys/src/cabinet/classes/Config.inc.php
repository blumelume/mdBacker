<?php
namespace mdBacker\cabinet\classes;

class Config {
  
  public $path;
  public $data;

  function __construct($path) {
    $this->path = $path;
    $this->data = json_decode(
      file_get_contents( $this->path ),
      true
    );
  }

}
?>