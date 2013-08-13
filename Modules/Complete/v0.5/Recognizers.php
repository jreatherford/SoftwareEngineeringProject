<?php
//******************************************************************************
//    James Reatherford
//    Hongbin Yu
//******************************************************************************
//    Created on: 4/09/13
//    Last Edit on: 4/18/13
//******************************************************************************
//    This file contains a structure for an abstract class called recognizer
//    along with four classes that derive from this class.
//    The recognizer classes simply take in a position in a line and pull a
//    field from that position.  The fields these classes look for are as
//    follows:
//       *Days
//       *Room
//       *Times
//       *Course Names
//       *Interger
//       *Room Type
//       *Name
//******************************************************************************

//******************************************************************************
//******************************************************************************
//    Class:  Days_Recognizer
//    Description:  Contains a single function that scans for a day field
//******************************************************************************
//******************************************************************************
class Days_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Recognizes a day field
    //    Input: Text to be evaluated
    //    Returns: 0 on success; Otherwise, an error message
    //**************************************************************************
    public static function read($token)
    {
        if (preg_match("#^(MT?W?R?F?S?)$|".
                        "^(M?TW?R?F?S?)$|".
                        "^(M?T?WR?F?S?)$|".
                        "^(M?T?W?RF?S?)$|".
                        "^(M?T?W?R?FS?)$|".
                        "^(M?T?W?R?F?S)$#", $token) == 1)
            return 0;
        else 
            return 6;  
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Time_Recognizer
//    Description:  Contains a single function that scans for a time field
//******************************************************************************
//******************************************************************************
class Time_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Recognizes a time field
    //    Input: Text to be evaluated
    //    Returns: 0 on success; Otherwise, an error message
    //**************************************************************************
    public static function read($token)
    {
        if (preg_match("/^(([0-1][0-9])|(2[0-3])):([0-5][0-9])$/",$token) == 1)
            return 0;
        else 
            return 7;
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Room_Recognizer
//    Description:  Contains a single function that scans for a room field
//******************************************************************************
//******************************************************************************
class Room_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Scans for a room field
    //    Input: Text to be evaluated, current position
    //    Returns: The field on success; Otherwise, an error message
    //**************************************************************************
    public static function read($text, &$current_pos)
    {

        //Return error if the line is empty
        if ($current_pos >= strlen($text))
            return 19;
        
        //skip over both words
        $token = Grab_Field($current_pos, $text, " ");
        $token = $token . " " . Grab_Field($current_pos, $text, " ");

        //check the format
        if (preg_match("/^[A-Z]+ [1-9]([0-9]{0,3})$/", $token) == 1)
            return $token;
        else
            return 8;

    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Course_Recognizer
//    Description:  Contains a single function that scans for a course field
//******************************************************************************
//******************************************************************************
class Course_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Scans for a course field
    //    Input: Text to be evaluated, current position
    //    Returns: The field on success; Otherwise, an error message
    //**************************************************************************
    public static function read($text, &$current_pos)
    {
        $start_pos = $current_pos;
        
        //skip past whitespace at the start
        Skip_Whitespace($current_pos, $text);
        
        //Make sure there is something on the line
        if ($current_pos >= strlen($text))
            return 21;
        
        /* 5 characters is the minimum possible size of a class field
         * We are 1 character into the field. Any possible spaces will occour 
         * between the 2nd and 5th space in the field. Therefore, immediatly 
         * advancing the cursor 4 spaces past the spot will gaurentee that the 
         * optional space is grabbed without goint into the next field*/
        if ((strlen($text) - $current_pos) == 3)
            $current_pos += 3;
        else
            $current_pos += 4;
        
        //skip over the rest of the word until the next whitespace
        Grab_Field($current_pos, $text, " ");
        
        //get the token
        $token = trim(substr($text, $start_pos, ($current_pos - $start_pos)));

        $regex = "/^[A-Z]{2,4} ?(([1-4][0-9][0-9])|(099))[A-Z]?$/";
        if (preg_match($regex, $token) == 1)
            return preg_replace('/ /', '', $token);
        else 
            return 10;
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Faculty_Name_Recognizer
//    Description:  Contains a single function that scans for a name field
//******************************************************************************
//******************************************************************************
class Faculty_Name_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Scans for a name field
    //    Input: Text to be evaluated, current position
    //    Returns: The field on success; Otherwise, an error message
    //**************************************************************************
    public static function read($text, &$current_pos)
    {
        
        //skip over both words
        $token = Grab_Field($current_pos, $text, " ");
        $token = $token . " " . Grab_Field($current_pos, $text, " ");

        //check the format
        if (strlen($token) == 1)
            return 22;
        else if (preg_match("/^(.+), (.+)$/", $token) == 1)
            return $token;
        else
            return 11;
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Room_Type_Recognizer
//    Description:  Contains a single function that scans for a room type field
//******************************************************************************
//******************************************************************************
class Room_Type_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Recognizes a room type field
    //    Input: Text to be evaluated
    //    Returns: 0 on success; Otherwise, an error message
    //**************************************************************************
    public static function read($token)
    {
        // if it contains lowercase symbol, return error code
        if (ctype_lower($token))
            return 4;
        
        // if contains more than 1 letter, return error code
        else if (strlen($token) != 1)
            return 9;
        
        // if it mataches L or C, return false indicates it is a valid token
        else if (preg_match("/^L|C$/", $token))
            return false;
        
        // if none of above matches, consider it as unknow data
        else
            return 2;
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Integer_Recognizer
//    Description:  Contains a single function that scans for a integer field
//******************************************************************************
//******************************************************************************
class Integer_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Recognizes an integer field
    //    Input: Text to be evaluated, 
    //           maxumim allowed value, minimum allowed value
    //    Returns: 0 on success; Otherwise, an error message
    //**************************************************************************
    public static function read($token, $min, $max)
    {
        // check if it is empty token
        if (strlen($token) == 0)
            return 15;
        
        // if it is not digit, return error code
        if (!ctype_digit($token))
            return 5;
        
        // check limitation
        else if (($token > $min) && ($token < $max))
            return 0; 
       
        // integer exceeds the room size limit
        else
            return 14;
    }
}


//******************************************************************************
//******************************************************************************
//    Class:  Year_Of_Service_Recognizer
//    Description:  Contains a single function that scans for a years field
//******************************************************************************
//******************************************************************************
class Year_Of_Service_Recognizer
{
    //**************************************************************************
    //    Function:  Read
    //    Description:  Recognizes a years field
    //    Input: Text to be evaluated
    //    Returns: 0 on success; Otherwise, an error message
    //**************************************************************************
    public static function read($token)
    {
        // if contains data or not
        if (strlen($token) == 0)
            return 23;
        
        // check limitation
        if ($token < 0 || $token > 60)
            return 14; 
        
        // check if it matches the year_of_service format
        if (preg_match("/^(([1-5][0-9]|[0-9])(\.50*)?)$|(^60\.0*)|60$/", $token) == 1)
            return 0;
            
        else 
            return 12;
    }
}
?>
