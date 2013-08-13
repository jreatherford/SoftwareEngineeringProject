

<?php
include_once "scanner_helper.php";
include_once "structures.php";


function build_semester_table ($location)
{
    $semester_list = unserialize(@file_get_contents(DIRECTORY.SEMESTER_FILE));
    
    if ($semester_list == false)
        $semester_list = array();
    
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

    //check for new classes
    if (isset($_POST['new_semester']) && ($_POST['new_semester'] != ""))
    {
        $new_semester = new semester_dir();
        $new_semester->path = $_POST['new_semester']; 
        $new_semester->current = false;
        
        if (in_array($new_semester,$semester_list) == false)
        {
            $new_semester->current = true;
            if (in_array($new_semester,$semester_list) == false)
                $semester_list[] = $new_semester;
        }
    }
    
    //if there are no classes, create a default one
    if (empty($semester_list))
    {
        $new_semester = new semester_dir();
        $new_semester->path = "Default"; 
        $new_semester->current = true;
        $semester_list[] = $new_semester;
    }
    
    foreach ($semester_list as $key => $current_semester)
    {
        
        //check for deleted courses
        if (isset($_POST[$current_semester->path."_delete"]))
        {
            unset($semester_list[$key]);
            continue;   
        } 
        
        //check for changes in "current"
        if (isset($_POST[$current_semester->path."_current"]))
            $current_semester->current = $_POST[$current_semester->path."_current"];
        
        if (isset($_POST[$current_semester->path."_rename"]))
        {
                $new_name = $_POST[$current_semester->path."_rename"];
                if (empty($new_name) == false)
                    $current_semester->path = $new_name;
        }

        //print the row
        ?>
        <tr  align='left'>
                  <td>
                      <!--default value for $current;-->
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
                  <td>
                      <?php echo $current_semester->path?>
                  </td>
                  <td>
                      <input type="text" 
                             name="<?php echo $current_semester->path?>_rename">
                  </td>
                  <td>
                      <input type='checkbox' 
                             name='<?php echo $current_semester->path?>_delete' 
                             value='true'>
                  </td>
              </tr>
        <?php    
    }

    echo "
        </table>
        </div>
        <b>New Semester</b>: <input type='text' name='new_semester'><br>
        <input type='submit'>
        </form>";
    
    file_put_contents(DIRECTORY.SEMESTER_FILE,serialize($semester_list));
    
}
?>

