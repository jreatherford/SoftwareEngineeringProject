<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to update faculty's password, and check whether the new password
//match the check newpassword and check the oldpassword too. then return to
//faculty's page.
//******************************************************************************

include('functions.php');
session_start();
$a = $_POST['password'];
$b = $_POST['oldpassword'];
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['username'] = $_POST['username'];
$newpassword = $_POST['newpassword'];
$checkpassword = $_POST['checkpassword'];
if($newpassword == $checkpassword && $b == $a){
    if (Identify_password($a) && Identify_password($newpassword)){
        $_POST['password'] = $newpassword;
        Update_row($_POST);
        header('Location:facultyHomepage.php');
    }
    else
        header("Location:updatesingle_error.php");
}
else
    header("Location:updatesingle_error.php");
?>
