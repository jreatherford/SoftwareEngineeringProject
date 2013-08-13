<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
            include 'File_Readers.php';
        
            $file = file_get_contents("test\\PR.txt");
            if ($file === 0)
                echo "PR failed <br>";
            else
                echo "PR workd <br>";
            $reader = new Prereq_File_Reader($file);
            $error = $reader->Scan_File();
            if ($error != 0)
            {
                echo "FATAL ERROR IN PR <br>";
            }
            
            
            
            $file = file_get_contents("test\\AR.txt");
            if ($file === 0)
                echo "AR failed <br>";
            else
                echo "AR workd <br>";
            $reader = new Room_File_Reader($file);
            $error = $reader->Scan_File();
            if ($error != 0)
            {
                echo "FATAL ERROR IN AR <br>";
            }
            
            
            
            $file = file_get_contents("test\\CF.txt");
            if ($file === 0)
                echo "CF failed <br>";
            else
                echo "CF workd <br>";
            $reader = new Conflict_File_Reader($file);
            $error = $reader->Scan_File();
            if ($error != 0)
            {
                echo "FATAL ERROR IN CF <br>";
            }
            
            
            
            $file = file_get_contents("test\\CL.txt");
            if ($file === 0)
                echo "CL failed <br>";
            else
                echo "CL workd <br>";
            $reader = new Course_File_Reader($file);
            $error = $reader->Scan_File();
            if ($error != 0)
            {
                echo "FATAL ERROR IN CL <br>";
            }
            
            
            
            $file = file_get_contents("test\\CT.txt");
            if ($file === 0)
                echo "CT failed <br>";
            else
                echo "CT workd <br>";
            $reader = new Times_File_Reader($file);
            $error = $reader->Scan_File();
            if ($error != 0)
            {
                echo "FATAL ERROR IN CT <br>";
            }

            $data = unserialize(file_get_contents(DIRECTORY.INFO_FILE));
            
            echo "<br><br>AR:<br>";
            print_r($data->available_rooms);
            
            echo "<br><br>PR:<br>";
            print_r($data->prereq_list);
            
            echo "<br><br>CF:<br>";
            print_r($data->conflict_times);
            
            echo "<br><br>CT:<br>";
            print_r($data->class_times);
            
            echo "<br><br>CL:<br>";
            print_r($data->course_list);

      
        ?>
    </body>
</html>
