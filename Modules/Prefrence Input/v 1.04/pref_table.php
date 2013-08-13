<?php
//******************************************************************************
//    James Reatherford
//******************************************************************************
//    Created on: 4/25/13
//    Last Edit on: 4/28/13
//******************************************************************************
//    This file builds a preference input table.  I also contains a function to
//    print an instructor's number of hours requested.
//    
//    NOTE: build_pref_table() and print_instructor_hours() are the only
//    functions that are intended for external use.  The other functions in
//    this file are intended only for use by these two external functions.
//        
//    This file reads input from POST messages.
//    The following infromation may be read in from POST[]:
//    --------------------------------------------------------------------------
//    Adding a Prefrence:
//    __________________
//    POST["course_add"]       - if a course is added, the name of the course is 
//                               placed here. (internet courses will have a .i 
//                               at the end of the course name. (eg, CS255.i)
//                               
//    POST[(course_name)]      - if a course is added, the post location for its
//                               name will contain the time prefrence for that
//                               course.  If it is an internet course, this will
//                               not be set.
//   
//   Changes to Prefrences:
//   _____________________
//   POST[(course_name)"_drop"] - If a course is dropped, its name plus "_drop"
//                                will contain "true".  Internet classes will
//                                have a _i at the end of their name.
//                                (eg., CS255_i_drop)
//   
//   POST[(course_name)"_pref"] - If a course's preference is changed, its name
//                                plus "_pref" will contain the new prefrence.
//                       
//   ---------------------------------------------------------------------------
//   REQUIREMENTS:
//   
//   This file makes used of the following files:
//   * "images/submitButton.png"
//   * DIRECTORY.INFO_FILE (defined in scanner_helper.php)
//   * DIRECTORY.PREF_FILE (defined in scanner_helper.php)
//   
//******************************************************************************

include_once "structures.php";
include_once "scanner_helper.php";

//******************************************************************************
//    Function: build_pref_table
//    Description: Does all the work of building a prefrence table
//    Input: The name of the html page that will contain the table
//    Returns: 0 on exit
//******************************************************************************
function build_pref_table($location, $instructor)
{
    //to be passed into the table
    $message = "";

    //get the courses
    $course_list = unserialize(@file_get_contents(DIRECTORY.INFO_FILE));
    if ($course_list === false)
    {
       echo "Error: Cannot find courses!<br>";
       return 0;
    }
    else
        $course_list = $course_list->course_list;

    //Get the prefrences from the prefrence file...
    //...and if the file does not exist, create it
    $pref_list = (@file_get_contents(DIRECTORY.PREF_FILE));
    if ($pref_list === FALSE)
        $pref_list = array();
    else
        $pref_list = unserialize($pref_list);

    //get the instructor's hours
    $curr_hours = get_instructor_hours ($instructor, $pref_list, $course_list);
    
    //check for new courses
    check_added_courses ($pref_list, $instructor, $message, $curr_hours);
    
    //print the table
    print_table ($location, $pref_list, $course_list, $instructor, $message);

    return 0;
}

//******************************************************************************
//    Function: print_instructor_hours
//    Description: Prints the number of hours an instructor has requested.
//                 (basically a wrapper for get_instructor_hours)
//    Input: The instructor
//    Returns: 0 on exit
//******************************************************************************
function print_instructor_hours ($instructor)
{
    
    //get the data
    $course_list = unserialize(@file_get_contents(DIRECTORY.INFO_FILE));
    $pref_list = (@file_get_contents(DIRECTORY.PREF_FILE));
    
    //error check
    if (($course_list === false) || ($pref_list === FALSE))
    {
       echo "ERROR";
       return 0;
    }
    //print the hours
    else
    {
        $course_list = $course_list->course_list;
        $pref_list = unserialize($pref_list);
        echo get_instructor_hours ($instructor, $pref_list, $course_list);
        return 0;
    }  
}

//******************************************************************************
//    Function: get_instructor_hours
//    Description: Gets the number of hours an instructor has requested
//    Input:    *The instructor currently logged in
//              *The list of prefrences
//              *this list of courses
//    Returns: The number of hours found for the instructor
//******************************************************************************
function get_instructor_hours ($instructor, $prefs, $course_list)
{
    $hours = 0;
    foreach ($prefs as $curr_pref)
    {
        if ($curr_pref->faculty_name == $instructor->name)
        {
            $curr_course = get_matching_course ($curr_pref, $course_list);
            if ($curr_course !== 0)
                $hours += $curr_course->hours;
        }
    }
    return $hours;
}

//******************************************************************************
//    Function: print_table
//    Description: Prints out the entire prefrences table
//    Input:  * The name of the html page that the table is being drawn in
//            * The list of prefrences
//            * The list of courses
//            * The instructor currently logged in
//            * A message to be displayed at the bottom of the table
//    Returns: 0 on exit
//******************************************************************************
function print_table($location, $pref_list, $course_list, $instructor, $message)
{
    //print out the table header
    echo ("
        <table>
        <form action='$location' method='post'>
        <tr>
          <th width='80'>Course</th>
          <th width='80'>Preference</th>
          <th width='80'>Class Size</th>
          <th width='80'>Hours</th>
          <th width='80'>Action</th>
        </tr>
    ");
    $changed = false;
    //for each prefrence in the table
    foreach ($pref_list as $key => $curr_pref)
    {
        //check to see if this is an internet class
        //(used for dropping classes)
        if ($curr_pref->time_pref == "internet")
           $internet_flag = "_i";
        else
           $internet_flag = "";
        
        //check for dropped class
        if (isset($_POST["$curr_pref->course_name"."$internet_flag"."_drop"]) &&
         ($_POST["$curr_pref->course_name"."$internet_flag"."_drop"] == "true"))
        {
               unset($pref_list[$key]);
               $changed = true;
               continue;
        }
        //check for changed time prefrences
        if (isset($_POST["$curr_pref->course_name"."_pref"]))
        {
           $changed_time = $_POST["$curr_pref->course_name"."_pref"];
           
           if (($changed_time != $curr_pref->time_pref) && 
              ($curr_pref->time_pref != "internet"))
            {
               $curr_pref->time_pref = $changed_time;
               $changed = true;
            }
        }
        
        //get the course
        if ($curr_pref->faculty_name == $instructor->name)
           print_row ($curr_pref, $course_list);
    }
 
    //update the file
    @file_put_contents(DIRECTORY.PREF_FILE, serialize($pref_list));
    
    if ($changed == true)
        $message = "Changed saved!";

    //print out the message
    echo("
        <tr>
            <td colspan='1'>
                <input type='image' src='images/submitButton.png'>
            </td>
            <td colspan='3'>
                $message
            </td>
       </tr>
       </form>
       </table>
     ");

    return 0;
}

//******************************************************************************
//    Function: print_row
//    Description: Prints a single row of the table
//    Input:   * The current prefrence
//             * The list of courses
//    Returns: 0 on exit
//******************************************************************************
function print_row ($pref, $course_list)
{
    //print out the course name field
    echo ("
        <tr>
        <td align='center'>
            $pref->course_name
        </td>
        <td align='center'>
    ");

    //Create the prefrence dropbox
    if($pref->time_pref == "internet")
        echo "internet";
    else
        echo "<select name ='{$pref->course_name}_pref'>";

     //add morning to the dropbox
     echo ("<option value ='morning' ");
     if ($pref->time_pref == "morning")
        echo " selected='selected'";
     echo(">morning</option>");

     //add midday to the dropbox
     echo ("<option value ='midday' ");
     if ($pref->time_pref == "midday")
        echo " selected='selected'";
     echo(">midday</option>");

     //add evening to the dropbox
     echo ("<option value ='evening' ");
     if ($pref->time_pref == "evening")
        echo " selected='evening'";
     echo(">evening</option>");

    //print the course size and hours 
    $course = get_matching_course ($pref, $course_list);
    if ($course !== 0)
    {
        echo ("
            </td><td align='center'>$course->size</td>
            <td align='center' >$course->hours</td><td align='center'>
        ");
    }
    else
    {
        echo "</td><td>ERROR</td><td>ERROR</td><td align='center'>";
        $message = "error finding class info";
    }

    //print out the "Drop" dropbox and close the row
    if ($pref->time_pref == "internet")
      echo "<select name ='{$pref->course_name}_i_drop'>";
    else
      echo "<select name ='{$pref->course_name}_drop'>";
    echo ("
      <option></option>
      <option value = 'true'>DROP</option>
      </select></td></tr>
    ");
    
    return 0;
}


//******************************************************************************
//    Function: get_matching_course
//    Description: find the course described in a prefrence
//    Input: a prefrence, and a list of the courses
//    Returns: The matching course or 0 if a matching course cannot be found
//******************************************************************************
 function get_matching_course ($pref, $course_list)
{
    foreach ($course_list as $curr_course)
    {
        if ($pref->course_name == $curr_course->name)
            return $curr_course;
    }
    return 0;
 }

//******************************************************************************
//    Function: check_added_courses
//    Description: checks to see if any classes are being added to the table.
//      if so, it adds them.  Otherwise, exits.
//    Input: *A list of prefrences
//           *The name of the instructor logged in
//           *a message that is updated and passed back to build_pref_table
//           *the current number of hours the instructor is teaching
//           *the maximum amount of hours the instructor can teach
//    Returns: 0 on exit
//******************************************************************************
function check_added_courses (&$prefs, $instructor, &$message, $curr_hours)
{
    
    //make sure a class was passed in...
    if (isset($_POST["course_add"]))
    {
        $new_course = $_POST["course_add"];
        //...and that the max hours have not been reached
        if ($curr_hours >= $instructor->hour)
        {
            $message = "Cannot add class.  Max hours reached.";
            return 0;
        }  
    }
    else
    {
        //exit if no class was passed in
        return 0;
    }

     //get the prefrence for the course
     if (isset($_POST[$new_course]))
         $new_time = $_POST[$new_course];
     else
         $new_time = "internet";

    //internet courses have a ".i" added to their names.
    //Lets get rid of it here
    if (substr($new_course,(strlen($new_course)-2)) == ".i")
        $new_course = substr($new_course,0,(strlen($new_course)-2));
    
     //Now search the list of classes we have to see if this class has
     //already been added
     $in_list = false;
     foreach ($prefs as $curr_pref)
     {
         //if the course has the same name and instructor...
         if (($curr_pref->course_name == $new_course) &&
             ($instructor->name == $curr_pref->faculty_name))
         {
             //make sure one is not an internet file and not the other
             if ((($curr_pref->time_pref == "internet") XOR
                ($new_time == "internet")) == FALSE)
             {
                 //say we found it and update the prefrence
                 $in_list = true;
                 $curr_pref->time_pref = $new_time;
                 break;
             }
         }
     }

     //if the class was not already in the list, add it to the list
     if ($in_list == false)
     {
        $new_pref = new pref();
        $new_pref->course_name = $new_course;
        $new_pref->faculty_name = $instructor->name;
        $new_pref->time_pref = $new_time;
        $prefs[] = $new_pref;
        
        //update the file
        file_put_contents(DIRECTORY.PREF_FILE, serialize($prefs));
     
        //update the message passed out of the function
        $message = "Class Added!"; 
        //echo '<meta http-equiv="refresh" content="0">';
        return 0;
     }
     else
     {
         $message = "Class already in list";
         return 0;
     }
}
?>