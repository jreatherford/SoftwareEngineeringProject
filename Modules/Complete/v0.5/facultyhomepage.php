<?php

include "pref_table.php";

//TEMPORARY
$instructor = new Faculty();
$instructor->name = "saget, bob";
$instructor->hour = 12;
    
 ?>

<!--Faculty Homepage-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Faculty Welcome Page - CSIS Scheduling</title>
        <link rel="stylesheet" type="text/css" href="account.css" />
    </head>

    <body>
        <div id="head">
            <link rel="stylesheet" type="text/css" href="cssFiles/account.css">
            <table width="100%">
                <tr>
                    <td width="76%">
                        <img src="account-bkg.png" />
                    </td>
                    <td width="24%">
                    	<a href="logut.php"> <img src="images/logoutButton.png" onmouseover ="this.src='images/logoutButtonInverted.png'" onmouseout="this.src='images/logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="left_column" >
          <table width="1148">
                <tr>
                    <td width="230" height="67"  align="center">
                        <label> <br />
                          <br />
                        Minimum Hours : <?php echo $instructor->hour; ?></label>
                    </td>
                    <td width="676" height="67"  align="center">
                      <h1>&nbsp;</h1>
                      <h1>UNA College of Business Faculty Page</h1>
                    </td>
                    <td width="226" height="67">
                      <label><br />
                        <br />
                      Welcome</label>
                    </td>
                </tr>
                <tr>
                    <td height="66" align="center">
                        <p>
                          <div id='curr_hours'><label>Current Hours : ? </label></div>
                        </p>
                        <p>&nbsp;</p></td>
                    <td align="center">
                        <h2>CLASSES FOR THE SEMESTER</h2>
                        <p>&nbsp;</p>
                    </td>
                    <td>
                        <p>
                          <label>Name of the Faculty</label>
                        </p>
                        <p>&nbsp;</p>
                    </td>
              </tr>
              <tr>
                  <td align="center">
                        <a href="adminhomepage.php">SCHEDULE MANAGEMENT</a>
                  </td>
                  <td align="center">
<!--
                      <table width="583">

                          <tr>
                              <th width="100">
                                  Course
                              </th>
                              <th width="123">
                                  Preference
                              </th>
                              <th width="125">
                                  Class Size
                              </th>
                              <th width="82">
                                  Room
                              </th>
                              <th width="129">
                                  Action
                              </th>
                          </tr>
                          <tr>
                              <td align="center">
                                  CS 155
                              </td>
                              <td align="center">
                                  <select>
                                      <option></option>
                                      <option>Morning</option>
                                      <option>Midday</option>
                                      <option>Evening</option>
                                  </select>
                              </td>
                              <td align="center">
                                    40
                                </td>
                                <td align="center" >
                                    C
                                </td>
                                <td align="center">
                                    <select>
                                        <option></option>
                                        <option>DROP</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    CS 410W
                                </td>
                                <td width="123"align="center">
                                    <select>
                                        <option></option>
                                    </select>
                                </td>
                                <td width="125"align="center">
                                    40
                                </td>
                                <td width="82" align="center">
                                    C
                                </td>
                                <td align="center">
                                    <select>
                                        <option></option>
                                        <option>DROP</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                              <td height="85" colspan="5" align="left">
                                  <img src="images/saveChangesButton.png" />
                              </td>
                          </tr>
                        </table>
-->
                    <?php
                        build_pref_table("facultyhomepage.php", $instructor);
                    ?>
                        <script> 
                            hour_div = document.getElementById("curr_hours");
                            hour_div.innerHTML = "Current Hours: <?php print_instructor_hours($instructor); ?>";
                       </script>
                    </td>
                    <td>
                        <a href="addClass.php" ><img src="images/addClassButton.png">  </a>
                    </td>
                </tr>
            </table>
        </div>
        <div align="center">
          <p>Note: The table displayed above is just an example. Preference table will be implemented when the input verification modules are completed.</p>
        </div>
</body>
</html>
