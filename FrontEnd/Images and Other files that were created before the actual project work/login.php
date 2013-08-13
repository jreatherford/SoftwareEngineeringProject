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
    </head>

    <body>
        <div id="head-wrap" >
            <div id="main-head">
                <table width="100%">
                    <tr>
                        <td width="32%" height="199">
                            <a href="index.html"> 
                                <img src="UNAlogo.png" alt="UNA logo"  style="border-style: none"/>
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
                                        <td><input type="text" ></input></td>
                                        <td><input type="text" ></input></td>
                                        <td><a href=""><img src="loginbutton.png" onmouseover ="this.src='loginbuttononhover.png'" onmouseout="this.src='loginbutton.png'" style="border-style: none"/> </a> </td>
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
                    <a class="linkoptions" href="login.php">LOGIN</a>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <a class="linkoptions" href="">CONTACT</a>
                </td>
            </tr>
		</table>
        </div>
    </body>
</html>