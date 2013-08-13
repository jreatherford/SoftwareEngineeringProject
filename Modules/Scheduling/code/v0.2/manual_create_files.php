<?php


/* Scenario 1: */

        $fac_list = array();

        $a = new _Faculty;
        $a->name = "Parker, Peter";
        $a->seniority = 10;
        $a->min_hours = 12;
        $a->current_hours = 0;
        $fac_list[] = $a;
        unset($a);

        $a = new _Faculty;
        $a->name = "Richards, Reed";
        $a->seniority = 40.5;
        $a->min_hours = 18;
        $a->current_hours = 0;
        $fac_list[] = $a;
        unset($a);

        $a = new _Faculty;
        $a->name = "Wayne, Bruce";
        $a->seniority = 20;
        $a->min_hours = 12;
        $a->current_hours = 0;
        $fac_list[] = $a;
        unset($a);

/* SCENARIO 2:


        $a = new _Faculty;
        $a->name = "Adam, Larry";
        $a->seniority = 5.5;
        $a->min_hours = 12;
        $a->current_hours = 0;
        $fac_list[] = $a;
        unset($a);

        $a = new _Faculty;
        $a->name = "Aguado, Alex";
        $a->seniority = 3;
        $a->min_hours = 12;
        $a->current_hours = 0;
        $fac_list[] = $a;
        unset($a);

        $fac_list = serialize( $fac_list );
        file_put_contents( $_ENV['DIRECTORY'].FACULTY_FILE, $fac_list );

*/
        $pref_list = array();

/*   Scenario 1: */
        $a = new Pref;
        $a->faculty_name = "Parker, Peter";
        $a->course_name = "RE425";
        $a->time_pref = "midday";
        $a->seniority = 10;
        $a->pref_num = 1;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Parker, Peter";
        $a->course_name = "RE404L";
        $a->time_pref = "midday";
        $a->seniority = 10;
        $a->pref_num = 2;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Parker, Peter";
        $a->course_name = "RE099";
        $a->time_pref = "morning";
        $a->seniority = 10;
        $a->pref_num = 3;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Richards, Reed";
        $a->course_name = "RE425";
        $a->time_pref = "evening";
        $a->seniority = 40.5;
        $a->pref_num = 4;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Richards, Reed";
        $a->course_name = "RE417";
        $a->time_pref = "evening";
        $a->seniority = 40.5;
        $a->pref_num = 5;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Wayne, Bruce";
        $a->course_name = "RE425";
        $a->time_pref = "morning";
        $a->seniority = 20;
        $a->pref_num = 6;
        $pref_list[] = $a;

        $a = new Pref;
        $a->faculty_name = "Wayne, Bruce";
        $a->course_name = "RE404L";
        $a->time_pref = "morning";
        $a->seniority = 20;
        $a->pref_num = 7;
        $pref_list[] = $a;


/* SCENARIO 2:
        $a = new Pref;
        $a->faculty_name = "Adam, Larry";
        $a->course_name = "CS245";
        $a->time_pref = "morning";
        $a->seniority = 5.5;
        $a->pref_num = 1;
        $pref_list[] = $a;


        unset($a);

        $a = new Pref;
        $a->faculty_name = "Adam, Larry";
        $a->course_name = "CS355";
        $a->time_pref = "evening";
        $a->seniority = 5.5;
        $a->pref_num = 2;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Adam, Larry";
        $a->course_name = "CS499";
        $a->time_pref = "midday";
        $a->seniority = 5.5;
        $a->pref_num = 3;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Adam, Larry";
        $a->course_name = "CS410W";
        $a->time_pref = "midday";
        $a->seniority = 5.5;
        $a->pref_num = 4;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Aguado, Alex";
        $a->course_name = "CS499";
        $a->time_pref = "midday";
        $a->seniority = 3;
        $a->pref_num = 5;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Aguado, Alex";
        $a->course_name = "CS410W";
        $a->time_pref = "morning";
        $a->seniority = 3;
        $a->pref_num = 6;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Aguado, Alex";
        $a->course_name = "CS355";
        $a->time_pref = "morning";
        $a->seniority = 3;
        $a->pref_num = 7;
        $pref_list[] = $a;
        unset($a);

        $a = new Pref;
        $a->faculty_name = "Aguado, Alex";
        $a->course_name = "CS410W";
        $a->time_pref = "night";
        $a->seniority = 3;
        $a->pref_num = 8;
        $pref_list[] = $a;
        unset($a);
*/
        $pref_list = serialize( $pref_list );
        file_put_contents( $_ENV['DIRECTORY'].PREF_FILE, $pref_list );
 ?>