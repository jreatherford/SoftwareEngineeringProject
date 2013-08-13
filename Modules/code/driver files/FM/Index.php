<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <a href="testAll.php">To check all the files, click here!</a><br>
        <?php
        include_once 'File_Readers.php';
        /*
        $text = file_get_contents("tests//test.txt");
        $reader = new Faculty_File_Reader($text);
        $array = $reader->Scan_File();
        foreach ($array  as &$token)
        {
            print_r ($token);
            echo "<br>";
        }*/

        for ($i = 1; $i <= 42; $i++)
        {
            if ($i < 10)
                $text = file_get_contents("FACULTYMEMBERS//0".$i."_FM.txt");
            else
                $text = file_get_contents("FACULTYMEMBERS//".$i."_FM.txt");
            
            $reader = new Faculty_File_Reader($text);
            $array = $reader->Scan_File();
            
            echo "PROCESSING $i._FM.txt<br>";
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
