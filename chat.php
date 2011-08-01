<?php

  // PHP Chat server.
  // Sort of like a IRC/forum combo
  //
  // (c) 2010 Carlos E. Torchia
  // Use at your own risk
  // Licensed under GNU GPL v2 (fsf.org)
  //

  require_once('def.php');
  require_once(WEB_ROOT.'/lib/magic-quotes.php');
  require_once(WEB_ROOT.'/lib/Logger.php');
  require_once(WEB_ROOT.'/lib/Message.php');
  require_once(WEB_ROOT.'/lib/ChatFile.php');

  define("N",10);

  //
  // Set up some error handling
  //

  $logger = new Logger();
  $logger->setErrorHandler();

  //
  // Load the chat file.
  // Get the messages from the chat file
  //

  $y = isset($_GET["y"]) ? $_GET["y"] : gmdate('Y');
  $w = isset($_GET["w"]) ? $_GET["w"] : gmdate('W');
  $chat_file=new ChatFile($y, $w);
  $chat_file->load();
  $messages=$chat_file->getMessages();

  //
  // First, submit chat message parameters.
  //

  if(isset($_GET["author"]) && isset($_GET["message"])) {

    // Add the message and save the file
    $chat_file->addMessage(new Message($_GET["author"],$_GET["message"]));
    $chat_file->save();

    header("Location: chat.php");
  }

  //
  // Display the messages
  //

  header("Expires: 0");
  header("Content-Type: text/html");
  header("Refresh: 10");

  echo "<html>\n";
  echo "<head>\n";
  echo "<link rel=\"StyleSheet\" href=\"style.css\" type=\"text/css\" />";
  echo "</head>\n";

  echo "<body>\n";

  // Display the messages of the specified page

  if(isset($_GET['page'])) {
    display_messages($messages,$_GET['page']);
  }

  else {
    display_messages($messages);
  }

  echo "</body>\n";

  echo "</html>\n";
