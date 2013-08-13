<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add Class - Class Scheduling</title>
        <link rel="stylesheet" type="text/css" href="account.css" />
    </head>
    
<body>
        <div id="head">
            <table width="100%">
                <tr>
                    <td width="76%">
                        <img src="account-bkg.png" />
                    </td>
                    <td width="24%">
                    	<a href="logut.php"> <img src="logoutButton.png" onmouseover ="this.src='logoutButtonInverted.png'" onmouseout="this.src='logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        
        <div align="center">
            <table width="937" height="73">
                <tr>
                    <td width="73">
                        <a href="facultyhomepage.php" >FACULTY HOME PAGE</a>
                    </td>
                    <td width="100">
                        <?php
                            include 'add_pref_table.php';
                            build_add_pref_table("facultyhomepage.php");
                        ?>
                    </td>
                </tr>   
            </table>
        </div>
    </body>
</html>