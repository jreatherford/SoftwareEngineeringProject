<!--
********************************************************************************
Creater: Wenhao Wang
********************************************************************************
April 22 2013
********************************************************************************
This page is to show the wrong message and update the admin's information. Then
return to admin management page.
********************************************************************************
-->

<?php

include('functions.php');
session_start();
$rowid = Get_adminid($_SESSION['admin_id']);
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
        
        <form id="f" action="do_admin.php" method="post">
    <input type="hidden" name="admin_id"
           value="<?php echo $rowid['admin_id'];?>"/>
    <table border="0">
        <tr>
            <td>Admin_name: </td>
            <td><input type="text" name="admin_name" id="admin_name"
                       value="<?php echo $rowid['admin_name'];?>"/></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="password" id="password"
                       value="<?php echo $rowid['password'];?>" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Admin_Email: </td>
            <td><input type="text" name="admin_email" id="admin_email"
                       value="<?php echo $rowid['admin_email'];?>"/></td>
        </tr>
        <tr>
            <td>&nbsp; </td>
            <td><input type="submit" id="submit" value="Update Row"/></td>
        </tr>
    </table>
</form>
</body>
</html>
<?php  echo "<script>alert('The password is ilegal, please input again!') </script>"; ?>