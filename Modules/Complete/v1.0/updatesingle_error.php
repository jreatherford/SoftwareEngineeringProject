<!--
********************************************************************************
Creater: Wenhao Wang
********************************************************************************
April 22 2013
********************************************************************************
This page is to show the wrong message and update the faculty's password and
then return to faculty's page.
********************************************************************************
-->

<?php
include('functions.php');
session_start();
$row = Get_user($_SESSION['user_id']);
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
                    	<a href="login.php"> <img src="images/logoutButton.png" onmouseover ="this.src='images/logoutButtonInverted.png'"
                                                  onmouseout="this.src='images/logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <p align="center"></p>
        
    <form id="f" action="do_editsingle.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $row['user_id'];?>" />
    <table border="0">
        <tr>
            <td>Username: </td>
            <td><?php echo $row['username'];?>
                <input type="hidden" name="username" id="username"
                       value="<?php echo $row['username'];?>"/></td>
        </tr>
        <tr>
            <td>Old Password: </td>
            <td><input type="password" name="oldpassword" id="oldpassword"
                       value="" maxlength="9"/></td>
        </tr>
        <tr>
            <td><input type="hidden" name="password" id="password"
                       value="<?php echo $row['password']?>"/></td>
        </tr>
        <tr>
            <td>New Password: </td>
            <td><input type="password" name="newpassword" id="newpassword"
                       value="" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Check Password: </td>
            <td><input type="password" name="checkpassword" id="checkpassword"
                       value="" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><?php echo $row['email'];?>
                <input type="hidden" name="email" id="email"
                       value="<?php echo $row['email'];?>"/></td>
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