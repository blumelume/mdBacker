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
      $this->$field = $this->initField( $field, $attr );
      array_push($this->fieldList, $field);
    }
  }

  /*
  initField()
  * determining the value of a given field
  * from a given source (either $this->setup or a seperate dedicated file)
  */
  protected function initField( $fieldName, $fieldAttributes ) {

    $field = new \mdBacker\cabinet\classes\Field(
      $fieldName, 
      $fieldAttributes['required'], 
      $fieldAttributes['type'], 
      //$fieldContent
    );

    $fieldsArray = ($this->fields === null) ? $this->setup->data['fields'] : $this->fields;
    $fieldsArray = ($field->type === 'comp') ? $fieldsArray[$field->name] : $fieldsArray;

    if ($field->type !== 'comp') {

      if (array_key_exists($field->name, $fieldsArray)) {
        $field->content = $fieldsArray[$field->name];
      } else if ($field->required) {
        throw new FieldException(300, [$field->name]);
      }

      // check if content is filepath
      if (gettype($field->content) === 'string') {
        if ( file_exists($this->path.$field->content) ){ // content is path to file
          $field->content = file_get_contents( $this->path.$field->content );
        }
      }

    } else {
      $field->content = new \mdBacker\cabinet\classes\Module( $field->name, locPages, $this->setup, $fieldsArray );
    }

    return $field;
  }

  public function insert() {
    include_once( $this->template );
  }
}
?>