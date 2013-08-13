<?php
//******************************************************************************
//do_insert
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to add a new account of faculty into database. Then return to
//admin page.
//******************************************************************************

include('functions.php');
session_start();
$a = $_POST['password'];
//$_SESSION['user_id'] = $_POST['user_id'];

if (Identify_password($a)){
    Insert_row($_POST);
    header('Location:admin.php');
}
else
    header("Location:insert_error.php");
?>
