<?php
//******************************************************************************
//    Ricky Moore
//******************************************************************************
//    Created on: 4/12/13
//    Last Edit on: 4/12/13
//******************************************************************************
//    This file defines all functionality for the scheduling algorithm.
//******************************************************************************
include 'Structures.php';

define("NO_TIME_ERROR",
   "There are no available time slots to assign the course.");
define("CONFLICT_ERROR",
   "All possible assignments conflict with existing scheduled courses.");
define("NO_ROOMS_ERROR",
   "There are no rooms available to accomodate the course.");
define("ROOMS_OCCUPIED_ERROR",
   "All valid rooms are occupied for available time slots.");
define("NO_FAC_ERROR",
   "There are no faculty members available to teach the course.");
define("UNWANTED_TIME",
   "'s preference was scheduled outside of their preferred time.");
define("PREF_UNSATISFIED",
   "'s preference could not be incorporated into the schedule.");

class Schedule_Generator
{
    private $file_info;
    private $prefs;
    private $faculty_list;
    private $error_list;
    private $schedule;
    private $not_scheduled;

    public function __construct()
    {
        //Get necessary information
        $this->prefs = Get_Prefs();
        $this->faculty_list = Get_Faculty_List();
        $this->file_info = @file_get_contents($_ENV['DIRECTORY'] . INFO_FILE);
        $this->error_list = array();
        $this->schedule = array();
        $this->not_scheduled = array();


        //Ensure the info file actually exists
        if($this->file_info == FALSE)
        {
            $err1 = "File: \"";
            $err2 = "\" is empty or does not exist.";
            throw new Exception($err1 . $_ENV['DIRECTORY'] . INFO_FILE . $err2);
        }
        //If it does, unpack the data it contains
        else
            $this->file_info = unserialize($this->file_info);

        //Ensure the info file contains valid data
        if(get_class($this->file_info) != "File_Info")
        {
            $error = " does not contain a File_Info object.";
            throw new Exception($_ENV['DIRECTORY'] . INFO_FILE . $error);
        }

        //Sort the list of courses by course-level, so that higher level courses
        //  will be scheduled before lower level ones, minimizing the work
        //  needed to handle conflicts.
        usort($this->file_info->course_list, "compare_course_level");

        //Classify the list of time slots into catagories for later use
        foreach( $this->file_info->class_times as $time )
            {
                if( $time->start < "11:00" )
                    $this->file_info->class_times['morning'][] = $time;
                if( $time->start > "14:00" )
                    $this->file_info->class_times['evening'][] = $time;
                else //11:00 <= $time->start <= 14:00
                    $this->file_info->class_times['midday'][] = $time;
            }
    }


    public function Generate()
    {
        //To prioritize higher class levels, split the preferences into 4
        //  separate arrays to be scheduled separately.
        $pref_list_segments = array();
        foreach( $this->prefs as $pref )
        {
            $level = get_course_level($pref->course_name);
            if( $level < "200" )
                $pref_list_segments[1][] = $pref;
            elseif( $level < "300" )
                $pref_list_segments[2][] = $pref;
            elseif( $level < "400" )
                $pref_list_segments[3][] = $pref;
            else
                $pref_list_segments[4][] = $pref;
        }

        //Do the same for courses.
        $course_list_segments = array();
        foreach( $this->file_info->course_list as $course )
        {
            $level = get_course_level($course->name);
            if( $level < "200" )
                $course_list_segments[1][] = $course;
            elseif( $level < "300" )
                $course_list_segments[2][] = $course;
            elseif( $level < "400" )
                $course_list_segments[3][] = $course;
            else
                $course_list_segments[4][] = $course;
        }

        //Schedule all 400 level classes, then 300 level, etc.
        for( $i=4; $i>=1; $i-- )
        {
            if( isset($pref_list_segments[$i]) )
                $this->Schedule_Preferences($pref_list_segments[$i]);
            if( isset($course_list_segments[$i]) )
            {
                $this->remove_scheduled_courses($course_list_segments[$i]);
                $this->Schedule_Courses($course_list_segments[$i]);
            }
        }

        /* DEBUG

        echo "<br><br>Schedule:<br><br>";
        foreach( $this->schedule as $s )
        {
            foreach( $s as $x )
            {
                var_dump( $x );
                echo "<br>";
            }
            echo "<br><br>";
        }

        echo "<br><br>Error List:<br><br>";
        foreach( $this->error_list as $e )
        {
            var_dump( $e );
            echo "<br><br>";
        }

        echo "<br><br>Not Scheduled:<br><br>";
        foreach( $this->not_scheduled as $n )
        {
            var_dump( $n );
            echo "<br><br>";
        }
        */

        return [$this->schedule, $this->error_list];
    }


    private function Schedule_Preferences($pref_list)
    {
        foreach( $pref_list as $pref )
        {
            $item = new Scheduled_Item;
            $item->error = null;

            foreach( $this->faculty_list as $fac )
                if( $pref->faculty_name == $fac->name )
                {
                    $item->faculty = $fac;
                    break;
                }

            $this->schedule_pref( $pref, $item );

            if( $item->error == null )
            {
               if( $item->course->section != "internet" )
                {
                    $scheduled = new Scheduled_Time;
                    $scheduled->days = $item->time_slot->days;
                    $scheduled->time = $item->time_slot->start;
                    $scheduled->course_name = $item->course->name;

                    $this->mark_busy( $item->room, $scheduled );
                    $this->mark_busy( $item->faculty, $scheduled );

                    //Note if the time scheduled is outside of the faculty's
                    //  preference. This is used later for heuristics.
                    if( ($pref->time_pref == 'morning' &&
                            $item->time_slot->start >= "11:00") ||
                        ($pref->time_pref == 'midday' &&
                            ($item->time_slot->start < "11:00" ||
                            $item->time_slot->start > "14:00"))  ||
                        ($pref->time_pref == 'evening' &&
                            $item->time_slot->start <= "14:00") )
                    {
                        $errormsg = $item->faculty->name . UNWANTED_TIME .
                            " Course: " . $pref->course_name .
                            ", Preference: " . $pref->time_pref .
                            ", Given: " . $item->time_slot->start;
                        $this->error_list[] = $errormsg;
                    }
                }

                $this->increment_hours( $item->faculty, $item->course->hours );
                $this->schedule[] = $item;


                //if pref is morning and time is after 11:00 or
                     //pref is midday and time is before 11:00 and after 2:00 or
                     //pref is night and time is before 2:00

                //Remove scheduled class from available courses
                foreach( $this->file_info->course_list as $key => $course )
                    if( $item->course->name == $course->name &&
                            $item->course->section == $course->section )
                    {
                        unset( $this->file_info->course_list[$key] );
                        break;
                    }
            }
            else
            {
                $errormsg = $item->faculty->name . PREF_UNSATISFIED .
                        " Course: " . $pref->course_name .
                        ", Preference: " . $pref->time_pref;
                $this->error_list[] = $errormsg;
            }
        }
    }


    private function Schedule_Courses($course_list)
    {
        foreach( $course_list as $course )
        {
            $item = new Scheduled_Item;
            $item->course = $course;
            $item->error = null;

            if( $item->course->section == "internet" )
            {
                $item->time_slot = new Class_Time;
                $item->time_slot->days = "N/A";
                $item->time_slot->start = "N/A";
                $item->time_slot->duration = 0;

                $item->room = new Room;
                $item->room->name = "Internet";
                $item->room->size = 100;
                $item->room->type = "N/A";

                $this->get_faculty( $item );
            }
            else
                $this->get_valid_time_slot( $item, null );

            if( $item->error == null)
            {
                if( $course->section != "internet" )
                {
                    $scheduled = new Scheduled_Time;
                    $scheduled->days = $item->time_slot->days;
                    $scheduled->time = $item->time_slot->start;
                    $scheduled->course_name = $item->course->name;

                    $this->mark_busy( $item->room, $scheduled );
                    $this->mark_busy( $item->faculty, $scheduled );
                }

                $this->increment_hours( $item->faculty, $item->course->hours );
                $this->schedule[] = $item;
            }
            else
            {
                $errormsg = $course->name . " (" . $course->section . ") " .
                        " could not be scheduled. Reason: " . $item->error;
                $this->error_list[] = $errormsg;
                $this->not_scheduled[] = $item;
            }
        }
    }

    private function schedule_pref( $pref, &$item )
    {
        $times = $this->file_info->class_times;
        if( $pref->time_pref == 'internet' )
        {
            foreach( $this->file_info->course_list as $c )
                if($c->name == $pref->course_name && $c->section == "internet")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                $item->time_slot = new Class_Time;
                $item->time_slot->days = "N/A";
                $item->time_slot->start = "N/A";
                $item->time_slot->duration = 0;

                $item->room = new Room;
                $item->room->name = "Internet";
                $item->room->size = 100;
                $item->room->type = "N/A";

                return;
            }
            //else, there's an error
        }
        elseif( $pref->time_pref == 'morning' )
        {
            //First, try to get day section
            foreach( $this->file_info->course_list as $c )
                if( $c->name == $pref->course_name && $c->section == "day")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                //Try to schedule morning
                $this->get_valid_time_slot( $item, $times['morning'] );
                if( $item->error == null )
                    return;
                else //Try to schedule midday
                {
                    $item->error = null;
                    $this->get_valid_time_slot( $item, $times['midday'] );
                    if( $item->error == null )
                        return;
                }
            }
            //else, there's an error
        }
        elseif( $pref->time_pref == 'midday' )
        {
            //First, try to get day section
            foreach( $this->file_info->course_list as $c )
                if( $c->name == $pref->course_name && $c->section == "day")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                //Try to schedule midday
                $this->get_valid_time_slot( $item, $times['midday'] );
                if( $item->error == null )
                    return;
                else //Try to schedule morning
                {
                    $item->error = null;
                    $this->get_valid_time_slot( $item, $times['morning'] );
                    if( $item->error == null )
                        return;
                }
            }

            //else, day cannot be scheduled. Try night.
            $item->course = null;
            foreach( $this->file_info->course_list as $c )
                if( $c->name == $pref->course_name && $c->section == "night")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                //Try to schedule evening
                $item->error = null;
                $this->get_valid_time_slot( $item, $times['evening'] );
                if( $item->error == null )
                    return;
            }
            //else, there's an error
        }
        else // $pref->time_pref == 'evening'
        {
            //First, try to get night section
            foreach( $this->file_info->course_list as $c )
                if( $c->name == $pref->course_name && $c->section == "night")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                //Try to schedule evening
                $this->get_valid_time_slot( $item, $times['evening'] );
                if( $item->error == null )
                    return;
            }

            //else, night cannot be scheduled. Try day.
            $item->course = null;
            foreach( $this->file_info->course_list as $c )
                if( $c->name == $pref->course_name && $c->section == "day")
                {
                    $item->course = $c;
                    break;
                }

            if( $item->course != null )
            {
                //Try to schedule midday
                $item->error = null;
                $this->get_valid_time_slot( $item, $times['midday'] );
                if( $item->error == null )
                    return;
            }
            //else, there's an error
        }

        $item->error = PREF_UNSATISFIED;
    }

    private function get_valid_times( &$item )
    {
        $times = $this->file_info->class_times;
        if( $item->course->section == "day" )
            return array_merge( $times['morning'], $times['midday'] );
        else //course section is "night"
            return $times['evening'];
    }

    private function get_valid_time_slot( &$item, $valid_times )
    {
        //Only need to get valid times if this isn't a preference
        if( $valid_times == null )
            $valid_times = $this->get_valid_times( $item );


        //Remove conflict times for course
        foreach( $valid_times as $key => $time )
            foreach( $this->file_info->conflict_times as $conflict )
                if( $item->course->name == $conflict->course_name &&
                        any_in_common($time->days, $conflict->days) &&
                        $time->start == $conflict->time )
                    unset($valid_times[$key]);

        if( empty($valid_times) )
        {
            $item->error = NO_TIME_ERROR;
            return;
        }

        //list is shuffled so that a random valid time will be chosen each time
        //this is to ensure course assignments are spread out
        shuffle( $valid_times );
        $conflict = false;
        foreach( $valid_times as $time )
        {
            if( $this->assignment_is_conflicting($item, $time) )
                $conflict = true;
            else
            {
                $item->time_slot = $time;
                $this->get_valid_room( $item );
                if( $item->error == null )
                {
                    if( $item->faculty == null )
                    {
                        $this->get_faculty( $item );
                        if( $item->error == null )
                            return; //valid assignment
                        else
                            $this->faculty = null;
                    }
                    else //we're scheduling a preference and we're done already
                        return;
                }
            }
        }

        if( $conflict == true )
            $item->error = CONFLICT_ERROR;
    }


    private function get_valid_room( &$item )
    {
        $valid_rooms = array();
        foreach( $this->file_info->available_rooms as $room )
        {
            if( $room->type == $item->course->type &&
                    (int) $room->size >= (int)$item->course->size )
              $valid_rooms[] = $room;
        }

        if( empty($valid_rooms) )
        {
            $item->error = NO_ROOMS_ERROR;
            return;
        }

        usort($valid_rooms, array("Room", "compare"));
        foreach( $valid_rooms as $room )
            if( not_busy($room->scheduled_times, $item->time_slot) )
            {
                $item->room = $room;
                return;
            }

        $item->error = ROOMS_OCCUPIED_ERROR;
    }


    //Returns faculty with least current hours
    private function get_faculty( &$item )
    {
        $min = 100;

        foreach( $this->faculty_list as $f )
            if( (int)$f->current_hours < (int)$f->min_hours &&
                    $f->current_hours < $min &&
                    not_busy( $f->scheduled_times, $item->time_slot ))
            {
                $min = $f->current_hours;
                $item->faculty = $f;
            }

        if( $min == 100 ) //All faculty busy or scheduled up to hours quota
            $item->error = NO_FAC_ERROR;
    }

    //Removes courses from the list that are in the schedule.
    private function remove_scheduled_courses( &$course_list )
    {
        foreach( $course_list as $key => $course )
            foreach( $this->schedule  as $scheduled_item )
            {
                if( $scheduled_item->course->name == $course->name &&
                        $scheduled_item->course->section == $course->section )
                {
                    unset($course_list[$key]);
                    break;
                }
            }
    }


    //Checks for course level conflicts between 300-400 level courses
    private function assignment_is_conflicting( $item, $time )
    {
        $level = get_course_level( $item->course->name );
        if( $level < "300" ) //Courses 200 and below don't conflict
            return false;

        foreach( $this->schedule as $s )
            if( $s->course->section != "internet" &&
                    get_course_level($s->course->name) >= 300 &&
                    !$this->is_prereq($item->course->name, $s->course->name) &&
                    $s->time_slot->start == $time->start &&
                    any_in_common( $s->time_slot->days, $time->days) )
                return true;

        return false;
    }


    //Returns true if either course is a prereq of the other, false otherwise
    private function is_prereq( $course1, $course2 )
    {
        $prereqs = $this->file_info->prereq_list;
        if( isset( $prereqs[$course1] ) )
            if( in_array( $course2, $prereqs[$course1] ) )
                return true;

        if( isset( $prereqs[$course2] ) )
            if( in_array( $course1, $prereqs[$course2] ) )
                return true;

        return false;

    }

    private function mark_reserved( $room, $scheduled_time )
    {
        foreach( $this->file_info->available_rooms as $r )
            if( $room->name == $r->name )
            {
                $r->scheduled_times[] = $scheduled_time;
                return;
            }
    }

    private function mark_busy( $faculty, $scheduled_time )
    {
        foreach( $this->faculty_list as $f )
            if( $faculty->name == $f->name )
            {
                $f->scheduled_times[] = $scheduled_time;
                return;
            }
    }

    private function increment_hours( $faculty, $hours )
    {
        foreach( $this->faculty_list as $f )
            if( $faculty->name == $f->name )
            {
                $f->current_hours += $hours;
                return;
            }
    }
}

function Get_Faculty_List()
{
    //get faculty from database
    //-> shadow database list with list of new _Faculty objects

    //temporary hack -->
    //create manual structure for each scenario and read from file
    $fac = unserialize( file_get_contents( $_ENV['DIRECTORY'].FACULTY_FILE ) );
    return $fac;
}

function Get_Prefs()
{
    $prefs = unserialize( file_get_contents( $_ENV['DIRECTORY'].PREF_FILE ) );

    //if $_ENV['PRIORITIZE_SENIORITY'] == TRUE
        //prefs is sorted by seniority and sub-sorted by submission order
    //Else, prefs is sorted only by submission order

    usort($prefs, array("Pref", "compare"));
    return $prefs;
}

function any_in_common( $days1, $days2 )
{
    $days1 = str_split($days1);
    $days2 = str_split($days2);
    foreach( $days1 as $d1 )
        foreach( $days2 as $d2 )
            if( $d1 == $d2 )
                return true; //at least one day in common

    return false; //no days in common
}

function get_course_level( $course )
{
    preg_match("/\d{3}/", $course, $level);
    return $level[0];
}

//prioritize larger classes to try for better room placement
function compare_course_level($c1, $c2)
{
    $c1_level = get_course_level($c1->name)[0];
    $c2_level = get_course_level($c2->name)[0];

    if( $c1_level == $c2_level )
        if( $c1->size == $c2->size )
            return 0;
        else
            return ($c1->size < $c2->size) ? +1 : -1;

    return ($c1_level < $c2_level) ? +1 : -1;
}

function not_busy( $scheduled_times, $time )
{
    foreach( $scheduled_times as $s )
        if( any_in_common( $s->days, $time->days ) &&
                $s->time == $time->start )
            return false;

    return true;
}

function condense_schedule( $schedule )
{
    $condensed = array();
    foreach( $schedule as $s )
    {
        $c = new Scheduled_Item_Condensed;
        $c->course_name = $s->course->name;
        $c->faculty_name = $s->faculty->name;
        $c->room_name = $s->room->name;
        $c->time_slot = $s->time_slot->days . " " .
                        $s->time_slot->start . " (" .
                        $s->time_slot->duration . " min)";
        $condensed[] = $c;
        unset($c);
    }

    return $condensed;
}

function compute_weights($error_list)
{
    $score = 0;
    foreach( $error_list as $error )
    {
        if( preg_match("/preferred time/",$error) )
            $score += $_ENV['ERROR_WEIGHTS']['UNWANTED_TIME'];
        elseif( preg_match("/preference/", $error) )
            $score += $_ENV['ERROR_WEIGHTS']['UNSATISFIED_PREF'];
        else
        {
            $level = get_course_level($error);
            if( $level < "200" )
                $score += $_ENV['ERROR_WEIGHTS']['100_LEVEL'];
            elseif( $level < "300" )
                $score += $_ENV['ERROR_WEIGHTS']['200_LEVEL'];
            elseif( $level < "400" )
                $score += $_ENV['ERROR_WEIGHTS']['300_LEVEL'];
            else //400+
                $score += $_ENV['ERROR_WEIGHTS']['400_LEVEL'];
        }
    }

    return $score;
}

function Generate_Schedule()
{
    $best = $_ENV['INFINITY'];
    for( $i=0; $i<$_ENV['NUM_SCHEDULE_ATTEMPTS']; $i++ )
    {
        $gen = new Schedule_Generator();
        $ret_vals = $gen->Generate();
        $schedule = $ret_vals[0];
        $error_list = $ret_vals[1];

        $error_weight = compute_weights($error_list);
        if( $error_weight < $best )
        {
            $best_schedule = $schedule;
            $best_error_list = $error_list;
            $best = $error_weight;
        }

        unset($gen);
    }

    $best_schedule = condense_schedule( $best_schedule );

    return [$best_schedule, $best_error_list];
}
?>
