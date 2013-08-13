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

        $file_to_check = "27_CT.txt";

        $text = file_get_contents("tests\\".$file_to_check);
        $reader = new Times_File_Reader($text);
        $array = $reader->Scan_File();

         echo "<h3>Checking $file_to_check:</h3><br>";
         
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
