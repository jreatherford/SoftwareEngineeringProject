Description: 
	this set of input files will create a scenario that amount of hours 
to be taught are greater than all the faculties can teach when there are enough
rooms and available times. After running the schedule algorithm, the Admin 
will be noticed that some classes can not be schedule due to lack of faculties.

Names:
Class times - "CT.txt"
	3 sections on each MWF
	3 sections on each TR
	2 night sections on MT

Available rooms - "AR.txt"
	 10 rooms include 8 class rooms and 2 labs

Courses to schedule - "CL.txt"
	3 classes with each has 2 day sections and 1 night section
	1 lab that has 1 day section and 1 night section

Conflict Times - "CF.txt"
	simple conflict time file

Prerequisites - "PR.txt"
	simple prerequisites file

Faculty members - "FM.txt"
	assume that each faculty max teaching hour is 10
	2 faculties