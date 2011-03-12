#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <string>
#include <vector>
#include <string>
#include "dHall.h"
#include "fileParser.h"


using namespace std;

/*
 *Takes input of the form
 *
 *UserID\HoursContracted\HoursDesired\UserID\HoursContracted\HoursDesired\...UserID\HoursContracted\HoursDesired\
 *UserID\ShiftID\ShiftLength\Rank\UserID\ShiftID\ShiftLength\Rank\...UserID\ShiftID\ShiftLength\Rank\
 *
 */
void fileParser(DiningHall* dh, char * s) {
    char * list1;
    char * list2;
    char * list3;
	string user;
	string hoursContracted;
	string hoursDesired;
	string shift;
	string rank;
	string shiftLength;
	list1 = strtok (s, "\n");
	list2 = strtok (NULL, "\n");
	//cout << "list1: " << list1 << endl;
	list1 = strtok (list1, "\\");
	while (list1 != NULL)
	{
		//cout << "user obtainted" << endl;
		//cout << "user: " << list1 << endl;
		user = list1;
		list1 = strtok(NULL, "\\");
		hoursContracted = list1;
		list1 = strtok(NULL, "\\");
		hoursDesired = list1;
		dh->addSourceEdge(dh->edgeList, user, atof(hoursContracted.c_str()), atof(hoursDesired.c_str()));
		list1 = strtok(NULL, "\\");
		//cout << "end of loop" << endl;
	}
	list2 = strtok (list2, "\\");
	while (list2 != NULL)
	{
		//cout << "user obtainted" << endl;
		//cout << "user: " << list2 << endl;
		user = list2;
		list2 = strtok(NULL, "\\");
		//cout << "shift obtainted" << endl;
		//cout << "shift: " << list2 << endl;
		shift = list2;
		list2 = strtok(NULL, "\\");
		shiftLength = list2;
		list2 = strtok(NULL, "\\");
		rank = list2;
		dh->addUserShiftEdge(dh->edgeList, user, shift, atof(shiftLength.c_str()), atof(rank.c_str()));
		dh->addSinkEdge(dh->edgeList, shift, atof(shiftLength.c_str()));
		list2 = strtok(NULL, "\\");
		//cout << "end of loop2" << endl;
	}
}
