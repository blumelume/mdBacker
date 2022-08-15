<?php
class Component {
  public $name;
  public $template;
  protected $config;
  protected $locSetup;
  protected $locFields;

  function __construct( $name, $path, $parent = null, $fields = null ) {
    $this->path = $path;
    $this->name = $name;
    
    $this->parent = $parent;
    $this->fields = $fields;

    $this->setup();
    $this->setupFields();

    return true;
  }

  /*
  parseSetup()
  * parsing setup.json
  * setting template and config
  */
  protected function setup() {
    $this->setup = new Config(
      ($this->parent !== null) ? $this->parent->setup->path : $this->path.'/'.$this->name.'.json'
    );
    $this->config = new Config(
      (($this->parent !== null) ? locComponents.$this->name : locConfigs.$this->setup->data['config']) . '.json'
    );
    $this->template = locTemplates. (($this->parent !== null) ? $this->config->data['template'] : $this->setup->data['template']) .'.php';
  }

  protected function setupFields() {
    foreach ( $this->config->data['fields'] as $field=>$attr ) {
      $this->$field = $this->parseField( $field, $attr );
    }
  }

  protected function getParentList() {
    $parentList = array();
    $p = $this->parent;
    while ($p !== null) {
      array_push($parentList, $p->name);
      $p = $p->parent;
    }
    return $parentList;
  }

  /*
  getFieldData()
  * getting data for a given field from the corresponding file
  * currently supported file-types: Markdown(md), JSON(json), Component(comp), HTML(html)
  */
  protected function parseField( $field, $attr ) {
    $fieldRequired = $attr['required'];
    $fieldType = $attr['type'];

    $fieldsArray = ($this->fields === null) ? $this->setup->data['fields'] : $this->fields;
    $fieldsArray = ($fieldType === 'comp') ? $fieldsArray[$field] : $fieldsArray;

    // $parents = $this->getParentList();
    // if ($fieldType === 'comp') {
    //   for($i = 0; $i < count($parents)-1; $i++) {
    //     $fieldsArray = $fieldsArray[$p];
    //   }
    //   //$fieldsArray = $fieldsArray[$field];
    // }

    if ($fieldType !== 'comp') {
      if (!array_key_exists($field, $fieldsArray)) {
        if ($fieldRequired) {
          return 'Field-Error: Data to a required field "'.$field.'" could not be found.<br>';
        }
        return;
      }

      $fieldContent = $fieldsArray[$field];
    }

    /*
    todo:
    field->content can be path to file

    if (gettype($fieldContent) === 'string') {
      if ( file_exists($fieldContent) ){ // content is path to file
        $fieldContent = file_get_contents( $fieldContent );
      }
    }
    */

    switch ($fieldType) { 
      case 'md': // File is Markdown -> parse with Parsedown
        return $GLOBALS['pd']->text( $fieldContent );

      case 'json': // File is JSON -> json_decode
        return $fieldContent;

      case 'html':
        return $fieldContent;

      case 'comp': // File is Component -> create and return Object
        $c = new Component( $field, locPages, $this, $fieldsArray );
        if (!$c) {
          throw $c;
        }
        return $c;
      
      case 'int':
        if (!filter_var($fieldContent, FILTER_VALIDATE_INT)) {
          throw new FieldTypeException( $fieldType, $fieldContent );
        }
        return $fieldContent;

      case 'plain':
        return $fieldContent;

      default: // File-type unknown
        throw new FieldTypeException( $fieldType, $fieldContent );
        return;
    }
  }

  public function insert() {
    // echo '<strong>'.$this->name.'</strong>: ';
    // var_dump($this);
    // echo '<br><br>';
    include_once( $this->template );
  }
}
?>