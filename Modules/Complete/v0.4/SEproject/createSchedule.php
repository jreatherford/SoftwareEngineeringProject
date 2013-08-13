<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Create Schedule - Class scheduling</title>
</head>
    <body>
    <?php
        define("INFO_FILE", "info_file.dat");
        define("FACULTY_FILE", "fac.dat");
        define("PREF_FILE", "prefs.dat");
        define("SCHEDULE_FILE", "schedule.dat");
        define("ERROR_FILE", "errors.txt");
        $_ENV['DIRECTORY'] =  "Test\\";
        $_ENV['PRIORITIZE_SENIORITY'] = true;
        $_ENV['NUM_SCHEDULE_ATTEMPTS'] = 1;
        $_ENV['INFINITY'] = 100000;
        $_ENV['ERROR_WEIGHTS'] = array(
            '100_LEVEL' => 1,
            '200_LEVEL' => 2,
            '300_LEVEL' => 3,
            '400_LEVEL' => 5,
            'UNWANTED_TIME' => 2,
            'UNSATISFIED_PREF' => 4);

        include 'Scheduling.php';

        function redirect($message, $location)
        {
            echo "<script type=\"text/javascript\">
                alert(\"Please enter valid classs time information.\");
                location = \"";
            echo $location;
            echo "\"</script>";
        }


        $file_info = @file_get_contents( $_ENV['DIRECTORY'].INFO_FILE );

        //Ensure the file exists
        if($file_info == FALSE)
        {
            echo "File: \"" . $_ENV['DIRECTORY'] . INFO_FILE . "\" not found.";
            redirect("Please enter valid class time information.",
                    "adminhomepage.php");
        }
        //If it does, unpack the data it contains
        else
            $file_info = unserialize($file_info);

        //Ensure the info file contains valid data
        if(get_class($file_info) != "File_Info")
        {
            echo "File: \"" . $_ENV['DIRECTORY'] . INFO_FILE . "\" not found.";
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

            echo "Schedule:<br><br>";
            foreach( $schedule as $s )
            {
                foreach( $s as $x )
                    echo $x . "\t";
                echo "<br>";
            }

            echo "<br><br>Error List:<br><br>";
            foreach( $error_list as $e )
                echo $e . "<br>";
        }
    ?>
    </body>
</html>