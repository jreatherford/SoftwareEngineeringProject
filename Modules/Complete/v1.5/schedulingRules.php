<?php
    session_start();
    if( !isset($_SESSION['admin']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    }

    if (isset($_POST['new_dir']))
    {
        $_SESSION['DIRECTORY'] = $_POST['new_dir'] . '\\';
    }
    
    include_once "structures.php";
    $semester_dirs = unserialize(file_get_contents("semesters.dat"));
    if( $semester_dirs == FALSE )
    {
        $_SESSION['DIRECTORY'] = "Default_Semester\\";
    }
    elseif( !isset($_SESSION['DIRECTORY']) )
    {
        foreach( $semester_dirs as $s )
            if( $s->current == 'true' )
            {
                $_SESSION['DIRECTORY'] = $s->path . '\\';
                break;
            }
    }
    else
    {
        $_s = null;
        foreach( $semester_dirs as $s )
            if( $s->path . '\\' == $_SESSION['DIRECTORY'] )
            {
                $_s = $s;
                break;
            }
        
        if( $_s != null && $_s->current != 'true' )
        {
            foreach( $semester_dirs as $s )
                if( $s->current == 'true' )
                {
                    $_SESSION['DIRECTORY'] = $s->path . '\\';
                    break;
                }
        }
    }

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
                                
                                <div align="center"><br/><br/><br/><br/>
                    <b>Viewing Information For:</b>
                    <?php
                        echo "<form action='schedulingRules.php' method='post'>";
                        echo "<select name='new_dir'>";
                        foreach( $semester_dirs as $s )
                        {
                            if ($s->current == 'true')
                                echo "<option value='$s->path'";
                                if ($s->path  . '\\' == $_SESSION['DIRECTORY'])
                                    echo " selected='selected'";
                            echo ">$s->path</option>";
                        }
                        echo "</select><br><button>Change Semester</button>";
                        echo "</form>"

                    ?>
                                </div>
            </div>

            <div id="middle_column">
                <br />


                    <?php
                        echo "<h3>Edit Scheduling Rules:</h3>";
                        include_once "edit_semesters.php";
                        include_once "edit_schedule_prefs.php";
                        print_rules_form('schedulingRules.php');
                        echo "<br><br><br>";
                        echo "<h3>Edit Semesters:</h3>";
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
