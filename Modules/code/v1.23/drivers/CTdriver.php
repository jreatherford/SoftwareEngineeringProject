<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <a href="CTall.php">To check all the files, click here!</a><br>
        <form action="CTdriver.php" method="post">
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

        $text = file_get_contents("..//CT\\".$file_to_check."_CT.txt");
        $reader = new Times_File_Reader($text);
        $array = $reader->Scan_File();

         echo "<h3>Checking $file_to_check:</h3><br>";
         
         if ($array == 0)
         {
             $array = unserialize(file_get_contents(DIRECTORY.INFO_FILE));
             $array = $array->class_times;
         }
         
         foreach ($array as &$token)
         {
             if (is_string($token))
             {
                 echo "$token";
             }
             else
             {
             echo "------------------------------------<br>
                   Days: $token->days <br>
                   Start Time: $token->start <br>
                   Duration: $token->duration <br>
                   ------------------------------------<br>";
             }
         }
      
        ?>
    </body>
</html>
