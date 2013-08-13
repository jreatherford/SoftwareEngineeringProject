<!--
********************************************************************************
admin
********************************************************************************
April 22 2013
********************************************************************************
This is the administrator page for mange the faculty and their own account's
information and security.
********************************************************************************
-->
<?php include('functions.php'); ?>
<?php $rows = Get_users(); 
       $rowsad = Get_admin();
?>

<?php
/*
include("File_Readers.php");
$var = file_get_contents("file.txt");

$reader = new Faculty_File_Reader($var);

$faculty = $reader->Scan_File();

foreach($faculty as $info){
    //echo '<tr><td>'.
      //      $info->name.'</td><td>'.$info->year_of_service.
        //    '</td><td>'.$info->email.'</td><td>'.
          //  $info->hour.'</td><tr>';
    $name = $info->name;
    $yos = $info->year_of_service;
    $email = $info->email;
    $hour = $info->hour;
            Insert_file($name, $yos, $email, $hour);
}*/
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <!--<link type="text/css" rel="stylesheet" href="style.css" />-->
        <link rel="stylesheet" type="text/css" href="account.css" />
    </head>
    <!--<body id="b1" style="text-align:center;">-->
        <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <div id="head">
            <table width="100%">
                <tr>
                    <td>
                        <img src="images/account-bkg.png" />
                    </td>
                    <td>
                    	<a href="login.php"> <img src="images/logoutButton.png"
                       onmouseover ="this.src='images/logoutButtonInverted.png'"
                       onmouseout="this.src='images/logoutButton.png'"
                       style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <p align="center"></p>
<table style="text-align:center;">
    <tr><th>Management</th><th>Username</th><th>Password</th><th>Email</th><th>Hour</th>
        <th>Year of service</th></tr>
<?php
foreach($rows as $row){
    echo '<tr><td>';
    echo '<a onclick="return confirm(\'Are you sure?\')"';
    echo ' href="do_delete.php?user_id='.
            $row['user_id'].'">Delete</a>';
    echo ' | <a href="update.php?user_id='.
            $row['user_id'].'">Edit</a>';
    echo ' | <a href="reset.php?user_id=' .
            $row['user_id'].'">Reset</a>';
    echo '</td><td>'.
            $row['username'].'</td><td>'.$row['password'].
            '</td><td>'.$row['email'].'</td><td>'.$row['hours'].
            '</td><td>'.$row['year_of_service'].'</td></tr>';
}
?>
</table>    
        <form action = "insert.php" method = "post" style="text-align:left;">
            <input type ="submit" value ="Add new Account"></form>

<table style="text-align:center;">    
    <tr><th>Admin ID</th><th>Admin name</th><th>Password</th><th>Email</th></tr>
<?php
    foreach($rowsad as $row) {
        echo '<tr><td>';
        echo '<a onclick="return confirm(\'Are you sure?\')"';
        echo 'href="do_deletead.php?admin_id='.
                $row['admin_id'].'">Delete</a>';
        echo ' | <a href="updatead.php?admin_id='.
                $row['admin_id'].'">Edit</a>';
        echo '</td><td>'.
                $row['admin_name'].'</td><td>'.$row['password'].
                '</td><td>'.$row['admin_email'].'</td></tr>';
    }
?>
</table>

</body>
</html>