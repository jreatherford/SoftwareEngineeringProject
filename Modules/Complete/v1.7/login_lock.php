<!--******************************************************************************
* File Name : login.php
* Purpose : This page contains login functionality through PHP and MySQL.
*           This file also loads the front page with following links to the
*           left side column of the page.
*
*           1) Link to Home page which references to the homepage
*           2) Link to Login page which takes the user to Login page
*           3) Link to Contact page which takes you to contact page
*******************************************************************************-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Class Scheduling - Login</title>
        <link rel="stylesheet" type="text/css" href="homepage.css" />
        <?php  echo "<script>alert(\"Account locked! Contact administrator to unlock.\") </script>"; ?>
    </head>

    <body>
        <form action="do_login.php" method="post" >
        <div id="head-wrap" >
            <div id="main-head">
                <table width="100%">
                    <tr>
                        <td width="32%" height="199">
                            <a href="index.html">
                                <img src="images/UNAlogo.png" alt="UNA logo"  style="border-style: none"/>
                            </a>
                        </td>
                        <td width="68%" colspan="3">
						    <div id="sub-head" class="subhead">
                                <table id="sub" cellpadding="0">
                                    <tr>
                                        <td><label>Username</label></td>
                                        <td><label>Password</label></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="username" id="username"></input></td>
                            <td><input type="password" name="password" id="password"></input></td>
                                        <td><input type="image" src="images/loginbutton.png" onmouseover ="this.src='images/loginbuttononhover.png'"
                                                            onmouseout="this.src='images/loginbutton.png'" style="border-style: none" id="submit" value="" /></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="links">
        <table width="227">
        	<tr>
                <td align="center">
                    <a class="linkoptions" href="index.html">HOME</a>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <a class="linkoptions" href="login.php">FACULTY LOGIN</a>
                </td>
            </tr>
		</table>
        </div>
      </form>
                    <div>
                <table width="106.5%">
                    <tr>
                        <td width="32%">
                            &nbsp;
                        </td>
                        <td width="68%">
                            SCHEDULE LINKS:<br/>
                            <table cellspacing="15">   
                              <?php
                                include_once "Structures.php";
                                foreach(scandir(SCHEDULES_DIR) as $dir)
                                {
                                    
                                    if( $dir != "." && $dir != ".." )
                                    {
                                        echo '<tr>';
                                            echo '<td>';
                                            echo '<a href="';
                                                echo SCHEDULES_DIR.$dir."/build_schedule.php";
                                                echo '">';
                                                echo $dir." (Schedule View)";
                                                echo "</a><br/>";
                                            echo '</td>';

                                            echo '<td>';
                                                echo '<a href="';
                                                echo SCHEDULES_DIR.$dir."/schedule.csv";
                                                echo '">';
                                                echo $dir." (Excel Download)";
                                                echo "</a><br/>";
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                              ?>
                          </table>
                      </td>
                  </tr>
                </table>
            </div>
    </body>
</html>