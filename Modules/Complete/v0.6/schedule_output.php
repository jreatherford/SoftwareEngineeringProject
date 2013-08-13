<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="sorttable.js"></script>
    </head>
    <body>
    <?php
        include_once 'Structures.php';
        $_ENV['DIRECTORY'] =  "Test1\\";
        @define("SCHEDULE_FILE", "schedule.dat");

        function build_schedule_table()
        {
            $schedule = @file_get_contents($_ENV['DIRECTORY'].SCHEDULE_FILE);
            $schedule = unserialize($schedule);
            echo "
                <table class=\"sortable\">
                <tr>
                    <th>Course&emsp;&emsp;</th>
                    <th>Time Slot&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                    <th>Instructor&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                    <th>Room&emsp;&emsp;</th>
                </tr>
            ";
            foreach($schedule as $entry)
            {
                echo "<tr>";
                echo "<td>$entry->course_name</td>";
                echo "<td>$entry->time_slot</td>";
                echo "<td>$entry->faculty_name</td>";
                echo "<td>$entry->room_name</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
    </body>
</html>
