<?php include('functions.php'); ?>
<?php $rows = get_preference();

?>
<!DOCTYPE html>
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
                        <img src="account-bkg.png" />
                    </td>
                    <td>
                    	<a href="login.php"> <img src="logoutButton.png" onmouseover ="this.src='logoutButtonInverted.png'" onmouseout="this.src='logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <p align="center"></p>
<table style="text-align:center;">
    <tr><th>Preference ID</th><th>Faculty Name</th><th>Class Name</th><th>Preference</th></tr>
<?php
foreach($rows as $row){
    echo '<tr><td>'.$row['preference_id'].'</td><td>'.
            $row['faculty_name'].'</td><td>'.$row['class_name'].
            '</td><td>'.$row['preference'].'</td></tr>';
}
?>
</table>
</body>
</html>