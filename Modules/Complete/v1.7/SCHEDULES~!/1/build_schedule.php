<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="../../sorttable.js"></script>
    </head>
    <body>
    <?php
        include_once '..\\..\\Structures.php';

        function build_schedule_table()
        {
            $schedule = file_get_contents(SCHEDULE_FILE);
            $schedule = unserialize($schedule);
            echo "<b>Note: Click a table header to sort by that field.<br><br></b>
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
        
        build_schedule_table();
    ?>
    </br></br>
    <a href='../../index.php' ><img src='../../images/goback.png'/></a>
    </body>
</html>
