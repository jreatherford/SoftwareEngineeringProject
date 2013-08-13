<?php
//******************************************************************************
//do_admin
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to update the information of administrator. Then return to admin
//page.
//******************************************************************************



header('Location:admin.php');
include('functions.php');
session_start();
$a = $_POST['password'];
$_SESSION['admin_id'] = $_POST['admin_id'];

if (Identify_password($a)){
    Update_admin($_POST);
    header('Location:admin.php');
}
else
    header("Location:updatead_error.php");
?>
