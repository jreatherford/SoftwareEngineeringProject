<?php
include('functions.php');
$user_id=$_GET['user_id'];

delete_row($user_id);
header('Location:admin.php');
?>
