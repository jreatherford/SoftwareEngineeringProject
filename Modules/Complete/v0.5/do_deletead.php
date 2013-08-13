<?php
//******************************************************************************
//do_deletead
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to delete the admin's account information according to their
//ids. Then return to admin page.
//******************************************************************************
include('functions.php');
$admin_id=$_GET['admin_id'];

Delete_rowad($admin_id);
header('Location:admin.php');
?>
