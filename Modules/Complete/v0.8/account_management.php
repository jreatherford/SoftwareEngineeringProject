<!--
********************************************************************************
Creater: Wenhao Wang
********************************************************************************
April 22 2013
********************************************************************************
This is the administrator page for mange the faculty and their own account's
information and security.
********************************************************************************
-->

<?php
    session_start();
    if( !isset($_SESSION['admin']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    }

    $_ENV['DIRECTORY'] = "test\\";

    $username = $_SESSION['username'];
    $instructor_name = $username;
    $is_primary_admin = $_SESSION['primary'];

    include('functions.php');
    $rows = Get_users();
    $rowsad = Get_admin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Home Page</title>
        <link rel="stylesheet" type="text/css" href="cssFiles/account.css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
			    <div id="header_left">
                    <img src="images/account-bkg.png" />
				</div>
				<div id="header_right" align="center">
                    	<a href="logout.php"> <img src="images/logoutButton.png" onmouseover ="this.src='images/logoutButtonHover.png'" onmouseout="this.src='images/logoutButton.png'" style="border-style: none" /></a>
				</div>
            </div>

            <div id="headings">
                <table>
                    <tr>
					<td style="padding-left:420px; padding-right:270px;">
                            <p id="heading_COB"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Admin Home Page</p>
						</td>
						<td>
                            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $instructor_name; ?></p>
						</td>
					</tr>
				</table>
			</div>

            <div id="left_column">
			    <br />
                <table width="250px" id="table_left_top" cellpadding="5" border="1">
                    <tr>
                        <td>
                            <a id="not_current" href="adminhomepage.php">CLASS TIMES</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="rooms.php">ROOMS</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="courses.php">COURSES</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="courseConflict.php">COURSE CONFLICTS</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="prerequisites.php">PREREQUISITES</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="current">ACCOUNT MANAGEMENT</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="schedulingRules.php">SCHEDULING RULES</a>
                        </td>
                    </tr>
                </table>
                <?php
                    if(!$is_primary_admin)
                        echo "<!--";
                ?>
				<table width="250px" id="table_left_bottom" cellpadding="5">
                    <tr>
                        <td>
                            <a id="not_current" href="facultyhomepage.php">MY COURSES</a>
                        </td>
                    </tr>
                </table>
                <?php
                    if(!$is_primary_admin)
                        echo "-->";
                ?>
            </div>

            <div id="middle_column">
                <br />



<table style="text-align:center;" cellspacing ="10">
    <tr><th>Management</th><th>Username</th><th>Name</th><th>Password</th><th>Email</th><th>Hour</th><th>Year of service</th></tr>
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
            $row['username'].'</td><td>'.$row['name'].
            '</td><td>'.$row['password'].
            '</td><td>'.$row['email'].'</td><td>'.$row['hours'].
            '</td><td>'.$row['year_of_service'].'</td></tr>';
}
?>
</table>
        <form action = "insert.php" method = "post" style="text-align:left;">
            <input type ="submit" value ="Add new Account"></form>

<br/>
<br/>

<table style="text-align:center;" cellspacing ="10">
    <tr><th>Admin ID</th><th>Admin name</th><th>Password</th><th>Email</th></tr>
<?php
    foreach($rowsad as $row) {
        echo '<tr><td>';
        echo '<a href="updatead.php?admin_id='.
                $row['admin_id'].'">Edit</a>';
        echo '</td><td>'.
                $row['admin_name'].'</td><td>'.$row['password'].
                '</td><td>'.$row['admin_email'].'</td></tr>';
    }
?>
</table>

<br/>
<br/>
Upload Faculty Members File:
<br/>
<br/>

<form action="upload_file.php" method="post" enctype="multipart/form-data"
      name ="file_input" id ="file_input">
    <input id="browseButton" name="file" type="file" size="60" value="Browse File" />
    <input type="hidden" name="input_type" value="FM"><br>
    <input type="submit" class ="" id ="changeSubmit"  value="Submit">
</form>



                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
            </div>


			<div id="right_sidebar" align="center">
                <br />
                <br />
                <br />
                    <a href="createSchedule.php"><img src="images/createScheduleButton.png" /></a>
                <br />
				<br />
				<br />
                <a href="adminhomepage.php" ><img src="images/viewEditScheduleButton.png" /></a>

			</div>

            <div id="footer">
                <a id="bottom_links" href="adminhomepage.php"> CLASS TIMES </a> |
				<a id="bottom_links" href="rooms.php"> ROOMS </a> |
				<a id="bottom_links" href="courses.php">COURSES</a> |
				<a id="bottom_links" href="courseConflict.php">COURSE CONFLICTS</a> |
				<a id="bottom_links" href="prerequisites.php">PREREQUISITES</a> |
				<a id="bottom_links" href="">ACCOUNT MANAGEMENT</a> |
				<a id="bottom_links" href="schedulingRules.php">SCHEDULING RULES</a>
                <?php
                    if(!$is_primary_admin)
                        echo "<!--";
                ?>
                                |
				<a id="bottom_links" href="facultyhomepage.php">MY COURSES</a>
               <?php
                    if(!$is_primary_admin)
                        echo "-->";
                ?>
			    <br />
				<br />
            </div>
		</div>
    </body>
</html>
