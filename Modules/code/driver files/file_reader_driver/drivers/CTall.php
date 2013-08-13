<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        [Note: "correct" does not necessarily mean working.  In this context
        "correct" means did not return an error.]<br>
        <?php

       include_once '..\\File_Readers.php';
      $text = "d";
      for ($i = 1; $i <= 50; $i++)
      {
            if ($i < 10)
                $text = file_get_contents("..\\CT\\0".$i."_CT.txt");
            else
                $text = file_get_contents("..\\CT\\".$i."_CT.txt");
            $reader = new Times_File_Reader($text);
            $array = $reader->Scan_File();
            if (($array != 0))
            {
                echo "$i - INCORRECT.  Error List: ";
                foreach ($array as &$token)
                    echo "($token),  ";
                echo "<br>";
            }
            else 
            {
                print ("$i - CORRECT<br>");
            }
        }
        
        ?>
    </body>
</html>
