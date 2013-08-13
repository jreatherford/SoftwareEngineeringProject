<?php
$_ENV['DIRECTORY'] = "test\\";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Faculty Welcome Page - CSIS Scheduling</title>
        <link rel="stylesheet" type="text/css" href="cssFiles/account.css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
			    <div id="header_left">
                    <img src="images/account-bkg.png" />
				</div>
				<div id="header_right" align="center">
                    	<a href="logut.php"> <img src="images/logoutButton.png" onmouseover ="this.src='images/logoutButtonHover.png'" onmouseout="this.src='images/logoutButton.png'" style="border-style: none" /></a>
				</div>
            </div>

			<div id="headings">
			    <table>
				    <tr>
					    <td style="padding-left:420px; padding-right:270px;">
                            <p id="heading_COB">UNA College of Business Admin Page</p>
						</td>
						<td>
                            <p>Patricia Roden</p>
						</td>
					</tr>
				</table>
			</div>

            <div id="left_column">
			    <br />
                <table width="210px" id="table_left_top" cellpadding="5" border="1">
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
                            <a id="current" href="prerequisites.php">PREREQUISITE</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="facultyAccounts.php">FACULTY ACCOUNTS</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a id="not_current" href="adminhomepage.php">SCHEDULING RULES</a>
                        </td>
                    </tr>
                </table>
				<table width="210px" id="table_left_bottom" cellpadding="5">
                    <tr>
                        <td>
                            <a id="not_current" href="adminhomepage.php">MY COURSES</a>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="middle_column">
  			    <br />
                                           <form name="text_input"  id="text_input"enctype="multipart/form-data" action="upload.php" method="POST">
                <div id="display_area" align="center">

                    <?php
                        $info = array();
                        $readFile = @fopen($_ENV['DIRECTORY'].'PR.dat', "r");
                        if ($readFile)
                        {
                            while (($buffer = fgets($readFile, 4096)) !== false)
                                $info[] = $buffer;

                            if (!feof($readFile))
                                echo "<Enter file info here>";

                            fclose($readFile);
                        }
                        echo "<textarea id='text_area_input' name='text_area_input' rows='20' cols='69'>";
                            foreach( $info as $entry )
                                echo $entry;
                        echo "</textarea>";
                    ?>


				</div>
				<div id="save_discard_buttons">
				    <br />
                                           <input type="hidden" name="input_type" value="PR">
                                <input type="Submit" class="" id="changeSubmit" value="Submit"/>
					<img src="images/discardChangesButton.png" />
                                        </div>
                                </form>

				<div>
				    <br />
					<br />
                                          <form name="file_input" id="file_input" enctype="multipart/form-data" action="upload.php" method="POST">
					    <input type="hidden" name="input_type" value="PR">
						<input id="browseButton" name="file" type="file" size="60" value="Browse File"/>
						<br />
                        <input type="Submit" class="" id="changeSubmit" value="Submit"/>
                                          </form>
					<br />
					<br />
					<br />
					<br />
				</div>
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
				<a id="bottom_links" href="prerequisites.php">PREREQUISITE</a> |
				<a id="bottom_links" href="facultyAccounts.php">FACULTY ACCOUNTS</a> |
				<a id="bottom_links" href="adminhomepage.php">SCHEDULING RULES</a> |
				<a id="bottom_links" href="adminhomepage.php">MY COURSES</a>
			    <br />
				<br />
            </div>
		</div>
    </body>
</html>
