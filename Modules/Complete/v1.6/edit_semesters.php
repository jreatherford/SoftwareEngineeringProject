<?php
//******************************************************************************
//    James Reatherford
//******************************************************************************
//    Created on: 4/25/13
//    Last Edit on: 4/29/13
//******************************************************************************
//    This file builds a semester management table.
//        
//    This file reads input from POST messages.
//    The following infromation may be read in from POST[]:
//    --------------------------------------------------------------------------
//   POST["new_semester"]          -  If a semester is being added, its name 
//                                    will be found here
//   
//   POST[(semester_name)_delete"] -  Name of the semester followed by _delete
//                                    is set to true if the course is being 
//                                    delteted
//                                
//   
//   POST[(semester_name)_rename"] - Name of the semester followed by _rename
//                                    is set to true if the course is being 
//                                    renamed
//                                
//   
//   POST[(semester_name)_current"] - Name of the semester followed by _current
//                                    is set to true if the course is a current
//                                    course (meaning it can be edited) or false
//                                    if the course is not current
//                       
//   ---------------------------------------------------------------------------
//   REQUIREMENTS:
//   
//   This file makes used of the following files:
//  SEMSESTER_FILE (defined in structures.php)
//   
//******************************************************************************

include_once "structures.php";

//******************************************************************************
//    Function: build_semester_table
//    Description: Does all the work of building a semester management table
//    Input: The name of the html page that contains the prefrence table being
//           updated.
//    Returns: 0 on exit
//******************************************************************************
function build_semester_table ($location)
{
    //get the list of semesters from the file
    $semester_list = unserialize(@file_get_contents(SEMESTER_FILE));
    //if it does not exist, create it
    if ($semester_list == false)
        $semester_list = array();
    
    //build the header of the table
    echo("<div style='height:200px; width:700px; overflow:auto;'>
        <form action='$location' method='post'>
            <table>
                <tr align='left'>
                    <th width='20%'>
                        Current?
                     </th>
                     <th width='30%'>
                         Semester Name
                     </th>
                     <th width='30%'>
                         Rename
                     </th>
                     <th width='15%'>
                         Delete?
                     </th>
                 </tr>
    ");

    //check for new semester
    if (isset($_POST['new_semester']) && ($_POST['new_semester'] != ""))
    {
        //add the new semester, if there is one
        $new_semester = new semester_dir();
        $new_name = preg_replace("/\s+/","_",$_POST['new_semester']);
        $new_semester->path = preg_replace("/[^A-Za-z0-9_]/", '', $new_name);
        $new_semester->current = false;
        
        //make sure this is not a duplicate semester before you add it
        if (in_array($new_semester,$semester_list) == false)
        {
            $new_semester->current = true;
            if (in_array($new_semester,$semester_list) == false)
                $semester_list[] = $new_semester;
        }
    }
    
    
    //if there are no semester, create a default one
    if (empty($semester_list))
    {
        $new_semester = new semester_dir();
        $new_semester->path = "Default_Semester";
        $new_semester->current = true;
        $semester_list[] = $new_semester;
    }
    
    //for each semester, print a row
    $total_currents = 0;
    foreach ($semester_list as $key => $current_semester)
    {
        if ($current_semester->current == 'true')
            $total_currents++;
    }
  
    //for each semester, print a row
    foreach ($semester_list as $key => $current_semester)
    {
     
     if ($total_currents == 0)
     {
            $current_semester->current = 'true';
            $total_currents++;
     }
        
        //check to see if the semester is being deleted                
        if  ((isset($_POST[$current_semester->path."_delete"]) &&
               ($_POST[$current_semester->path."_delete"] == 'true')))
        {
            //clear the contents of the directory
            $contents = scandir($current_semester->path);
            foreach ($contents as $curr_file)
            {
                if (($curr_file != '.') && (($curr_file != '..')))
                    @unlink($current_semester->path."\\".$curr_file);  
            }
            
            //update the list, if you can remove it.  Otherwise give a method
            if (@rmdir($current_semester->path) == false)
                echo "trouble deleting file.  does it have sub directories?";
            else
            {
                //remove it from the list
                if ($current_semester->current == 'true')
                    $total_currents--;
                unset($semester_list[$key]);
                continue;   
            }
        } 
         
        //check for changes in "current" field of the semester
        if (isset($_POST[$current_semester->path."_current"]))        
        {
            $new_current = $_POST[$current_semester->path."_current"];
            if ($new_current == "true")
            {
                if ($current_semester->current == 'false')
                    $total_currents++;
                $current_semester->current = $new_current;
            }
            elseif ($new_current == "false")
            {
                if ($total_currents > 1)
                {
                  if ($current_semester->current == 'true')
                      $total_currents--;
                  $current_semester->current = $new_current;
                }
                else
                {
                    echo "There must be at least semester selected as current<br>";    
                }
            }
        }
        
        //check to see if the semester is being renamed               
        if (isset($_POST[$current_semester->path."_rename"]))
        {
                $new_name = $_POST[$current_semester->path."_rename"];
                if (empty($new_name) == false)
                {   $new_name = preg_replace("/\s+/","_",$new_name);
                    $new_name = preg_replace("/[^A-Za-z0-9]/", '', $new_name);
                    //only change the value if you can rename the folder
                    if (@rename ($current_semester->path, $new_name))
                        $current_semester->path = $new_name;
                    else
                        echo "Cannot rename file";
                            
                }
        }

        //print the row
        /*
         *  NOTE: this secion is more HTML than php, so the PHP tag ends here
         *        and this part of the loop is written in HTML
         */
        ?>
        <tr  align='left'>
                  <td>
                      <!--default value for $current;  Overwritten if checked-->
                      <input type='hidden' 
                          name='<?php echo $current_semester->path?>_current'
                          value='false'>
                      
                      <!--create the checkbox, can overwrite the default value-->
                      <input type='checkbox' 
                          name='<?php echo $current_semester->path?>_current'
                          value= 'true'
                          <?php if ($current_semester->current == 'true')
                                    echo " checked='checked'"; ?>>
                  </td>
                  
                  <!--print the name and 
                  build the directory is if does not exist--> 
                  <td>
                      <?php echo $current_semester->path;
                          if (is_dir($current_semester->path) == false)
                          {
                              mkdir($current_semester->path);
                          }
                              
                              
                       ?>
                  </td>
                  
                  <!--create the rename prompt-->
                  <td>
                      <input type="text" 
                          name='<?php echo $current_semester->path."_rename";?>'
                  </td>
                  
                  <!--create the delete checkbox-->
                  <td>
                      <input type='checkbox' 
                          name='<?php echo $current_semester->path."_delete";?>'
                          value='true'>
                  </td>
              </tr>
        <?php
         /*
         *  RESUME PHP CODE
         */
    

     }
     if ($total_currents == 0)
     {
         echo "THINGS GALORE!!!";
         echo "<meta http-equiv='refresh' content='0'>";
     }

    //close out the table and create the "new semester" form
    // and the submit button
    echo "
        </table>
        </div>
        <b>New Semester</b>: <input type='text' name='new_semester'><br>
        <input type='submit'>
        </form>";
    
    //update the file
    file_put_contents(SEMESTER_FILE,serialize($semester_list));
    
    //if empty, refresh so a default will be created
    if (empty($semester_list))
    {
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
}
?>

