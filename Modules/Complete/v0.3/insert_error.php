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
                                                  onmouseout="this.src='images/logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <p align="center"></p>
        
<form action="do_insert.php" method="post">
    <table>
        <tr>
            <td>Username: </td>
            <td><input type="text" name="username" id="username"/></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="password" id="password"/></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><input type="text" name="email" id="email"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" id="submit" value="Create"/></td>
        </tr>
    </table>
</form>
</body>
</html>
<?php  echo "<script>alert('The password is ilegal, please input again!') </script>"; ?>