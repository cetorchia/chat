<?php

define('DEFAULT_LOG_FILE',WEB_ROOT.'/log/errors.log');

class Logger {

  var $filename;

  function Logger($filename = DEFAULT_LOG_FILE) {
    $this->filename = $filename;
  }

  // Generates a nice error message based on the errno/error string
  function getErrorHtml($errno,$errstr,$file,$line) {

    switch($errno) {
      case E_WARNING:
      case E_USER_WARNING:
        $type = "Warning";
        break;
      case E_NOTICE:
      case E_USER_NOTICE:
        $type = "Notice";
        break;
      default: 
        $type = "Error";
        break;
    }

    return "<div class=\"error\"><b>$type:</b> $errstr on line $line in $file</div>\n";
  }

  // Generates an error message that is suitable for a log file
  function getErrorStr($errno,$errstr,$file,$line) {
    return date('r')." [$errno] $errstr\n";
  }

  // Writes the error to the log file, and displays it.
  function write($errno,$errstr,$file,$line)
  {
    // Write it out too.
    echo $this->getErrorHtml($errno,$errstr,$file,$line);

    // Try to open the log file
    $h = fopen($this->filename,"a");

    // If we couldn't, then cry for help and die.
    if($h == FALSE) {
      echo "<b><i>Help!</i></b> No log file!";
      die();
    }

    // Now write the message to the file and close it.
    fwrite($h,$this->getErrorStr($errno,$errstr,$file,$line));
    fclose($h);
  }

  // Use this to handle errors with set_error_handler()
  function handleError($errno, $errstr,$file,$line)
  {
    $this->write($errno,$errstr,$file,$line);
    die();
  }

  // Set the error handler to this
  function setErrorHandler()
  {
    set_error_handler(array(&$this,'handleError'));
  }

}
