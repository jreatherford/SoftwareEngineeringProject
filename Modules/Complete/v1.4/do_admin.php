<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is to update the information of administrator. Then return to admin
//page.
//******************************************************************************

include('functions.php');
session_start();
$a = $_POST['password'];
$a2 = $_POST['passwordconf'];
$_SESSION['admin_id'] = $_POST['admin_id'];

if( $a != $a2 )
{
    $_SESSION['ERROR'] = 1;
    if( isset($_SESSION['primary']) )
        header('Location:updatead.php?admin_id=1');
    else
        header('Location:updatead.php?admin_id=2');
}
elseif (Identify_password($a))
{
    Update_admin($_POST);
    header('Location:account_management.php');
}
else
{
    $_SESSION['ERROR'] = 2;
    if( isset($_SESSION['primary']) )
        header('Location:updatead.php?admin_id=1');
    else
        header('Location:updatead.php?admin_id=2');
}
?>
