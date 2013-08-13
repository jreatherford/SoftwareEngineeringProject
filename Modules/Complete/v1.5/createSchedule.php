<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Create Schedule - Class scheduling</title>
    <?php
        session_start();
        if( !isset($_SESSION['admin']) )
        {
            echo "<script type=\"text/javascript\">
                 alert(\"Access Denied.\");
                 location = \"accessDenied.php\"
                  </script><!--";
        }
    ?>
</head>
    <body>
    <?php
        include_once "Structures.php";

        $rules = unserialize(file_get_contents($_SESSION['DIRECTORY'].RULES_FILE));
        if ($rules == false)
        {
            $_SESSION['PRIORITIZE_SENIORITY'] = true;
            $_SESSION['NUM_SCHEDULE_ATTEMPTS'] = 100;
            $_SESSION['ERROR_WEIGHTS'] = array(
                '100_LEVEL' => 1,
                '200_LEVEL' => 2,
                '300_LEVEL' => 3,
                '400_LEVEL' => 5,
                'UNWANTED_TIME' => 2,
                'UNSATISFIED_PREF' => 4);
        }
        else
        {
            $_SESSION['PRIORITIZE_SENIORITY'] = $rules->senority;
            $_SESSION['NUM_SCHEDULE_ATTEMPTS'] = $rules->attempts;
            $_SESSION['ERROR_WEIGHTS'] = array(
                '100_LEVEL' => $rules->weight_100,
                '200_LEVEL' => $rules->weight_200,
                '300_LEVEL' => $rules->weight_300,
                '400_LEVEL' => $rules->weight_400,
                'UNWANTED_TIME' => $rules->weight_unwanted_time,
                'UNSATISFIED_PREF' => $rules->weight_unsatisfied_pref);
        }

        include_once 'Scheduling.php';
        include 'schedule_output.php';

        function redirect($message, $location)
        {
            echo "<script type=\"text/javascript\">
                alert(\"Please enter valid classs time information.\");
                location = \"";
            echo $location;
            echo "\"</script>";
        }


        $file_info = @file_get_contents( $_SESSION['DIRECTORY'].INFO_FILE );

        //Ensure the file exists
        if($file_info == FALSE)
        {
            echo "File: \"" . $_SESSION['DIRECTORY'] . INFO_FILE . "\" not found.";
            redirect("Please enter valid class time information.",
                    "adminhomepage.php");
        }
        //If it does, unpack the data it contains
        else
            $file_info = unserialize($file_info);

        //Ensure the info file contains valid data
        if(get_class($file_info) != "File_Info")
        {
            echo "File: \"" . $_SESSION['DIRECTORY'] . INFO_FILE . "\" not found.";
            redirect("Please enter valid class time information.",
                    "adminhomepage.php");
        }

        //Check to make sure fields are set
        if( $file_info->class_times == null )
        {
            echo "Missing class time information.";
            redirect("Please enter valid class time information.",
                    "adminhomepage.php");
        }
        elseif( $file_info->available_rooms == null )
        {
            echo "Missing available room information.";
            redirect("Please enter valid available room information.",
                    "rooms.php");
        }
        elseif( $file_info->course_list == null )
        {
            echo "Missing course list information.";
            redirect("Please enter valid course list information.",
                    "courses.php");
        }
        else
            do_schedule();


    function do_schedule()
    {
        $ret_vals = Generate_Schedule();
        $schedule = $ret_vals[0];
        $error_list = $ret_vals[1];

        //Create excel file
        $excel_file = fopen($_SESSION['DIRECTORY'].EXCEL_FILE, "w");
        fwrite($excel_file, "Course,Time Slot,Instructor,Room\n");
        fwrite($excel_file, " , , , \n");
        $entry_array = array();
        foreach( $schedule as $entry )
        {
            $entry_array[0] = $entry->course_name;
            $entry_array[1] = $entry->time_slot;
            $entry_array[2] = $entry->faculty_name;
            $entry_array[3] = $entry->room_name;
            fputcsv($excel_file,$entry_array);
        }
        fclose($excel_file);


        //Create graphical schedule
        $schedule = serialize($schedule);
        file_put_contents($_SESSION['DIRECTORY'].SCHEDULE_FILE, $schedule);

        build_schedule_table();

        //Echo and write error file
        $error_file = fopen($_SESSION['DIRECTORY'].ERROR_FILE, 'w');
        echo "<br><br>Error List:<br><br>";
        fwrite($error_file, "Error List:\r\n\r\n");
        foreach( $error_list as $e )
        {
            echo $e . "<br>";
            fwrite($error_file, $e . "\r\n");
        }
        fclose($error_file);
    }
    ?>
    </br></br>
    <a href='adminhomepage.php' ><img src='images/goback.png'/></a>
    </body>
</html>