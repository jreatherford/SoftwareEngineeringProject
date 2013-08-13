<?php
//******************************************************************************
//    James Reatherford
//******************************************************************************
//    Created on: 4/25/13
//    Last Edit on: 4/26/13
//******************************************************************************
//    This file builds a preference input table.  It gets input 
//******************************************************************************

include_once "..\\structures.php";
include_once "..\\scanner_helper.php";


//******************************************************************************
//    Function:  
//    Description: 
//    Input: 
//    Returns: 
//******************************************************************************
function build_pref_table($location)
{
    //get the instructor information
    $this_instructor = "saget, bob";
    $max_hours = 12;
    
    
    $message = "";
    
    //get the courses
    $course_list = unserialize(file_get_contents("..\\".DIRECTORY.INFO_FILE));
    $course_list = $course_list->course_list;

    //Get the prefrences from the prefrence file...
    //...and if the file does not exist, create it
    $pref_list = (@file_get_contents("..\\".DIRECTORY.PREF_FILE));
    if ($pref_list === FALSE)
        $pref_list = array();
    else
        $pref_list = unserialize($pref_list);

    $curr_hours = get_instructor_hours ($this_instructor, $pref_list, $course_list);
    check_added_courses ($pref_list, $this_instructor, $message, $curr_hours, $max_hours);
    print_table ($location, $pref_list, $course_list, $this_instructor, $message);
    
    return 0;
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function get_instructor_hours ($instructor, $prefs, $course_list)
{
    $hours = 0;
    foreach ($prefs as $curr_pref)
    {
        if ($curr_pref->faculty_name == $instructor)
        {
            $curr_course = get_matching_course ($curr_pref, $course_list);
            $hours += $curr_course->hours;
        }
   
    }
    return $hours;  
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function print_table ($location, $pref_list, $course_list, $instructor, $message)
{

    //print out the table header
    echo ("
        <table width='583'>
        <form action='$location' method='post'>
        
        <tr>
          <th width='100'>
              Course
          </th>
          <th width='123'>
              Preference
          </th>
          <th width='125'>
              Class Size
          </th>
          <th width='82'>
              Hours
          </th>
          <th width='129'>
              Action
          </th>
        </tr>
    ");

    //for each prefrence in the table
    foreach ($pref_list as $key => $curr_pref)
    {
        
        $changed = false;
        
        //dropped classes
        if ($curr_pref->time_pref == "internet")
           $internet_flag = "_i";
        else
           $internet_flag = "";
        if (isset($_POST["$curr_pref->course_name"."$internet_flag"."_drop"]) &&
            ($_POST["$curr_pref->course_name"."$internet_flag"."_drop"] == "true"))
        {
               unset($pref_list[$key]);
               $changed = true;
               continue;
        } 

        //check for changed prefrences
        if (isset($_POST["$curr_pref->course_name"."_pref"]) && 
           ($curr_pref->time_pref != "internet"))
        {
           $curr_pref->time_pref = $_POST["$curr_pref->course_name"."_pref"];
           $changed = true;
        }

        //get the course
        if ($curr_pref->faculty_name == $instructor)
           print_row ($curr_pref, $course_list);

    }
    
      if ($changed == true)
          $message = "Changed saved!";
    
     echo("
     <tr><td>
     <input type='image' src='submitButton.png'>
     </td><td>$message</tr><td>
     </form>
     ");
     
    //update the file
    file_put_contents("..\\".DIRECTORY.PREF_FILE, serialize($pref_list));
    
    return 0;
}

////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
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

    //create the option dropbox
    if($pref->time_pref == "internet") 
        echo "internet";
    else
        echo "<select name ='{$pref->course_name}_pref'>";
     
     //morning
     echo ("<option value ='morning' ");
     if ($pref->time_pref == "morning")
        echo " selected='selected'";
     echo(">morning</option>");

     //evening
     echo ("<option value ='midday' ");
     if ($pref->time_pref == "midday")
        echo " selected='selected'";
     echo(">midday</option>");

     //night
     echo ("<option value ='evening' ");
     if ($pref->time_pref == "evening")
        echo " selected='evening'";
     echo(">evening</option>");


    $course = get_matching_course ($pref, $course_list);  
    //print the course size and hours
    echo ("                         
        </td>
        <td align='center'>
            $course->size
        </td>
        <td align='center' >
            $course->hours
        </td>                             
        <td align='center'>
    ");


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

////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
 function get_matching_course ($pref, $course_list)
{ 
    foreach ($course_list as $curr_course)
    {
        if ($pref->course_name == $curr_course->name)
            return $curr_course;
    }
    return 0;
 }
 
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function check_added_courses (&$prefs, $instructor, &$message, $curr_hours, $max_hours)
{
    //get the name of the new course
    if (isset($_POST["course_add"]))
    {
        $new_course = $_POST["course_add"];
        if ($curr_hours >= $max_hours)
        {
            $message = "Cannot add class.  Max hours reached.";
            return 0;
        }
        
    }
    else
        return 0;
    
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
             ($instructor == $curr_pref->faculty_name))
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
     
     //if the class is not in the list, add it to the list
     if ($in_list == false)
     {
        $new_pref = new pref();
        $new_pref->course_name = $new_course;  
        $new_pref->faculty_name = $instructor;             
        $new_pref->time_pref = $new_time;
        $prefs[] = $new_pref; 
     }
     
     //update the file
     file_put_contents("..\\".DIRECTORY.PREF_FILE, serialize($prefs));
     $message = "Class Added!";
     return 0;
}

?>

