<!--
********************************************************************************
Creater: Wenhao Wang
********************************************************************************
April 22 2013
********************************************************************************
This page is to update the faculty's information. Then return to admin
management page.
********************************************************************************
-->

<?php
include('functions.php');
$row=  Get_user($_GET['user_id']);
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

    <form id="f" action="do_edit.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $row['user_id'];?>" />
    <table border="0">
        <tr>
            <td>Username: </td>
            <td><input type="text" name="username" id="username"
                       value="<?php echo $row['username'];?>"/></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="password" id="password"
                       value="<?php echo $row['password'];?>" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><input type="text" name="email" id="email"
                       value="<?php echo $row['email'];?>"/></td>
        </tr>
        <tr>
            <td>Minimum Hours: </td>
            <td><input type="text" name="hours" id="hours"
                       value="<?php echo $row['hours'];?>"/></td>
        </tr>
        <tr>
            <td>Years of Service: </td>
            <td><input type="text" name="year_of_service" id="year_of_service"
                       value="<?php echo $row['year_of_service'];?>"/></td>
        </tr>
        <tr>
            <td>&nbsp; </td>
            <td><input type="submit" id="submit" value="Update Info"/></td>
        </tr>
    </table>
    </form>
</body>
</html>
