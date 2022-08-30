<?php
namespace mdBacker\cabinet\classes;

class Page extends Component {
  function __construct( $name, $path = locPages ) {
    parent::__construct( $name, $path );
  }

  public function parseFields( $parentModule ) {
    foreach( $parentModule->fieldList as $f ) {

      $field = $parentModule->$f;
      $fieldContent = $field->content;
  
      if (is_a($fieldContent, 'mdBacker\cabinet\classes\Module')) {
        $this->parseFields($fieldContent);

      } else {
        $field->parse();
      }
    }
  }

}
?>