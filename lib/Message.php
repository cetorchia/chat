<?php

require_once('def.php');
require_once(WEB_ROOT.'/lib/text.php');

class Message {

  var $author;
  var $date;
  var $message;

  // Construct the object
  function Message($author,$message,$date = null) {

    // Set the author and the message
    $this->author = $author;
    $this->message = $message;

    // Set the date to the current if not spec'd
    if(!isset($date)) {
      $date = time();
    }
    $this->date = $date;

  }

  // Displays the message as a row of a table
  function	display()
  {
	$date = display_date($this->date);
    echo "<tr class=\"message\"> ";
    echo "<td class=\"message_info\"><div class=\"top_zero\">";
    echo "<b>".htmlspecialchars($this->author)."</b>";
    if($date != "") {
      echo "<br /><span class=\"message_date\">".htmlspecialchars($date)."</span>";
    }
    echo "</div></td>";
    echo "<td class=\"message_body\">".get_formatted($this->message)."</td>";
    echo "</tr>\n";
  }
}

// Get the display date according to how it's stored
function display_date($date)
{
	if(is_numeric($date))
	{
		$diff = time() - $date;

		$min = $diff / 60;
		$hrs = $min / 60;
		if($hrs >= 1)
		{
			$days = $hrs / 24;
			if($days >= 1)
			{
				return round($days) . " days ago";
			}
			else
			{
				return round($hrs) . " hours ago";
			}
		}
		else
		{
			return round($min) . " minutes ago";
		}
	}

	else
	{
		return $date;
	}
}

//
// Statically displays the chat messages formatted with HTML
//

function	display_messages($messages,$page=0)
{

  $n=count($messages);		// total messages
  $d=($page+1)*N;			// how far back this page begins
  $l=min($n-1,$n-$d+N-1);		// last
  $f=max($n-$d,0);			// first

  echo "<table class=\"messages\">\n";

  // If we are out of bounds, or if there are no messages, then say so.
  if(($f>$n-1)||($l<0)) {
    $noMsgs = new Message("admin","No messages");
    $noMsgs->display();
    return;
  }

  // If this is the start of the chat, then say so.
  if($f==0) {
    $startOfChat = new Message("admin","Start of chat");
    $startOfChat->display();
  }

  // Display the messages
  for($i=$f;$i<=$l;$i++) {
    $message = $messages[$i];
    $message->display();
  }

  echo "</table>\n";
}
