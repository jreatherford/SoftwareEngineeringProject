<?php
//******************************************************************************
//do_delete
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to delete the faculty's account information according to their
//ids. Then return to admin page.
//******************************************************************************
include('functions.php');
$user_id=$_GET['user_id'];

Delete_row($user_id);
header('Location:admin.php');
?>
