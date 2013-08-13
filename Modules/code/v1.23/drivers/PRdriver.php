<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <a href="PRall.php">To check all the files, click here!</a><br>
        <form action="PRdriver.php" method="post">
        File Number: <input type="text" name="file">
        <input type="submit">
        <?php
        
        include '..//File_Readers.php';

        if (isset($_POST["file"]))
            $file_to_check = $_POST["file"];//"01_AR.txt";
        else
            $file_to_check = "01";
        if (strlen($file_to_check) == 1)
            $file_to_check = "0".$file_to_check;

        //put the file you want to check here
        $text = file_get_contents("..//PR//".$file_to_check."_PR.txt");
        
        //Put the type of reader you want here
        $reader = new Prereq_File_Reader($text);
        $array = $reader->scan_file();
        
         if ($array === 0)
         {
             $array = unserialize(file_get_contents(DIRECTORY.INFO_FILE));
             $array = $array->prereq_list;
         }
        
         echo "<h3>Checking $file_to_check:</h3><br>";

        print_r($array);
        echo "<br>";
      
        ?>
    </body>
</html>
