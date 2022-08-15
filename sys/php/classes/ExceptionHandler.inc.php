<?php
class FieldTypeException extends Exception {
  function __construct($type, $value) {
    $message = 'Field of type "'.$type.'" provided with value of type "'.gettype($value).'".';
    $code = 0;
    $previous = null;
    parent::__construct($message, $code, $previous);
  }
}
class PageException extends Exception {
  function __construct($code) {
    $previous = null;
    
    $message = ' '.$code.' - ';
    switch ($code) {
      case 404:
        $message .= 'The requested page could not be found.';
    }

    parent::__construct($message, $code, $previous);
  }
}

class ExceptionHandler {
  function __construct() {
    // Creating logs-location if not existing
    if (!file_exists(locLogs)) {
      mkdir(locLogs);
    }
    // Creating logs-file if not existing
    if (!file_exists(locLogs.'errors.log')) {
      fopen(locLogs.'errors.log', 'w');
    }
  }

  public static function handle( Exception $ex ) {
    date_default_timezone_set('Europe/Berlin'); // set default timezone
    $time = date('F j, Y, g:i a e O'); // get the current date & time

    // format the exception message
    $message = "[{$time}] {$ex->getMessage()} in {$ex->getFile()}:{$ex->getLine()}\n";
    
    // append to the error log
    error_log($message, 3, locLogs.'/errors.log');

    // show a user-friendly message
    echo get_class($ex).': '.$ex->getMessage(). '<br>';
  }
}
?>