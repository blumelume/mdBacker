<?php
class ExceptionHandler {
  public static function handle( Exception $ex ) {
    die($ex);
  }
}
?>