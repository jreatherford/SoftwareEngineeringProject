<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to update the information of administrator. Then return to admin
//page.
//******************************************************************************

header('Location:account_management.php');
include('functions.php');
session_start();
$a = $_POST['password'];
$_SESSION['admin_id'] = $_POST['admin_id'];

if (Identify_password($a)){
    Update_admin($_POST);
    header('Location:account_management.php');
}
else
    header("Location:updatead_error.php");
?>
