<?php

require_once(WEB_ROOT.'/lib/Message.php');

define('MESSAGE_DELIMETER',"\n");
define('MESSAGE_TERMINATOR',"\n");
define('MESSAGE_MAX_SIZE',16384);

class ChatFile {

  var $filename;
  var $messages = array();

  // Constructor
  function ChatFile($y,$w)
  {
    $this->filename = $this->getFilename($y,$w);
  }

  // Gets message array
  function getMessages() {
    return($this->messages);
  }

  // Adds a message structure to the array.
  function addMessage($message) {
    if(isset($message)) {
      $this->messages[] = $message;
    }
  }

  // Clears all the messages
  function clear() {
    $this->messages = array();
    $this->addMessage(new Message("admin","The chat document is now cleared."));
  }

  // Gets the string associated with a message structure.
  function getMessageStr($message) {

    // Generate the string from the message fields
    $str = $message->author  . MESSAGE_DELIMETER .
           $message->date    . MESSAGE_DELIMETER .
           $message->message . MESSAGE_TERMINATOR;

    return($str);
  }

  // Gets the message structure associated with a string.
  function getMessage($h) {
    // Get the fields from the current record
    $message_author  = fgets($h, MESSAGE_MAX_SIZE);
    $message_author  = substr($message_author, 0, strlen($message_author)-1);
    $message_date    = fgets($h, MESSAGE_MAX_SIZE);
    $message_date    = substr($message_date, 0, strlen($message_date)-1);
    $message_message = fgets($h, MESSAGE_MAX_SIZE);
    $message_message  = substr($message_message, 0, strlen($message_message)-1);

    // Build the message object from the fields
    $message = null;
    if ($message_message || $message_date || $message_author) {
      $message = new Message($message_author,$message_message,$message_date);
    }

    return($message);
  }

  // Loads the messages from the file
  function load()
  {
    if(!file_exists($this->filename)) {
      $this->clear();
      $this->save();
    }

    else {
      $h = fopen($this->filename,"r+");
      if($h == FALSE) return(FALSE);

      while(!feof($h)) {
        $this->addMessage($this->getMessage($h));
      }

      fclose($h);
    }

    return(TRUE);
  }

  // Gets the message filename
  function getFilename($y,$w)
  {
    // The caller could have given us any number of 0s, assuming
    // the parameters can be strings or integers.
    $y = sprintf("%04d", $y);
    $w = sprintf("%02d", $w);
    return WEB_ROOT."/messages/$y-$w";				// By year, week.
  }

  // Saves the messages to the file
  function save() {

    $h = fopen($this->filename,"w+");
    if($h == FALSE) return(FALSE);

    foreach($this->messages as $message) {
      $n = fwrite($h,$this->getMessageStr($message));
    }

    fclose($h);

    return(TRUE);
  }

}
