Description: 
	this set of input files will create a scenario that amount of hours 
to be taught are greater than the department can hold when there are enough
faculties. The amount the department can hold depends on the class times
and available rooms. The output results in some classes can not be scheduled
due to not enough rooms or times even faculties have seleted their preferences.

Names:
Class times - "CT.txt"
	2 sections on each MWF
	2 sections on each TR
	1 night sections on M

Available rooms - "AR.txt"
	1 classrooms and 1 lab

Courses to schedule - "CL.txt"
	2 classes with each has 3 day sections and 1 night section
	1 lab with 1 day section and 1 night section

Conflict Times - "CF.txt"
	simple conflict time file

Prerequisites - "PR.txt"
	simple prerequisites file

Faculty members - "FM.txt"
	assume that each faculty max teaching hour is 10
	there are 10 faculties
	