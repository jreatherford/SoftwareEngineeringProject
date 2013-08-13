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
        $file_to_check = "12_PR.txt";
        $text = file_get_contents("tests\\".$file_to_check);
        
        //Put the type of reader you want here
        $reader = new Prereq_File_Reader($text);
        
        
        $array = $reader->Scan_File();
         echo "<h3>Checking $file_to_check:</h3><br>";

        print_r($array);
        echo "<br>";
      
        ?>
    </body>
</html>
