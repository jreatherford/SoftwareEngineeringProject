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
      for ($i = 1; $i <= 48; $i++)
      {
            if ($i < 10)
                $text = file_get_contents("..\\PR\\0".$i."_PR.txt");
            else
                $text = file_get_contents("..\\PR\\".$i."_PR.txt");
            
            $reader = new Prereq_File_Reader($text);
            $array = $reader->Scan_File();
            if (isset($array[0]))
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
