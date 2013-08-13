<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add Class - Class Scheduling</title>
        <link rel="stylesheet" type="text/css" href="account.css" />
    </head>

<body>
        <div id="head">
            <table width="100%">
                <tr>
                    <td width="76%">
                        <img src="account-bkg.png" />
                    </td>
                    <td width="24%">
                    	<a href="logut.php"> <img src="logoutButton.png" onmouseover ="this.src='logoutButtonInverted.png'" onmouseout="this.src='logoutButton.png'" style="border-style: none" /></a>
                    </td>
                </tr>
            </table>
        </div>
    <div align ="center">

        <form action="facultyhomepage.php" method="post">
            <table cellspacing="10" cellspacing="50" align=center>
             <th width="10px" align="center"></th>
             <th width="80px" align="left">Name</th>
             <th width="50px" align="left">Hours</th>
             <th width="100px" align="left">Preference</th></table>

            <div style="height:450px;width:375px;overflow:auto;" align="center">
            <?php
                include "scanner_helper.php";
                include "structures.php";

                //get the courses
                $raw_course = unserialize(file_get_contents(DIRECTORY.INFO_FILE));
                $raw_course = $raw_course->course_list;

                //filer out duplicated
                $course = array();
                foreach ($raw_course as $curr_course)
                {
                    if ($curr_course->section == "internet")
                        $course["$curr_course->name.i"] = $curr_course;
                    else
                        $course["$curr_course->name"] = $curr_course;
                }

                //create the table
                echo"<table cellspacing=\"10\" cellspacing=\"50\" align=center>";

                //for each course, write a new row
                foreach ($course as $curr_course)
                {

                    //create the radio button
                    if ($curr_course->section == "internet")
                        echo "<tr><td><input type=\"radio\" name=\"course_add\" value=\"$curr_course->name.i\"></td>";
                    else
                        echo "<tr><td><input type=\"radio\" name=\"course_add\" value=\"$curr_course->name\"></td>";

                    //print out the course info
                    echo "<td>$curr_course->name</td>";
                    echo "<input type=\"hidden\" name=\"$curr_course->name.h\" value=\"$curr_course->hours\">";
                    echo "<td>$curr_course->hours</td>";

                    //print out the prefrence options
                    if ($curr_course->section != "internet")
                    {
                        echo "<td> <select name=\"$curr_course->name\">";
                        echo "<option value=\"midday\"></option>";
                        echo "<option value=\"morning\">morning</option>";
                        echo "<option value=\"midday\">midday</option>";
                        echo "<option value=\"evening\">evening</option>";
                        echo "</select></td></tr>";
                    }
                    else
                    {
                        echo "<input type=\"hidden\" name=\"$curr_course->name.i\" value=\"internet\">";
                        echo "<td>Internet</td></tr>";
                    }

                //table header.  Used for alignment purposes
                echo "<th width=\"10px\"></th> <th width=\"80px\" align=\"left\"><th width=\"50px\" align=\"left\"></th> <th width=\"100px\" align=\"left\"></th>";

                }

                echo"</table>";
            ?>
            </div><br>
            <input type="image" src="submitButton.png">
        </form>
    </div>
    </body>
</html>