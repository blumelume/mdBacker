<?php
namespace mdBacker\cabinet\classes;

class Page extends Component {
  function __construct( $name, $path = locPages ) {
    parent::__construct( $name, $path );
  }
}
?>