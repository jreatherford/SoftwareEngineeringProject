<?php

include_once "scanner_helper.php";
include_once "structures.php";


function print_rules_form($location)
{
    
    
    $rules = unserialize(@file_get_contents(DIRECTORY.RULES_FILE));
    if (($rules == false) || isset($_POST['default']))
    {
        $rules = new Rules();
        $rules->senority = true;
        $rules->attempts = 100;
        $rules->weight_100 = 1;
        $rules->weight_200 = 2;
        $rules->weight_300 = 3;
        $rules->weight_400 = 5;
        $rules->weight_unwanted_time = 2;
        $rules->weight_unsatisfied_pref = 4;

    }
    
    if (isset($_POST['attempts']))
    {
        $tmp_val = $_POST['attempts'];
        if (($tmp_val >= 1) && ($tmp_val <=1000))
            $rules->attempts = $tmp_val;
    }
    
    if (isset($_POST['weight_100']))
    {
        $tmp_val = $_POST['weight_100'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_100 = $tmp_val;
    }
    
    if (isset($_POST['weight_200']))
    {
        $tmp_val = $_POST['weight_200'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_200 = $tmp_val;
    }
    
    if (isset($_POST['weight_300']))
    {
        $tmp_val = $_POST['weight_300'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_300 = $tmp_val;
    }
    
    if (isset($_POST['weight_400']))
    {
        $tmp_val = $_POST['weight_400'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_400 = $tmp_val;
    }
    
    if (isset($_POST['weight_unwanted_time']))
    {
        $tmp_val = $_POST['weight_unwanted_time'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_unwanted_time = $tmp_val;
    }
    
    if (isset($_POST['weight_unsatisfied_pref']))
    {
        $tmp_val = $_POST['weight_unsatisfied_pref'];
        if (($tmp_val >= 1) && ($tmp_val <=10))
            $rules->weight_unsatisfied_pref = $tmp_val;
    }
    
    if (isset($_POST['senority']))
        $rules->senority = $_POST['senority'];



    file_put_contents(DIRECTORY.RULES_FILE,serialize($rules));

    echo "<form action='$location' method='post'>

    <div>
        <input type='text' name='attempts' placeholder='$rules->attempts'>Number of Attempts (1-1000)<br>
        <input type='text' name='weight_100' placeholder='$rules->weight_100'>Weight of 100 level classes (1-10) <br>
        <input type='text' name='weight_200' placeholder='$rules->weight_200'>Weight of 200 level classes (1-10)<br>
        <input type='text' name='weight_300' placeholder='$rules->weight_300'>Weight of 300 level classes (1-10)<br>
        <input type='text' name='weight_400' placeholder='$rules->weight_400'>Weight of 400 level classes (1-10)<br>
        <input type='text' name='weight_unwanted_time' placeholder='$rules->weight_unwanted_time'>Weight of unwanted Times (1-10)<br>
        <input type='text' name='weight_unsatisfied_pref' placeholder='$rules->weight_unsatisfied_pref'>Weight of unsatisfied preferences (1-10)<br>
          <input type='hidden' name='senority' value='false'>
        <input type='checkbox' name='senority' value='true'
           ";
              if ($rules->senority == 'true')
                  echo " checked='checked'";
            echo"
              > Prioritize by Seniority (unchecked is by submission time) <br>
        <input type='submit'>
        <button name='default' value=true'>Restore Defaults</button>
        </div>
        ";
    
}
?>