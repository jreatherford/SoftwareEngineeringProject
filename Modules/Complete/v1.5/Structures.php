<?php
//******************************************************************************
//    James Reatherford
//    Hongbin Yu
//    Ricky Moore
//******************************************************************************
//    Created on: 4/11/13
//    Last Edit on: 4/20/13
//******************************************************************************
//    This file contains a set of classes that will be used by the file input
//    modules as well as the schedueling algorithm.
//******************************************************************************

@define("INFO_FILE", "info_file.dat");
@define("PREF_FILE", "prefs.dat");
@define("SEMESTER_FILE", "semesters.dat");
@define("RULES_FILE", "rules.dat");
@define("FACULTY_FILE", "fac.dat");
@define("SCHEDULE_FILE", "schedule.dat");
@define("ERROR_FILE", "errors.txt");
@define("EXCEL_FILE", "schedule.csv");
@define("SCHEDULES_DIR","SCHEDULES~!\\");

//******************************************************************************
//    Class:  File Info
//    Description: This class holds all the information that comes in from
//     the input files (except the faculty file which goes to the database)
//******************************************************************************
class File_Info
{
    public $class_times = array();
    public $available_rooms = array();
    public $course_list = array();
    public $conflict_times = array();
    public $prereq_list = array();
}

//******************************************************************************
//    Class:  Class_Time
//    Description: Holds the information for a time slot
//******************************************************************************
class Class_Time
{
    public $days;
    public $start;
    public $duration;
}

//******************************************************************************
//    Class:  Room
//    Description: Holds information about a single room
//******************************************************************************
class Room
{
    public $name;
    public $size;
    public $type;
    public $scheduled_times = array();

    static function compare($r1, $r2)
    {
        if( $r1->size == $r2->size )
            return 0;
        return ($r1->size > $r2->size) ? +1 : -1;
    }
}

//******************************************************************************
//    Class:  Course
//    Description: Holds information about a single offered course
//******************************************************************************
class Course
{
    public $name;
    // section is limited to one of (day, night, internet)
    public $section;
    public $size;
    public $type;
    public $hours;
}

//******************************************************************************
//    Class:  Conflict_Time
//    Description: Holds information pertaining to a conflict to be avoided
//******************************************************************************
class Conflict_Time
{
    public $course_name;
    public $days;
    public $time;
}

//******************************************************************************
//    Class:  Pref
//    Description: Holds a single faculty preference
//******************************************************************************
class Pref
{
    public $faculty_name;
    public $course_name;
    public $time_pref;
    public $seniority;
    public $pref_num;

    static function compare($l, $r)
    {
        if( $_SESSION['PRIORITIZE_SENIORITY'] == TRUE )
            if( $l->seniority != $r->seniority )
                return ($l->seniority < $r->seniority) ? +1 : -1;

        if( $l->pref_num != $r->pref_num )
            return ($l->pref_num > $r->pref_num) ? +1 : -1;
        else
            return 0;
    }
}

//******************************************************************************
//    Class:  Faculty
//    Description: Holds information about a faculty memeber (to be added to
//     the database)
//******************************************************************************
class Faculty
{
    public $email;
    public $name;
    public $year_of_service;
    public $hour;
}

//******************************************************************************
//    Class:  Faculty
//    Description: Holds information about a faculty memeber (used for schedule
//     generation).
//******************************************************************************
class _Faculty
{
    public $name;
    public $seniority;
    public $min_hours;
    public $current_hours;
    public $scheduled_times = array();
}

//******************************************************************************
//    Class:  Scheduled_Time
//    Description: Holds information about when a room is reserved or a faculty
//     member is busy.
//******************************************************************************
class Scheduled_Time
{
    public $days;
    public $time;
    public $course_name;
}

//******************************************************************************
//    Class:  Scheduled_Item
//    Description: Groups scheduled elements together in a single item.
//******************************************************************************
class Scheduled_Item
{
    public $course;
    public $time_slot;
    public $room;
    public $faculty;
    public $error;
}

//******************************************************************************
//    Class:  Scheduled_Item_Condensed
//    Description: Holds the condensed information of a scheduled item
//******************************************************************************
class Scheduled_Item_Condensed
{
    public $course_name;
    public $time_slot;
    public $faculty_name;
    public $room_name;
}

class semester_dir
{
    public $path;
    public $current;

}

class Rules
{
    public $seniority;
    public $attempts;
    public $weight_100;
    public $weight_200;
    public $weight_300;
    public $weight_400;
    public $weight_unwanted_time;
    public $weight_unsatisfied_pref;

}
?>