<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <a href="testAll.php">To check all the files, click here!</a><br>
        <?php
        include 'File_Readers.php';

        $file_to_check = "test.txt";

        $text = file_get_contents("tests//".$file_to_check);
        $reader = new Room_File_Reader($text);
        
        $array = $reader->Scan_File();

        echo "<h3>Checking $file_to_check:</h3><br>";
         
        for ($i = 1; $i <= 36; $i++)
        {
            if ($i < 10)
                $text = file_get_contents("AVAILABLEROOMS//0".$i."_AR.txt");
            else
                $text = file_get_contents("AVAILABLEROOMS//".$i."_AR.txt");
            $reader = new Room_File_Reader($text);
            $array = $reader->Scan_File();
            
            echo "PROCESSING $i._AR.txt<br>";
            foreach ($array  as &$token)
            {
                print_r ($token);
                echo "<br>";
            }
            
            echo "*******************************************************<br>";
        }

        ?>
    </body>
</html>
