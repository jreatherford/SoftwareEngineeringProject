<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to let admin to unlock user's account.
//******************************************************************************
include('functions.php');
$row=  Get_user($_GET['user_id']);
$username = $row['username'];
setcookie($username, 0, time()-3600);
header('Location: account_management.php');
?>
