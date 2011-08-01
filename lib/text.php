<?php

  //
  // Let the user specify some formatting
  //
  // This is called the "whitelist" approach (contrary to "blacklist") 
  // where you do not risk possible threat by trusting potentially risky
  // allowed html.
  //

  function	get_formatted($string)
  {

    // Get it ready for HTML
    $string=htmlspecialchars($string);

    //
    // Generate hyperlinks
    //

    $string=preg_replace('/(http:\/\/([^\s\"]{1,20})[^\s\"]*[^\s.,;])/',
                         "<a href=\"$1\">$2</a>",$string);

    $string=preg_replace('/(https:\/\/([^\s\"]{1,20})[^\s\"]*[^\s.,;])/',
                         "<a href=\"$1\">$2</a>",$string);

    // Allow limited formatting with these tags

    $string=preg_replace('/\*([^\*\s][^\*]*[^\*\s]|[^\s\*])\*/',
                         "<b>$1</b>",$string);

    return($string);

  }

