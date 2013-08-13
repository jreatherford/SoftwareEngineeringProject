<?php

error_reporting(E_ERROR | E_PARSE);

include "File_Readers.php";

//first make sure the file could be uploaded
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error in uploading file: " . $_FILES["file"]["error"] . "<br>";
  }

//get all the info from the calling page
$tmp_file = $_FILES["file"]["tmp_name"];
$input_type = $_POST["input_type"];
if( isset($_POST[text_area_input]) )
{
    echo "<br>READ FROM TEXT<br>";
    $file = $_POST[text_area_input];
}
else
{
    echo "<br>READ FROM FILE<br>";
    $file = file_get_contents($tmp_file);
}

//create the file reader
switch ($input_type)
{
  case "AR":
      $reader = new Room_File_Reader($file);
      break;
  case "CF":
      $reader = new Conflict_File_Reader($file);
      break;
  case "CT":
      $reader = new Times_File_Reader($file);
      break;
  case "CL":
      $reader = new Course_File_Reader($file);
      break;
  case "PR":
      $reader = new Prereq_File_Reader($file);
      break;

}

//try to read the file
$error = $reader->Scan_File();

//this if statement is clunky because FM is the only file_reader that
//does not return 0 on success
if ((($error == 0) && ($input_type != "FM")) ||
 ((is_string($error[0]) == false) && ($input_type == "FM")))
{
    //move_uploaded_file($tmp_file, DIRECTORY.$input_type.".dat");
    echo"File Uploaded Sucessfully<br />";
    file_put_contents( DIRECTORY.$input_type.".dat", $file );
}
else
{
 echo "File not uploaded.  File contained the following errors:<br />";
 foreach ($error as &$curr_error)
     echo "$curr_error<br />";
}



switch($input_type)
{
  case "AR":
      echo"<a href='rooms.php' ><img src='images/goback.png'/></a>";
      break;
  case "CF":
      echo"<a href='courseConflict.php' ><img src='images/goback.png'/></a>";
      break;
  case "CT":
      echo"<a href='adminhomepage.php' ><img src='images/goback.png'/></a>";
      break;
  case "CL":
      echo"<a href='courses.php' ><img src='images/goback.png'/></a>";
      break;
  case "PR":
      echo"<a href='prerequisites.php' ><img src='images/goback.png'/></a>";
      break;
}
?>