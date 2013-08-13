Description: 
	this set of input files will create a scenario that only includes 400 level 
classes which results in the application could not schedule the classes which 
should be handled by admin manually.

Names:
Class times - "CT.txt"
	3 sections on each MWF
	3 sections on each TR
	2 night sections on MT

Available rooms - "AR.txt"
	10 rooms include 8 class rooms and 2 labs

Courses to schedule - "CL.txt"
	6 classes with each one has 2 day sections and 1 night section
	1 lab with 1 day section and 1 night section

Conflict Times - "CF.txt"
	simple conflict time file

Prerequisites - "PR.txt"
	simple prerequisites file

Faculty members - "FM.txt"
	assume that each faculty max teaching hour is 10
	10 faculties
	