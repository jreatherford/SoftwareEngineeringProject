<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to update faculty and admin's information. Then return to amdin
//page.
//******************************************************************************

include('functions.php');
session_start();
$a = $_POST['password'];
$_SESSION['user_id'] = $_POST['user_id'];

if (Identify_password($a)){
    Update_row($_POST);
    header('Location:account_management.php');
}
else
    header("Location:update_error.php");
?>
