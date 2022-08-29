<?php
namespace mdBacker\cabinet\classes;

class Field {

  public string $name;
  public bool $required;
  public string $type;
  public $content;

  function __construct($name, $required, $type, $content) {
    $this->name = $name;
    $this->required = $required;
    $this->type = $type;
    $this->content = $content;
  }

}
?>