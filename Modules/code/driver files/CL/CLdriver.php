<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <a href="CLall.php">To check all the files, click here!</a><br>
        
        <form action="CLdriver.php" method="post">
        File Number: <input type="text" name="file">
        <input type="submit">
        </form>
        
        <?php
        include 'File_Readers.php';

        if (isset($_POST["file"]))
            $file_to_check = $_POST["file"];//"01_CL.txt";
        else
            $file_to_check = "01";
        if (strlen($file_to_check) == 1)
                $file_to_check = "0".$file_to_check;

        $text = file_get_contents("CL\\".$file_to_check."_CL.txt");
        $reader = new Course_File_Reader($text);
        $array = $reader->Scan_File();

         echo "<h3>Checking $file_to_check:</h3><br>";
         
         foreach ($array as &$token)
         {
             print_r($token);
             echo "<br>";
         }
      
        ?>
    </body>
</html>
