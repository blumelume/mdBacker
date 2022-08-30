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

  function parse() {
    switch ($this->type) { 
      case 'md': // File is Markdown -> parse with Parsedown
        $this->content = $GLOBALS['mdParser']->text( $this->content );
        break;

      case 'comp': // File is Component -> create and return Object
        //$fieldContent = new \mdBacker\cabinet\classes\Module( $field, locPages, $this->setup, $fieldsArray );
        break;
      
      case 'int':
        if (!filter_var($this->content, FILTER_VALIDATE_INT)) {
          //throw new FieldException( 200, [$fieldType, $fieldContent] );
        }
        break;

      default: // File-type unknown
        //throw new FieldException( 100, [$fieldType] );
        break;
    }
  }

}
?>