<?php

define('DEFAULT_LOG_FILE',WEB_ROOT.'/log/errors.log');

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
  echo getErrorHtml($errno,$errstr,$file,$line);
}

// Use this to handle errors with set_error_handler()
function handleError($errno, $errstr,$file,$line)
{
  write($errno,$errstr,$file,$line);
  die();
}

set_error_handler('handleError');

