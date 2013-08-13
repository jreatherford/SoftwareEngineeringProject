<!--
********************************************************************************
Creater: Wenhao Wang
********************************************************************************
April 22 2013
********************************************************************************
This page is to update the admin's information. Then return to admin
management page.
********************************************************************************
-->

<?php
    session_start();
    if( !isset($_SESSION['admin']) && !isset($_SESSION['admintemp']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    }

    if( isset($_SESSION['ERROR']) && $_SESSION['ERROR'] == 1 )
    {
        echo '<script type="text/javascript">
                alert("Passwords do not match!");
              </script>';
        unset($_SESSION['ERROR']);
    }

    if( isset($_SESSION['ERROR']) && $_SESSION['ERROR'] == 2 )
    {
        echo '<script type="text/javascript">
                alert("Passwords is invalid! Try again.");
              </script>';
        unset($_SESSION['ERROR']);
    }

include('functions.php');
$rowid= Get_adminid($_GET['admin_id']);
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
            <td>New Password: </td>
            <td><input type="password" name="password" id="password"
                       value="<?php echo $rowid['password'];?>" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Confirm Password: </td>
            <td><input type="password" name="passwordconf" id="passwordconf"
                       value="<?php echo $rowid['password'];?>" maxlength="9"/></td>
        </tr>
        <tr>
            <td>Admin_Email: </td>
            <td><input type="text" name="admin_email" id="admin_email"
                       value="<?php echo $rowid['admin_email'];?>"/></td>
        </tr>
        <?php
            if( $rowid['admin_id'] != '1' )
                echo "<!--";
        ?>
        <tr>
            <td>Minimum Hours: </td>
            <td><input type="text" name="hour" id="hour"
                       value="<?php echo $rowid['hour'];?>"/></td>
        </tr>
        <tr>
            <td>Years of Service: </td>
            <td><input type="text" name="year_of_service" id="year_of_service"
                       value="<?php echo $rowid['year_of_service'];?>"/></td>
        </tr>
        <?php
            if( $rowid['admin_id'] != '1' )
                echo "-->";
        ?>
        <tr>
            <td>&nbsp; </td>
            <td><input type="submit" id="submit" value="Update Row"/></td>
        </tr>
    </table>
</form>
</body>
</html>