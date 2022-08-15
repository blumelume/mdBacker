<?php
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
    $message = "[{$time}] {$ex->getMessage()}\n";
    
    // append to the error log
    error_log($message, 3, locLogs.'/errors.log');

    // show a user-friendly message
    echo $ex->getMessage(). '<br>';
  }
}
?>