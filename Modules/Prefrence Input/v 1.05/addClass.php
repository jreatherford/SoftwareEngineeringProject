<?php
    include "pref_table.php";
    include 'add_pref_table.php';
	
	//TEMPORARY
	$instructor = new faculty();
	$instructor->name = "saget, bob";
        //$instructor->name = "hayter, david";
	$instructor->hour = 12;
	
?>
<!-- Faculty Homepage -->
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

            <div id="left_column" align="center">
			    <p>Minimum Hours : <?php echo $instructor->hour; ?></p>
				<p><div id="curr_hours">Current Hours : <?php print_instructor_hours($instructor);?></div></p>
				<br />
				<br />
				<br />
				<br />
				<br />
                    <a id="not_current" href="adminhomepage.php">SCHEDULE<br/> MANAGEMENT</a>
            </div>

            <div id="middle_column">
			    <div align="center">
                    <h2>UNA College of Business Faculty Page</h2>
				    <p>CLASSES FOR THE SEMESTER</p>
				</div>
                <div align='center'>
				<?php
                                    build_add_pref_table("facultyhomepage.php");
				?>
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