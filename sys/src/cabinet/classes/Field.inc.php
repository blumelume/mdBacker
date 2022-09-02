<?php
namespace mdBacker\cabinet\classes;

class Field {

  public string $name;
  public bool $required;
  public string $type;
  public $content;

  function __construct($name, $required, $type, $content = null) {
    $this->name = $name;
    $this->required = $required;
    $this->type = $type;
    $this->content = $content;
  }

  function parse() {
    switch ($this->type) { 
      case 'md': // File is Markdown -> parse with Parsedown
        $this->content = $GLOBALS['mdParser']->text( $this->content );
        break;
      
      case 'int':
        if (!filter_var($this->content, FILTER_VALIDATE_INT)) {
          //throw new FieldException( 200, [$fieldType, $fieldContent] );
        }
        break;

      default: // nothing happens - the content stays unparsed / the same
        break;
    }
  }

}
?>