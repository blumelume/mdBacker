<?php
namespace mdBacker\cabinet\classes;

class Module extends \mdBacker\cabinet\classes\Component {
  function __construct( $name, $path, $setup, $fields) {
    $this->setup = $setup;
    parent::__construct( $name, $path, $fields );
    $this->setupFields();
  }

  protected function setup() {
    //$this->setup = new \mdBacker\cabinet\classes\Config( $this->parent->setup->path );

    $this->config = $this->setup->data['config'];
    $this->config = new Config(
      (($this->determineDefault($this->config)) ? locDef.'modules/'.$this->name : locComponents.$this->name) . '.json'
    );

    $this->template = $this->config->data['template'];
    $this->template = (($this->determineDefault($this->template)) ? locDef.'templates/' : locTemplates) . $this->template.'.php'; 
  }
}
?>