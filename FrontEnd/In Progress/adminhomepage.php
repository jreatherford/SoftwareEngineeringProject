<!--Admin (also has Faculty priviledges) Home Page-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Faculty Welcome Page - CSIS Scheduling</title>
        <link rel="stylesheet" type="text/css" href="account.css" />
        <script type="text/javascript" src="js/adminPage.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    </head>

    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <div id="head">
            <table width="100%">
                <tr>
                    <td width="75%">
                        <img src="account-bkg.png" />
                    </td>
                    <td width="25%">
                    	<a href="logut.php"> <img src="logoutButton.png" onmouseover ="this.src='logoutButtonInverted.png'" onmouseout="this.src='logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>

        <div id="elements">

                <table>
                    <tr>
                        <td colspan="2" align="center"> <h2>UNA College of Business Admin Page</h2>
                        </td>
                        <td>
                          <label>
                            <blockquote>
                              <p>Welcome</p>
                            </blockquote>
                          </label>
                        </td>
                    </tr>
                    <tr class="spacebetweencells">
                        <td>
                            <br />
                             <div id="left_column">
                                <table id="table_left_top" width="230" cellpadding="5">
                                    <tr>
                                        <td>
                                            <a onload="color='#DB9F11'" href="adminhomepage.php">CLASS TIMES</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="adminhomepage.php">ROOMS</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          <a href="adminhomepage.php">COURSES</a>
                                        </td>
                                    </tr>
                                  <tr>
                                        <td>
                                            <a href="adminhomepage.php">COURSE CONFLICTS</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="adminhomepage.php">PREREQUISITE</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="adminhomepage.php">SCHEDULING RULES</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="adminhomepage.php">FACULTY ACCOUNTS</a>
                                        </td>
                                    </tr>
                                </table>
                               <table width="230" id="table_left_bottom" cellpadding="15">
                                    <tr>
                                        <td>
                                            <a href="adminhomepage.php">MY COURSES</a>
                                        </td>
                                    </tr>
                                </table>
                               <p>&nbsp;</p>
                               <p>&nbsp;</p>
                               <p>&nbsp;</p>
                               <p>&nbsp;</p>
                               <p>&nbsp;</p>
                          </div>
                        </td>
                        <td>
                            <table width="591" height="373">
                                <tr>
                                    <td id="colarea" colspan="4">
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="155">
                                       <img src="saveChangesButton.png" />
                                    </td>
                                    <td width="141">
                                        <img src="discardChangesButton.png" />
                                    </td>
                                    <td width="127"></td>
                                    <td width="148"></td>
                                </tr>
                                <tr class="inputsource">
                                    <td>
                                        <label>Browse File:</label>
                                    </td>
                                </tr>
                                 <form enctype="multipart/form-data" action="upload.php" method="POST">
                                    <tr>
                                      <td colspan="2">
		 					       
	        							<input name="file" type="file" id="file" size="70"/>
									    

                                      </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" value="Submit File" />
                                        </td>
                                    </tr>
                                </form>
                            </table>
                      </td>
                        <td>
                            <table id="right">
                                <tr class="spacebetweensubcells">
                                    <td>
                                        <a href="createSchedule.php"><img src="createScheduleButton.png" /></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="adminhomepage.php" ><img src="viewEditScheduleButton.png" /></a>
                                    </td>
                                </tr>
                            </table>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                        </td>
                    </tr>
                </table>
        </div>
    </body>
</html>