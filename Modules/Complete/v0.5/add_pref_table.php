<?php
//******************************************************************************
//    James Reatherford
//******************************************************************************
//    Created on: 4/24/13
//    Last Edit on: 4/27/13
//******************************************************************************
//    This file builds a table that allows faculty to add new prefrences.
//    
//    This file only sends out the information on the new prefrence through
//    a series of POST[] messages and DOES *NOT* CHANGE THE PREFRENCE FILE.
//    
//    In order to update the information, this information must be POSTed to
//    a page containing a prefrence table.  (The only parameter for the only
//    function of this file is the location of this page)
//    
//   REQUIREMENTS:
//   
//   This file makes used of the following files:
//   * "images/submitButton.png"
//   * DIRECTORY.INFO_FILE (defined in scanner_helper.php)
//   
//******************************************************************************
include_once "scanner_helper.php";
include_once "structures.php";

//******************************************************************************
//    Function: build_add_pref_table
//    Description: Does all the work of building an add prefrence table
//    Input: The name of the html page that contains the prefrence table being
//           updated.
//    Returns: 0 on exit
//******************************************************************************
function build_add_pref_table($location)
{

    //Create the form and draw the header.
    echo ("
        <div align ='center'>
        <form action='$location' method='post'>
        <table cellspacing='10' cellspacing='50' align=center>
        <th width='10px' align='center'></th>
        <th width='80px' align='left'>Name</th>
        <th width='50px' align='left'>Hours</th>
        <th width='100px' align='left'>Preference</th></table>

        <div style='height:450px;width:375px;overflow:auto;' align='center'>
    ");

    //get the courses
    $raw_course = unserialize(@file_get_contents(DIRECTORY.INFO_FILE));
    if ($raw_course !== false)
        $raw_course = $raw_course->course_list;
    else
    {
        echo "Error!  Cannot find course information <br>";
        echo "<a href='$location'>back</a>";
        return 0;
    }

    //filer out duplicate classes
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

        //invisible header. (Used for alignment purposes)
        echo "<th width=\"10px\"></th> 
              <th width=\"80px\" align=\"left\">
              <th width=\"50px\" align=\"left\"></th> 
              <th width=\"100px\" align=\"left\"></th>";

    }

    //close the table, print the submit button, and close the form.
    echo('</table>
        </div><br>
        <input type="image" src="images\submitButton.png">
        </form>
    ');
}

?>