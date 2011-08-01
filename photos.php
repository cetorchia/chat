<?php

  //
  // Small picture-uploader-displayer app. Put it in an iframe,
  // and see your visitors.
  //
  // (c) 2010 Carlos E. Torchia / licenced under GNU GPL v2 (fsf.org)
  // Use at your own risk, no warranty.
  //

  define("IMAGE_DIRECTORY","images");
  define("REFRESH_PERIOD",300);
  define("IMAGE_HEIGHT",96);

  header('Expires: 0');
  header('Refresh: '.REFRESH_PERIOD);

  if(isset($_FILES['image'])&&($_FILES['image']['tmp_name'])) {

    // Save file

    $tmp_filename=$_FILES['image']['tmp_name'];
    $prefix=IMAGE_DIRECTORY.'/';
    $filename=$_FILES['image']['name'];
	if(isset($_REQUEST["author"])) {
		$new_basename = $_REQUEST["author"];
	}
	else {
	    $new_basename = sha1(basename($filename));
	}
    $suffix = (preg_match('/(\..*?)$/',$filename,$matches)) ? $matches[1] : '';
    $new_outputname=$prefix.$new_basename.$suffix;

    move_uploaded_file($tmp_filename,$new_outputname);

  }

?>

<html>
<body>

<p>
<?php

  // Display the files.

  $dh = opendir(IMAGE_DIRECTORY);

  while(($filename = readdir($dh)) != null) {
    if(preg_match('/([^\.]+\.[^\.]+?)$/',$filename)) {
      echo "<img height=\"".IMAGE_HEIGHT."\" src=\"".IMAGE_DIRECTORY."/$filename\" />\n";
    }
  }

  closedir($dh);

?>
</p>

<p>
<form method="post" enctype="multipart/form-data">
Your photo:&nbsp;<input type="file" name="image" />
<input type="submit" value="upload" />
</form>
</p>

</body>
</html>
