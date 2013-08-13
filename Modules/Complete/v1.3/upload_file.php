<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to read the file, creat the username and temporary passowrd
//and import then into database.
//******************************************************************************
include('functions.php'); ?>

<!DOCTYPE html>
<?php

include("File_Readers.php");

$temp_file = $_FILES["file"]['tmp_name'];
$file = file_get_contents($temp_file);

define("DEFAULT_PASSWORD","leo!ini0");

$reader = new Faculty_File_Reader($file);
$faculty = $reader->Scan_File();

if( is_string($faculty[0]) == false )
{
    echo "<b><font size=\"30\" color=\"green\">File uploaded successfully.</b></font><br/>";
    foreach($faculty as $info){
        //echo '<tr><td>'.
        //      $info->name.'</td><td>'.$info->year_of_service.
            //    '</td><td>'.$info->email.'</td><td>'.
              //  $info->hour.'</td><tr>';
        $name = $info->name;
        $yos = $info->year_of_service;
        $email = $info->email;
        $hour = $info->hour;
        $username = Get_ename($email);
        $password = DEFAULT_PASSWORD;
        Insert_file($username, $name, $password, $yos, $email, $hour);
    }
}
else
{
    echo "<font size=\"30\" color=\"red\"><b>File not uploaded. File contained the following errors:<br />";
    foreach( $faculty as &$f)
        echo "$f<br />";
    echo "</b></font>";
}
?>
<html>
    <body>
        <br/><br/>
        <a href="account_management.php"><img src="images/goback.png"/></a>
    </body>
</html>

