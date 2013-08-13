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
session_destroy();
header('Location:login.php');
?>
