<?php
    session_start();
    if( !isset($_SESSION['admin']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    }

    $_SESSION['DIRECTORY'] = "test\\";
    define('SCHEDULE_FILE',"schedule.dat");

    $username = $_SESSION['username'];
    $instructor_name = $username;
    $is_primary_admin = $_SESSION['primary'];
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
                            <a id="not_current" href="account_management.php">ACCOUNT MANAGEMENT</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="current" href="">SCHEDULING RULES</a>
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
                

                    <?php
                        include_once "edit_semesters.php";
                        include_once "edit_schedule_prefs.php";
                        print_rules_form('schedulingRules.php');
                        echo "<br><br><br>";
                        build_semester_table ('schedulingRules.php');
    
                    ?>

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
                <?php
                    if( !@file_exists($_SESSION['DIRECTORY'].SCHEDULE_FILE) )
                        echo "<!--";
                ?>
                    <a href="view_edit_schedule.php" ><img src="images/viewEditScheduleButton.png" /></a>
                <?php
                    if( !@file_exists($_SESSION['DIRECTORY'].SCHEDULE_FILE) )
                        echo "-->";
                ?>
			</div>

            <div id="footer">
                <a id="bottom_links" href="adminhomepage.php"> CLASS TIMES </a> |
				<a id="bottom_links" href="rooms.php"> ROOMS </a> |
				<a id="bottom_links" href="courses.php">COURSES</a> |
				<a id="bottom_links" href="courseConflict.php">COURSE CONFLICTS</a> |
				<a id="bottom_links" href="prerequisites.php">PREREQUISITES</a> |
				<a id="bottom_links" href="account_management.php">ACCOUNT MANAGEMENT</a> |
				<a id="bottom_links" href="">SCHEDULING RULES</a>
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
