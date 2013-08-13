<?php

//******************************************************************************
//    James Reatherford
//    Hongbin Yu
//******************************************************************************
//    Created on: 4/12/13
//    Last Edit on: 4/18/13
//******************************************************************************
//    A library of usefull functions, classes, and constants that will be used
//    at various places thoughout the program.
//******************************************************************************


//******************************************************************************
//    Public Constants:  DIRECTORY & INFO_FILE
//    Description: DIRECTORY is the directory that the info file is located in
//                 INFO_FILE is the name of the info file
//******************************************************************************
define("DIRECTORY", "test\\");
define("INFO_FILE", "info_file.dat");

//******************************************************************************
//    Public Function:  Skip_Whitespace
//    Description: Skips past whitespace within a line of text
//    Inputs: The current position within the text and the text
//******************************************************************************
function Skip_Whitespace(&$current_pos, $text)
{
    // skip past whitespace at the start
    while (($current_pos < strlen($text)) && ($text[$current_pos] == " "))
        $current_pos++;
}
    
//******************************************************************************
//    Public Function:  Grab_Field
//    Description: Grabs the next token bit of text within a line of text 
//     skipping past starting whitespace and stopping at the delimiter.
//    Inputs: The current position, the text, the delimiter to stop at
//******************************************************************************
function Grab_Field(&$current_pos, $text, $delimiter)
{
    $start_pos = $current_pos;
    
    Skip_Whitespace($current_pos, $text);
     
    //skip over the word until the next delimiter
    while (($current_pos < strlen($text) && ($text[$current_pos] != $delimiter)))
        $current_pos++;

    return trim(substr($text, $start_pos, ($current_pos - $start_pos)));
}

//******************************************************************************
//    Public Function:  Contains_Extra_Data
//    Description: Checks to see if there is any non whitespace characters
//     after the cursor.
//    Returns: false if no whitespace is found.  True otherwise.
//    Inputs: The current position within the text and the text
//******************************************************************************
function Contains_Extra_Data(&$current_pos, $text)
{
    Skip_Whitespace($current_pos, $text);
    
    if ($current_pos < strlen($text))
    {
        return true;
    }
    else
        return false;
    
}

//******************************************************************************
//    Class:  Error_Table
//    Description: Simply contains an array containing all the possible error
//    messages generated by the readers and recognizers
//******************************************************************************
class error_table
{
     public static $list = array(
    1 => "Unknown file name",
    2 => "Unknown data",
    3 => "Duplicate data exist in the file",
    4 => "Data contains lowercase character(s)",
    5 => "Data does not match the [integer] format",
    6 => "Data does not match the [day] format",
    7 => "Data does not match the [time] format",
    8 => "Data does not match the [room] format",
    9 => "Data does not match the [room type] format",
    10 => "Data does not match the [course] format",
    11 => "Data does not match the [faculty name] format",
    12 => "Data does not match the [year_of_service] format",
    13 => "Input file contains empty line",
    14 => "Number exceeds the data limitation", 
    15 => "Program expecting [integer] data",
    16 => "Program expecting [day] data",
    17 => "Program expecting [ / symbol ] data",
    18 => "Program expecting [time] data",
    19 => "Program expecting [room type] data",
    20 => "Program expecting [room] data",
    21 => "Program expecting [course] data",
    22 => "Program expecting [faculty name] data",
    23 => "Program expecting [year of service] data",
    24 => "Program expecting [email] data",
    25 => "Input file contains extra unidentified data",
    26 => "Space exists before or after [ / symbol]");
}

?>
