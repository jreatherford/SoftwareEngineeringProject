<?php
include('functions.php');
$row=  Get_user($_GET['user_id']);
$username = $row['username'];
setcookie($username, 0, time()-3600);
header('Location: admin.php');
?>
