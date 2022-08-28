<?php
namespace mdBacker\cabinet\classes;

class Component {
  public $name;
  public $template;
  public $config;

  function __construct( $name, $path, $fields = null ) {
    $this->path = $path;
    $this->name = $name;
    
    $this->fields = $fields;

    $this->fieldList = array();
    $this->setup();
    $this->setupFields();
  }

  // check if specified file is a system default
  function determineDefault( $file ) {
    return substr($file, 0, 3) === 'def';
  }

  /*
  setup()
  * setup the component
  * find and instantiate setup-file, config and template 
  * when component has a parent (is not a page)
    * the parents setup-file and is used
    * the config is looked up in the components-dir
    * the template is determined by the config, instead of the setup-file
  */
  protected function setup() {
    $this->setup = new \mdBacker\cabinet\classes\Config( $this->path.$this->name.'.json' );

    $this->config = $this->setup->data['config'];
    $this->config = new Config( 
      ($this->determineDefault($this->config) ? locDef.'configs/' : locConfigs) . $this->setup->data['config'] . '.json'
    );

    $this->template = $this->setup->data['template'];
    $this->template = (($this->determineDefault($this->template)) ? locDef.'templates/' : locTemplates) . $this->template .'.php'; 
  }

  protected function setupFields() {
    foreach ( $this->config->data['fields'] as $field=>$attr ) {
      $this->$field = $this->parseField( $field, $attr );
      array_push($this->fieldList, $field);
    }
  }

  /*
  parseField()
  * determining the value of a given field
  * according to different data-types
  * currently supported types: md(Markdown), json, html, int(INTEGER), plain
  */
  protected function parseField( $field, $attr ) {
    $fieldRequired = $attr['required'];
    $fieldType = $attr['type'];

    $fieldsArray = ($this->fields === null) ? $this->setup->data['fields'] : $this->fields;
    $fieldsArray = ($fieldType === 'comp') ? $fieldsArray[$field] : $fieldsArray;

    if ($fieldType !== 'comp') {
      if (!array_key_exists($field, $fieldsArray)) {
        if ($fieldRequired) {
          throw new FieldException(300, [$field]);
        }
        return;
      }

      $fieldContent = $fieldsArray[$field];

      if (gettype($fieldContent) === 'string') {
        $prevDir = getcwd();
        chdir( $this->path );
        if ( file_exists($fieldContent) ){ // content is path to file
          $fieldContent = file_get_contents( $fieldContent );
        }
        chdir($prevDir);
      }
    }

    switch ($fieldType) { 
      case 'md': // File is Markdown -> parse with Parsedown
        return $GLOBALS['mdParser']->text( $fieldContent );

      case 'json': // File is JSON -> json_decode
        return $fieldContent;

      case 'html':
        return $fieldContent;

      case 'comp': // File is Component -> create and return Object
        $c = new \mdBacker\cabinet\classes\Module( $field, locPages, $this->setup, $fieldsArray );
        return $c;
      
      case 'int':
        if (!filter_var($fieldContent, FILTER_VALIDATE_INT)) {
          throw new FieldException( 200, [$fieldType, $fieldContent] );
        }
        return $fieldContent;

      case 'plain':
        return $fieldContent;

      default: // File-type unknown
        throw new FieldException( 100, [$fieldType] );
        return;
    }
  }

  public function insert() {
    include_once( $this->template );
  }
}
?>