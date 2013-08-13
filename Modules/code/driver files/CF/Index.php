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

        //put the file you want to check here
        //$file_to_check = "test.txt";
        //$text = file_get_contents("tests//".$file_to_check);
        
        //Put the type of reader you want here
        //$reader = new Conflict_File_Reader($text);
        //$array = $reader->Scan_File();
        
        // http://php.net/manual/en/function.array-multisort.php
        // hints to sort this shit!!
        
        
        for ($i = 1; $i <= 50; $i++)
        {
            if ($i < 10)
                $text = file_get_contents("CONFLICTTIMES//0".$i."_CF.txt");
            else
                $text = file_get_contents("CONFLICTTIMES//".$i."_CF.txt");
            $reader = new Conflict_File_Reader($text);
            $array = $reader->Scan_File();
            
            echo "PROCESSING $i._CF.txt<br>";
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
