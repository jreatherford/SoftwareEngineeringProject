<?php
    session_start();
    if( !isset($_SESSION['user']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    }

    if( @$_SESSION['primary'] == 1 )
        $is_primary_admin = 1;
    else
        $is_primary_admin = 0;

    include "pref_table.php";

    $_SESSION['DIRECTORY'] = "test\\";

    $instructor = new faculty();
    $instructor->name = $_SESSION['name'];
    $instructor->hour = $_SESSION['hours'];

    include('functions.php');
    $rows = Get_singleuser($_SESSION['username']);
?>
<!-- Faculty Homepage -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Faculty Home Page</title>
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

            <div id="left_column" align="center">
			    <p>Minimum Hours : <?php echo $instructor->hour; ?></p>
				<p><div id="curr_hours">Current Hours : ?</div></p>
				<br />
				<br />
				<br />
				<br />
				<br />
                <?php
                    if(!$is_primary_admin)
                        echo "<!--";
                ?>
                    <a id="not_current" href="adminhomepage.php">SCHEDULE<br/> MANAGEMENT</a>
               <?php
                    if(!$is_primary_admin)
                        echo "-->";
                ?>

            </div>

            <div id="middle_column">
			    <div align="center">
                    <h2>Faculty Home Page</h2>
				    <p>PREFERENCES FOR:
                                    <?php echo substr($_SESSION['DIRECTORY'], 0, strlen($_SESSION['DIRECTORY'])-1); ?></p>
				</div>
                <div align='center'>
				<?php
				    build_pref_table("facultyhomepage.php" , $instructor);
				?>
				<script>
				    hour_div = document.getElementById("curr_hours");
				    hour_div.innerHTML = "Current Hours : <?php print_instructor_hours($instructor);?>";
                                </script>
                </div>

                <br />
                <br />
                <br />
                <br />
                <br />

            </div>

			<div id="right_sidebar" align="center">
                <br />
			    <p><?php echo $instructor->name; ?></p>
                            <?php
                                    foreach($rows as $row)
                                    {
                                        echo '<a href="updatesingle.php?user_id='.$row['user_id'].'">Change Password</a>';
                                    }
                            ?>
                <br />
                <br />
                <br />
                <br />
                <a href="addClass.php" ><img src="images/addClassButton.png">  </a>
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

            <div id="footer">
			    <a id="bottom_links" href="adminhomepage.php">SCHEDULE MANAGEMENT</a>
            </div>

        </div>
    </body>
</html>