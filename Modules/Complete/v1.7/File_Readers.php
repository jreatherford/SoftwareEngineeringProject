<?php
session_start();
  /*  if( !isset($_SESSION['admin']) )
    {
        echo "<script type=\"text/javascript\">
                alert(\"Access Denied.\");
                location = \"accessDenied.php\"
              </script><!--";
    } */
?>
<?php
//******************************************************************************
//    James Reatherford
//    Hongbin Yu
//******************************************************************************
//    Created on: 4/11/13
//    Last Edit on: 4/18/13
//******************************************************************************
//    This section contains reader objects that simply scan a string (taken
//     from an input file) to extract the information from within and place
//     it into the appropriate data structure.
//******************************************************************************

include_once 'Structures.php';
include_once 'Recognizers.php';
include_once 'Scanner_Helper.php';

//******************************************************************************
//******************************************************************************
//    Class: File Reader
//    Description: This is the base class that all of the other file readers
//     inherit from.  This class contains three functions that are used by all
//     file readers (Constructor, Scan_File, and Read_A_Line) along with a
//     single function that is overwritten by each class (Read_A_Line).
//
//     Also, this class contains the four data members common to all readers
//     (text, data_list, error_list, name)
//******************************************************************************
//******************************************************************************
class File_Reader
{
    protected $text;
    protected $data_list;
    protected $error_list;

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
    protected $name = "";

    //**************************************************************************
    //    Public Function:  Constructor
    //    Inputs: Source text
    //    Description: It strips the tabs from the source text and then breaks
    //      up each line of the text and puts them in an array.
    //**************************************************************************
    public function __construct($raw_text)
    {
        $raw_text = preg_replace('/\t+/', ' ', $raw_text);
        $this->text = explode("\n", $raw_text);
        $this->data_list = array();
        $this->error_list = array();
    }

    //**************************************************************************
    //    Protected Function:  Read_A_Line
    //    Inputs: A line of text
    //    Description: Scans the line and puts its information into a data
    //      strucure (this is overwritten for each file reader)
    //**************************************************************************
    protected function Read_A_Line($curr_line){}

    //**************************************************************************
    //    private Function:  Update_File_Info
    //    Inputs: A string representing the type of reader calling the function
    //    Description: Checks to see if the INFO_FILE exists.  If it does, it
    //     updates its information with the data grabbed during the scan
    //     process. If the INFO_FILE does not exist, it is created with the data
    //     grabbed during the last scan.
    //    Returns: 0 on success, -1 on error.
    //**************************************************************************
    private function Update_File_Info ($info_type)
    {
        
        //check the INFO_FILE
        $file = file_get_contents($_SESSION['DIRECTORY'].INFO_FILE);
        if ($file === false)
        {
            //create a new FILE_INFO object if the file does not exist
            $object = new File_Info();
        }
        else
        {
            //otherwise open it
            $object = unserialize($file);
        }

        //loop at the appropriate field in the INFO_FILE and update it
        switch ($info_type)
        {
            case "class_times":
                $object->class_times = $this->data_list;
                break;
            case "available_rooms":
                $object->available_rooms = $this->data_list;
                break;
            case "course_list":
                $object->course_list = $this->data_list;
                 break;
            case "conflict_times":
                $object->conflict_times = $this->data_list;
                break;
            case "prereq_list":
                $object->prereq_list = $this->data_list;
                break;
            default:
                return -1;
        }

        //update the file itself
        file_put_contents($_SESSION['DIRECTORY'].INFO_FILE, serialize($object));
        return 0;
    }

    //**************************************************************************
    //    Public Function:  Scan_File
    //    Description: Scans through each line of a file and runs the
    //     Read_A_Line function on it.  After each line has been checked, if
    //     no errrors were found, the INFO_FILE is updated and the functions
    //     returns 0. Otherwise, the function returns an array of error messages
    //    Returns: 0 on success.  An array of strings on error
    //**************************************************************************
    public function Scan_File()
    {
        $line = 1;
        foreach ($this->text as $curr_line)
        {
            $error = $this->Read_A_Line($curr_line);
            
            if ($error != 0)
                $this->error_list[] = Error_Table::$list[$error] ." ($line)";
            $line++;
        }

        // return either a list of erros or a list of fields
        if (empty($this->error_list))
        {
            
            // add serialize stuff here
            if ($this->name != "faculty")
            {
                $this->Update_File_Info($this->name);
                return 0;
            }
            else
                return ($this->data_list);
        }
        else
            return ($this->error_list);
    }
}

//******************************************************************************
//******************************************************************************
//    Class: Times_File_Reader
//    Description: Reads a "Class Times" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Times_File_Reader extends File_Reader
{
    //Contains a list of the day/time combinations that have been used thus far
    //Used to prevent duplicate data
     private $day_pattern = array();

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
     protected $name = "class_times";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      Class_Times structure.  Places these structures into data_list.
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
     protected function Read_A_Line($curr_line)
     {
         $cursor = 0;

         if (preg_match("/^\s$/", $curr_line))
             return 13;

         // Check duration
         $curr_field = Grab_Field($cursor, $curr_line, " ");
         $error = Integer_Recognizer::read($curr_field, 0, 9999999999);
         if ($error != 0)
             return $error;
         else
         {
             $curr_time = new Class_Time();
             $curr_time->duration = $curr_field;
         }

         // Check days
         $curr_field = Grab_Field($cursor, $curr_line,"/");
         $error = Days_Recognizer::read($curr_field);
         if ($error != 0)
             return $error;
         else
             $curr_time->days = $curr_field;

         //check for lines that start with the same duration/day combo
         $curr_pattern = $curr_time->duration . $curr_time->days;
         if (in_array($curr_pattern, $this->day_pattern))
             return 3;
         else
             $this->day_pattern[] = $curr_pattern;

         // skip past the '/'
         $cursor++;

         // check there is no whitespace after the '/' & we are not over the line
         if (($curr_line[$cursor] === ' ') || ($cursor >= (strlen($curr_line) - 1)))
             return 18;

         while ($cursor < (strlen($curr_line) - 1))
         {
             $curr_field = Grab_Field($cursor, $curr_line, " ");

             $error = Time_Recognizer::read($curr_field);
             if ($error != 0)
                 return $error;
             else
             {
                 $curr_time->start = $curr_field;
                 if (in_array($curr_time, $this->data_list) == false)
                     $this->data_list[] = clone $curr_time;
                 else
                     return 3;
             }
             Skip_Whitespace($cursor, $curr_line);
         }
         return 0;
     }
}

//******************************************************************************
//******************************************************************************
//    Class: Room_File_Reader
//    Description: Reads an "Available Rooms" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Room_File_Reader extends File_Reader
{

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
    protected $name = "available_rooms";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      Room structure.  Places these structures into data_list.
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
    protected Function Read_A_Line($curr_line)
    {
        $current_pos = 0;
        $error;
        $next_token;
        $current_room = new Room();

        // check if it is empty line
        if ((empty($curr_line) || $curr_line == ' '))
        {
            return 13;
        }
        else
        {
            // read the room type
            if ($next_token = Grab_Field($current_pos, $curr_line, ' '))
            {
                // room type recognizer
                $error = Room_Type_Recognizer::read($next_token);
                if ($error == 0)
                    $current_room->type = $next_token;
                else
                    return $error;
            }
            else
                return 19;

            // read the room size
            $next_token = Grab_Field($current_pos, $curr_line, ' ');
            $error = Integer_Recognizer::read($next_token, 0, 101);
            if ($error != 0)
                return $error;
            else
                $current_room->size = $next_token;

            // read the room
            $error = Room_Recognizer::read($curr_line, $current_pos);
            if (is_numeric($error))
                return $error;
            else
                $current_room->name = $error;

            // check if the line contains extra data
            if (Contains_Extra_Data($current_pos, $curr_line))
                return 25;
            else
            {
                // check duplicate fields
                foreach ($this->data_list as $temp_token)
                {
                    if ($current_room->name == $temp_token->name)
                        return 3;

                }

                $this->data_list[] = clone $current_room;
            }

            return 0;
        }
    }
}

//******************************************************************************
//******************************************************************************
//    Class: Course_File_Reader
//    Description: Reads a "Course List" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Course_File_Reader extends File_Reader
{
    //holds a list of the courses that have appeared in this file.
    //Used to prevent duplicate data
     private $courses_scheduled = array();

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
     protected $name = "course_list";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      Course structure.  Places these structures into data_list.
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
    protected function Read_A_Line($curr_line)
    {
        $cursor = 0;
        $day = 0;
        $night = 0;
        $internet = 0;

        if (preg_match("/^\s$/", $curr_line))
            return 13;

        //get the course name
        $curr_field = Course_Recognizer::read($curr_line, $cursor);
        if (is_numeric($curr_field))
            return $curr_field;

        // check for duplicate data
        if (in_array($curr_field, $this->courses_scheduled))
            return 3;
        $this->courses_scheduled[] = $curr_field;

        $curr_course = new Course();
        $curr_course->name = $curr_field;

        // Set the data for day, night, internet, and size fields
        // Since these fields are almost identical, this can be done in
        // a loop
        for ($loop_count = 0; $loop_count < 4; $loop_count++)
        {
            $curr_field = Grab_Field($cursor, $curr_line, " ");
            $error = Integer_Recognizer::read($curr_field, -1, 101);
            if ($error != 0)
                return $error;
            switch ($loop_count)
            {
                case 0:
                    $day = $curr_field;
                    break;
                case 1:
                    $night = $curr_field;
                    break;
                case 2:
                    $internet = $curr_field;
                    break;
                case 3:
                    //size can't be zero
                    $curr_course->size = $curr_field;
                    if ($curr_course->size == 0)
                        return 14;
            }
        }

        //error if no courses are offered
        if (($day == 0) && ($night == 0) && ($internet == 0))
            return 14;

        //get the course type
        $curr_field = Grab_Field($cursor, $curr_line, " ");
        $error = Room_Type_Recognizer::read($curr_field);
        if (is_numeric($error ))
            return $error;
        else
            $curr_course->type = $curr_field;

        //get the course hours
        $curr_field = Grab_Field($cursor, $curr_line, " ");
        $error = Integer_Recognizer::read($curr_field, 0, 13);
        if ($error != 0)
            return $error;
        else
            $curr_course->hours = $curr_field;


        if (Grab_Field($cursor,$curr_line," ") != "")
            return 25;

        //create a copy of the object for each day section offered
        $curr_course->section = "day";
        while ($day > 0)
        {
            $this->data_list[] = clone $curr_course;
            $day--;
        }

        //create a copy of the object for each night section offered
        $curr_course->section = "night";
        while ($night > 0)
        {
            $this->data_list[] = clone $curr_course;
            $night--;
        }

        //create a copy of the object for each internet section offered
        $curr_course->section = "internet";
        while ($internet > 0)
        {
            $this->data_list[] = clone $curr_course;
            $internet--;
        }

        return 0;
    }
}

//******************************************************************************
//******************************************************************************
//    Class: Conflict_File_Reader
//    Description: Reads an "Conflict Times" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Conflict_File_Reader extends File_Reader
{

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
    protected $name = "conflict_times";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      Conflict_Time structure.  Places these structures into data_list.
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
    protected Function Read_A_Line($curr_line)
    {
        $current_pos = 0;
        $error;
        $next_token;
        $current_conflict = new Conflict_Time();

        // check if it is empty line
        if ((empty($curr_line) || $curr_line == " "))
            return 13;
        else
        {
            // read the course name
            $error = Course_Recognizer::read($curr_line, $current_pos);
            if (is_numeric($error))
                return $error;
            else
                $current_conflict->course_name = $error;

            // loop to read conflict times till EOL
            while($current_pos < strlen($curr_line))
            {
                $next_token = Grab_Field($current_pos, $curr_line, "/");
                $error = Days_Recognizer::read($next_token);
                if ($error != 0)
                    return $error;
                else
                    $current_conflict->days = $next_token;

                $current_pos++;

                // check there is no whitespace after the '/' and not EOL
                if ($current_pos >= (strlen($curr_line)))
                    return 18;
                if ($curr_line[$current_pos] == ' ')
                    return 26;

                // read a time
                $next_token = Grab_Field($current_pos, $curr_line, " ");
                $error = Time_Recognizer::read($next_token);
                if ($error != 0)
                    return $error;
                else
                {
                    $current_conflict->time = $next_token;
                }

                // check if it is duplicate and store into data_list
                if (in_array($current_conflict, $this->data_list))
                    return 3;
                else
                    $this->data_list[] = clone $current_conflict;

                // check if there is more data at the rest of the line
                Skip_Whitespace($current_pos, $curr_line);
            }

            if (!isset($current_conflict->days))
                return 16;
            else
                return 0;
        }
    }
}

//******************************************************************************
//******************************************************************************
//    Class: Prereq_File_Reader
//    Description: Reads a "Prerequisites" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Prereq_File_Reader extends File_Reader
{

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
    protected $name = "prereq_list";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      an array. Places the array in data_list (with the index being the
    //      course that the line contains data for)
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
    protected function Read_A_Line($curr_line)
    {
        $cursor = 0;
        $prereqs = array();
        $course;

        if (preg_match("/^\s$/",$curr_line))
            return 13;

        //loop for every token on the line
        Skip_Whitespace($cursor, $curr_line);
        while ($cursor < (strlen($curr_line) - 2))
        {
            $curr_field = Course_Recognizer::read($curr_line, $cursor);
            if (is_numeric($curr_field))
                return $curr_field;

            //set the first field to be the index of the array
            if (isset($course)== false)
            {
                $course = $curr_field;
            }
            else
            {
                // check for duplicate data within the line
                if (($curr_field == $course) || (in_array($curr_field, $prereqs)))
                    return 3;
                //add the course to the array
                else
                    $prereqs[] = $curr_field;
            }
            Skip_Whitespace($cursor, $curr_line);
        }

        if (isset($course))
        {
            // check for duplicate line headers
            if (isset($this->data_list["$course"]) == TRUE)
                return 3;
            else
                $this->data_list["$course"] = $prereqs;
            return 0;
        }
        else
            return 21;
    }
}

//******************************************************************************
//******************************************************************************
//    Class: Faculty_File_Reader
//    Description: Reads a "Faculty" File.  (extends File_Reader)
//******************************************************************************
//******************************************************************************
class Faculty_File_Reader extends File_Reader
{

    //This represents the name of the class.
    //It is used by Update_File_Info to identify
    //which part of the file_info structure needs
    //to be overwritten
    protected $name = "faculty";

    //**************************************************************************
    //    protected Function:  Read_A_Line
    //    Input: The current line
    //    Description: Scans the line and puts its information into a
    //      Faculty structure.  Places these structures into data_list.
    //      If an error is encountered, the program halts and returns the proper
    //      error code.
    //    Returns: 0 if successful;  Error number on error.
    //**************************************************************************
    protected Function Read_A_Line($curr_line)
    {
        $current_pos = 0;
        $error;
        $next_token;
        $current_faculty = new Faculty();

        // check if it is empty line
        if ((empty($curr_line) || $curr_line == ' '))
        {
            return 13;
        }
        else
        {
            // read the faculty name
            $error = Faculty_Name_Recognizer::read($curr_line, $current_pos);
            if (is_numeric($error))
                return $error;
            else
                $current_faculty->name = $error;

            // read the year of service
            $next_token = Grab_Field($current_pos, $curr_line, " ");
            $error = Year_Of_Service_Recognizer::read($next_token);

            if ($error != 0)
                return $error;
            else
                $current_faculty->year_of_service = $next_token;

            // read the faculty email
            $next_token = Grab_Field($current_pos, $curr_line, " ");
            if (strlen($next_token) == 0)
                return 24;
            else
                $current_faculty->email = $next_token;

            // read the faculty teaching hours
            $next_token = Grab_Field($current_pos, $curr_line, " ");
            $error = Integer_Recognizer::read($next_token, 0, 19);
            if ($error != 0)
                return $error;
            else
                $current_faculty->hour = $next_token;

            // check if the line contains extra data
            if (Contains_Extra_Data($current_pos, $curr_line))
                return 25;
            else
            {
                // check for duplicate fields
                foreach ($this->data_list as $next_token)
                {
                    if ($current_faculty->email == $next_token->email)
                        return 3;
                }

                $this->data_list[] = clone $current_faculty;
            }
            return 0;
         }
     }
}

?>


