<?php

include "File_Readers.php";

//first make sure the file could be uploaded
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error in uploading file: " . $_FILES["file"]["error"] . "<br>";
  }
  
  
//get all the info from the calling page
$tmp_file = $_FILES["file"]["tmp_name"];
$input_type = $_POST["input_type"];
$file = file_get_contents($tmp_file);
$error;

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
  case "FM":
      $reader = new Faculty_File_Reader($file);
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
    move_uploaded_file($tmp_file, DIRECTORY.$input_type.".dat");
    echo"File Uploaded Sucessfully";  
}
else
{
 echo "File not uploaded.  File contained the following errors:<br>";
 foreach ($error as &$curr_error)
     echo "$curr_error<br>";
}
?>
