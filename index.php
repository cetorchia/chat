<?php

require_once('def.php');
require_once(WEB_ROOT.'/lib/magic-quotes.php');
require_once(WEB_ROOT.'/lib/filedate.php');

/*
 * Handle request parameters
 */

$suffix = "";
$yw_suffix = "";

if(isset($_REQUEST["author"]))
{
  if (isset($_POST["author"])) {
    $author = $_POST["author"];
  }
  else {
    $author = $_REQUEST["author"];
  }
  $suffix .= ($suffix=="") ? "?" : "&";
  $suffix .= "author=".urlencode($author);
  setcookie("author",$author,time()+1000000);
}

if(isset($_REQUEST["message"]))
{
  $message = $_REQUEST["message"];
  $suffix .= ($suffix=="") ? "?" : "&";
  $suffix .= "message=".urlencode($message);
}

if(isset($_REQUEST["page"]))
{
  $page = $_REQUEST["page"];
  $suffix .= ($suffix=="") ? "?" : "&";
  $suffix .= "page=".$page;
}

if(isset($_REQUEST["y"]))
{
  $y = $_REQUEST["y"];
  $suffix .= ($suffix=="") ? "?" : "&";
  $suffix .= "y=".$y;
  $yw_suffix .= "y=".$y."&";
}

if(isset($_REQUEST["w"]))
{
  $w = $_REQUEST["w"];
  $suffix .= ($suffix=="") ? "?" : "&";
  $suffix .= "w=".$w;
  $yw_suffix .= "w=".$w."&";
}

/*
 * Start off the HTML
 */

header('Expires: 0');

echo "<html>";

echo "<head>";

echo "<meta http-equiv=\"Expires\" content=\"0\" />";
echo "<link rel=\"StyleSheet\" href=\"style.css\" type=\"text/css\" />";
echo "<title>Torchia Sawicki Chat Room</title>";

echo "</head>";

echo "<body>";

echo "<div id=\"content\">";

/*
 * Header section
 */

echo "<div id=\"header\">";
echo "<h1>Torchia Sawicki Chat Room</h1>";

echo "</div>";

/*
 * Chat section
 */

echo "<div id=\"chat_section\" class=\"section\">";

echo "<form method=\"post\" action=\"index.php\">";
echo "Name: <input name=\"author\" type=\"text\" value=\"".$author."\" /><br />";
echo "<input style=\"width:80%\" type=\"text\" name=\"message\" autocomplete=\"off\" />";
echo "<input style=\"width:20%\" type=\"submit\" value=\"submit\" />";
echo "</form>";

echo "<p>";
echo "<a href=\"index.php?".prevFileDate($y,$w)."\">Previous week</a> &nbsp;";
echo "<a href=\"index.php?${yw_suffix}page=".($page+1)."\">&lt;&lt; Back</a>";
echo "<a style=\"margin-left:60%\" href=\"index.php?${yw_suffix}page=".($page-1)."\">Forward &gt;&gt;</a>";
echo "&nbsp; <a href=\"index.php?".nextFileDate($y,$w)."\">Next week</a>";
echo "</p>";

echo "<iframe id=\"chat\" src=\"chat.php$suffix\"></iframe>";

echo "<div id=\"people\" class=\"section\">";
echo "<iframe id=\"photos\" src=\"photos.php\"></iframe>";
echo "</div>";

echo "</div>";

echo "<div id=\"notice\">";

echo "<p>";
echo "<i><b>Note to x10hosting staff</b></i>: this chat script does <b>not</b> ";
echo "use the MySQL database, just flat files,";
echo "and only four people use it. I've been told this ";
echo "is okay.</p>";

echo "<i><b>Note: any problems, please";
echo "<a href=\"javascript:window.location.reload()\">refresh</a>";
echo "(i.e. reload) the page!</b></i>";
echo "<br/>";
echo "<i><b>WARNING:</b></i> Do not reveal any private information like ";
echo "debit card number, address, etc. Please communicate this ";
echo "information over a more secure medium!";
echo "</p>";

echo "</div>";

echo "<div id=\"copyright\" class=\"section\">";
echo "&copy; 2010 Carlos E. Torchia";
echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";

