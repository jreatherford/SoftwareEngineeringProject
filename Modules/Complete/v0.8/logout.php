<?php
//******************************************************************************
//logout
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to make users logout and at the same, destroy the session and
//the information of the user. Then return to login page.
//******************************************************************************
session_start();
unset($_SESSION['username']);
unset($_SESSION['name']);
unset($_SESSION['primary']);
unset($_SESSION['admin']);
unset($_SESSION['user']);
unset($_SESSION['hours']);
session_destroy();
header('Location:login.php');
?>
