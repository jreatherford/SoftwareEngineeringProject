<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        $SCENARIO = 1;
        define("INFO_FILE", "info_file.dat");
        define("FACULTY_FILE", "fac.dat");
        define("PREF_FILE", "prefs.dat");
        define("SCHEDULE_FILE", "schedule.dat");
        define("ERROR_FILE", "errors.txt");
        $_ENV['DIRECTORY'] =  "test" . $SCENARIO . "\\";
        $_ENV['PRIORITIZE_SENIORITY'] = false;
        $_ENV['NUM_SCHEDULE_ATTEMPTS'] = 100;
        $_ENV['INFINITY'] = 100000;
        $_ENV['ERROR_WEIGHTS'] = array(
            '100_LEVEL' => 1,
            '200_LEVEL' => 2,
            '300_LEVEL' => 3,
            '400_LEVEL' => 5,
            'FACULTY_PREF' => 4);

        include 'Scheduling.php';

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
        if($SCENARIO == 1)
            echo "LOL101 N/A N/A N/A N/A N/A N/A BATMAN!";

        echo "<br><br>Error List:<br><br>";
        foreach( $error_list as $e )
            echo $e . "<br>";
        /*
        file_put_contents( $_ENV['DIRECTORY'] . SCHEDULE_FILE,
                               serialize($schedule) );

        $error_file = fopen($_ENV['DIRECTORY'] . ERROR_FILE, 'w');
        foreach( $error_list as $error )
            fwrite( $error_file, ($error . "\r\n") );
        fclose($error_file);
         */
        ?>
    </body>
</html>
