/*Left to do:
 *	Randomize the choosing of workers to do more than desired, yet less than contracted, hours
 *	Check for division by zero error
 *	Garbage Collection
 *	Optimize "if" statements and code in general
 *	Think about metrics for choosing
 */


#include <iostream>
#include <vector>
#include <algorithm>
#include <string>
#include <utility> // make_pair
#include <stdio.h>
#include <stdlib.h>
#include <sstream>
#include <map>
#include "fileParser.h"
#include "dHall.h"
using namespace std;

SourceEdge::SourceEdge(string x, float y, float z)
{
	edgeType = 1;
    fwd = true;
    string source ("source");
	user = x; 
	contracted = y; 
	desired = z; 
	flow = 0;
	capacity = contracted;
}

SourceEdge::SourceEdge(){}

UserShiftEdge::UserShiftEdge(string w, string x, float y, float z)
{
	edgeType = 2;
    fwd = true;
	user=w; 
	shift=x; 
	shiftLength=y; 
	rank = z;
	flow = 0;
	capacity = shiftLength;
}

UserShiftEdge::UserShiftEdge(){}

SinkEdge::SinkEdge(string x, float y)
{
	edgeType = 3;
    fwd = true;
	string sink ("sink");
	shift=x; 
	shiftLength=y; 
	flow = 0;
	capacity = shiftLength;
}

SinkEdge::SinkEdge(){}

//Edge::~Edge(){}

bool compare(std::pair<std::string, float> i, pair<std::string, float> j)
{
	return i.second < j.second;
}

string IntToString(int i)
{
	string s;
	stringstream out;
	out << i;
	s = out.str();
	return s;
}

/*
MapHolder::MapHolder()
{
	map<string, float> userContracted;
	map<string, float> userDesired;
	map<string, float> userAssigned;
	map<string, string> userShift;
	map<string, float> shiftLength;
	map<
	map<string, string> assignments;
}
*/

DiningHall::DiningHall(vector<Edge*> & edgeList)
{
	DiningHall::edgeList = edgeList;
}

DiningHall::~DiningHall()
{
	for (vector<Edge*>::iterator iter = edgeList.begin(); iter != edgeList.end(); ++iter)
	{
		//cout << "garbage collecting edge" << endl;
		delete (*iter);
	}
}

void DiningHall::addSourceEdge(vector<Edge*> & edgeList, string u, float v, float w)
{
	SourceEdge* fedge = new SourceEdge(u, v, w);
	//SourceEdge* redge = new SourceEdge(u, v, w);
	//redge->fwd = false;
	//fedge->rSourceEdge = redge;
	//redge->rSourceEdge = fedge;
	edgeList.push_back(fedge);
	//edgeList.push_back(redge);
}

void DiningHall::addUserShiftEdge(vector<Edge*> & edgeList, string u, string v, float w, float x)
{
	UserShiftEdge* fedge = new UserShiftEdge(u, v, w, x);
	//UserShiftEdge* redge = new UserShiftEdge(u, v, w, x);
	//redge->fwd = false;
	//fedge->rUserShiftEdge = redge;
	//redge->rUserShiftEdge = fedge;
	edgeList.push_back(fedge);
	//edgeList.push_back(redge);
}

void DiningHall::addSinkEdge(vector<Edge*> & edgeList, string u, float v)
{
	SinkEdge* fedge = new SinkEdge(u, v);
	//SinkEdge* redge = new SinkEdge(u, v);
	//redge->fwd = false;
	//fedge->rSinkEdge = redge;
	//redge->rSinkEdge = fedge;
	edgeList.push_back(fedge);
	//edgeList.push_back(redge);
}

float getHoursContractedByUser(vector<Edge*> & edgeList, string u)
{
	Edge* ptr;
	int j;
	for (j=0; j < edgeList.size(); j++)
	{
		ptr = edgeList.at(j);
		if ((ptr->edgeType == 1) && (!dynamic_cast<SourceEdge*>(ptr)->user.compare(u)))
		{
			return dynamic_cast<SourceEdge*>(ptr)->contracted;
		}
	}
}

float getRemainingHoursContractedByUser(vector<Edge*> & edgeList, string u)
{
	Edge* ptr;
	int j;
	for (j=0; j < edgeList.size(); j++)
	{
		ptr = edgeList.at(j);
		if ((ptr->edgeType == 1) && (!dynamic_cast<SourceEdge*>(ptr)->user.compare(u)))
		{
			return dynamic_cast<SourceEdge*>(ptr)->contracted - dynamic_cast<SourceEdge*>(ptr)->flow;
		}
	}
}

float getHoursDesiredByUser(vector<Edge*> & edgeList, string u)
{
	Edge* ptr;
	int j;
	for (j=0; j < edgeList.size(); j++)
	{
		ptr = edgeList.at(j);
		if ((ptr->edgeType == 1) && (!dynamic_cast<SourceEdge*>(ptr)->user.compare(u)))
		{
			return dynamic_cast<SourceEdge*>(ptr)->desired;
		}
	}
}

float getRemainingHoursDesiredByUser(vector<Edge*> & edgeList, string u)
{
	Edge* ptr;
	int j;
	for (j=0; j < edgeList.size(); j++)
	{
		ptr = edgeList.at(j);
		if ((ptr->edgeType == 1) && (!dynamic_cast<SourceEdge*>(ptr)->user.compare(u)))
		{
			return dynamic_cast<SourceEdge*>(ptr)->desired - dynamic_cast<SourceEdge*>(ptr)->flow;
		}
	}
}

bool isUserAlreadyWorkingThisMeal(string user, vector<Edge*> assignments, string shift)
{
	int j;
	Edge *ptr;
	bool result = false;
	for (j=0; j < assignments.size(); j++)
	{
		ptr = assignments.at(j);
		if (!dynamic_cast<UserShiftEdge*>(ptr)->user.compare(user))
		{
			//cout << "-IUAWTM: " << dynamic_cast<UserShiftEdge*>(ptr)->shift.substr(0,2) << endl;
			//cout << "--IUAWTM: " << shift.substr(0,2) << endl;
			//cout << !dynamic_cast<UserShiftEdge*>(ptr)->shift.substr(0,2).compare(shift.substr(0,2)) << endl;
			if (!dynamic_cast<UserShiftEdge*>(ptr)->shift.substr(0,2).compare(shift.substr(0,2)))
			{
				result = true;
			}
		}
	}
	return result;
}

void updateDiningHall(vector<Edge*> & edgeList, map<string, float> & userHours, map<string, float> & userHoursRatio, map<string, float> & shiftInDegree, vector<Edge*> & assignments, string shift, string user, int &userShiftEdges)
{
	int j;
	Edge *ptr;
	shiftInDegree.erase(shiftInDegree.find(shift));
	for (j=0; j < edgeList.size(); j++)
	{	
		if (edgeList.at(j)->edgeType == 1)
		{
			ptr = edgeList.at(j);
			if (!dynamic_cast<SourceEdge*>(ptr)->user.compare(user))
			{
				dynamic_cast<SourceEdge*>(ptr)->flow += dynamic_cast<UserShiftEdge*>(assignments.at(assignments.size()-1))->shiftLength;
			}
		}
		else if (edgeList.at(j)->edgeType == 2)
		{	
			ptr = edgeList.at(j);
			if (!dynamic_cast<UserShiftEdge*>(ptr)->shift.compare(shift)) 
			{
				edgeList.erase(edgeList.begin() + j);
				userHours[dynamic_cast<UserShiftEdge*>(ptr)->user] = 0;
				userHoursRatio[dynamic_cast<UserShiftEdge*>(ptr)->user] = 0;
				j--;
			}
			else 
			{
				userHours[dynamic_cast<UserShiftEdge*>(ptr)->user] = 0;
				userHoursRatio[dynamic_cast<UserShiftEdge*>(ptr)->user] = 0;
				shiftInDegree[dynamic_cast<UserShiftEdge*>(ptr)->shift] = 0;
			}
		}
	}
	userShiftEdges = 0;
	for (j=0; j < edgeList.size(); j++)
	{
		//cout << "loop!" << endl;
		if (edgeList.at(j)->edgeType == 2) 
		{
			userShiftEdges = 1;
			//cout << "2!" << endl;
			ptr = edgeList.at(j);
			cout << dynamic_cast<UserShiftEdge*>(ptr)->user << " ";
			cout << dynamic_cast<UserShiftEdge*>(ptr)->shift << endl;
			userHours[dynamic_cast<UserShiftEdge*>(ptr)->user] += dynamic_cast<UserShiftEdge*>(ptr)->shiftLength;
			userHoursRatio[dynamic_cast<UserShiftEdge*>(ptr)->user] += dynamic_cast<UserShiftEdge*>(ptr)->shiftLength;
			shiftInDegree[dynamic_cast<UserShiftEdge*>(ptr)->shift]++;
		}
	}	

	for (j=0; j < edgeList.size(); j++)
	{
		if (edgeList.at(j)->edgeType == 1)
		{
			ptr = edgeList.at(j);
			userHoursRatio[dynamic_cast<SourceEdge*>(ptr)->user] /= dynamic_cast<SourceEdge*>(ptr)->desired;
		}
	}
}

int main(int argc, char * argv[])
{
	//cout << "starting main" << endl;
	//cout << "argc: " << argc << endl;
	if (argc != 2) { return 0; }
	int i;
	int j;
	vector<Edge*> edgeyList;
	map<string, float> userHours;
	map<string, float> userHoursRatio;
	map<string, float> shiftInDegree;
	vector<Edge*> assignments;
	DiningHall* dh = new DiningHall(edgeyList);
    Edge *ptr = NULL;
    string userToAssign;
    std:pair<string, float> shiftPairToAssign;
    string shiftToAssign;
    string currentShift;
    float currentShiftLength;
    string currentUser;
    char input [strlen(argv[1])+1];
    strcpy(input,argv[1]);
    int userShiftEdges;
    int count = 1;
    
	cout << "calling fileParser" << endl;
	fileParser(dh, input);
	cout << "done calling fileParser" << endl;
	
	userShiftEdges = 0;
	for (j=0; j < dh->edgeList.size(); j++)
	{
		//cout << "loop!" << endl;
		//if ((dh->edgeList.at(j)->edgeType == 2) && (dh->edgeList.at(j)->fwd)) {
		if (dh->edgeList.at(j)->edgeType == 2) 
		{
			userShiftEdges = 1;
			//cout << "2!" << endl;
			ptr = dh->edgeList.at(j);
			cout << dynamic_cast<UserShiftEdge*>(ptr)->user << " ";
			cout << dynamic_cast<UserShiftEdge*>(ptr)->shift << endl;
			userHours[dynamic_cast<UserShiftEdge*>(ptr)->user] += dynamic_cast<UserShiftEdge*>(ptr)->shiftLength;
			userHoursRatio[dynamic_cast<UserShiftEdge*>(ptr)->user] += dynamic_cast<UserShiftEdge*>(ptr)->shiftLength;
			shiftInDegree[dynamic_cast<UserShiftEdge*>(ptr)->shift]++;
		}
	}	

	for (j=0; j < dh->edgeList.size(); j++)
	{
		if (dh->edgeList.at(j)->edgeType == 1)
		{
			ptr = dh->edgeList.at(j);
			userHoursRatio[dynamic_cast<SourceEdge*>(ptr)->user] /= dynamic_cast<SourceEdge*>(ptr)->desired;
		}
	}
	
	map<string, float>::const_iterator iter;
    for (iter=userHoursRatio.begin(); iter != userHoursRatio.end(); ++iter) {
        cout << iter->second << " " << iter->first << endl;
    }
    for (iter=shiftInDegree.begin(); iter != shiftInDegree.end(); ++iter) {
        cout << iter->second << " " << iter->first << endl;
    }
    while (userShiftEdges)
    {
    	shiftPairToAssign = *min_element(shiftInDegree.begin(), shiftInDegree.end(), compare);
    	shiftToAssign = shiftPairToAssign.first;
    	userToAssign = "NULL";
    	//std::vector<Edge*>::iterator vIter;
    	for (j=0; j < dh->edgeList.size(); j++)
		{
			ptr = dh->edgeList.at(j);
			if (ptr->edgeType == 2)
			{
				currentShift = dynamic_cast<UserShiftEdge*>(ptr)->shift;
				currentShiftLength = dynamic_cast<UserShiftEdge*>(ptr)->shiftLength; //This line is inefficient.
				currentUser = dynamic_cast<UserShiftEdge*>(ptr)->user;
				//Assign desired hours if possible
				//If the current shift is the one current being assigned a worker...
				//If the worker desires more hours than already scheduled...
				//If the worker can work this shift within his/her remaining hours contracted...
				cout << "(!currentShift.compare(shiftToAssign)" << (!currentShift.compare(shiftToAssign)) << endl;
				cout << currentShift << "::" << shiftToAssign << endl;
				cout << "(getRemainingHoursDesiredByUser(dh->edgeList, currentUser) > 0)" << (getRemainingHoursDesiredByUser(dh->edgeList, currentUser) > 0) << endl;
				cout << "(getRemainingHoursContractedByUser(dh->edgeList, currentUser) > currentShiftLength)" << (getRemainingHoursContractedByUser(dh->edgeList, currentUser) >= currentShiftLength) << endl;
				if ((!currentShift.compare(shiftToAssign)) && \
					(getRemainingHoursDesiredByUser(dh->edgeList, currentUser) > 0) && \
					(getRemainingHoursContractedByUser(dh->edgeList, currentUser) >= currentShiftLength) && \
					(!isUserAlreadyWorkingThisMeal(currentUser, assignments, currentShift)))
				{
					cout << "user " << dynamic_cast<UserShiftEdge*>(ptr)->user << " desires " << \
					getRemainingHoursDesiredByUser(dh->edgeList, dynamic_cast<UserShiftEdge*>(ptr)->user) << " more hours." << endl;
					if ((!userToAssign.compare("NULL")) || (userHoursRatio[userToAssign] > userHoursRatio[currentUser])) //If this is the first viable worker or the most difficult worker to schedule...
					{
						userToAssign = currentUser;
						i = j;
					}
				}
				//If no desired hours can be assigned, assigned contracted hours if possible.
				//If no viable worker with desired hours was found...
				//If the current shift is the one current being assigned a worker...
				//If the worker can work this shift within his/her remaining hours contracted...
				if ((!userToAssign.compare("NULL")) && (!currentShift.compare(shiftToAssign)) && \
					(getRemainingHoursContractedByUser(dh->edgeList, currentUser) > currentShiftLength) && \
					(!isUserAlreadyWorkingThisMeal(currentUser, assignments, currentShift)))
				{
					if ((!userToAssign.compare("NULL")) || (userHoursRatio[userToAssign] > userHoursRatio[currentUser])) //If this is the first viable worker or the most difficult worker to schedule...
					{
						userToAssign = currentUser;
						i = j;
					}
				}
			}
    	}
    	
    	cout << "userToAssign: " << userToAssign << endl;
    	cout << "shiftToAssign: " << shiftToAssign << endl;
    	
    	if (userToAssign.compare("NULL"))
    	{
    		assignments.push_back(dh->edgeList.at(i));
    		
    		//dh->edgeList.erase(dh->edgeList.begin() + i);
    		//updateDiningHall(dh->edgeList, userHours, userHoursRatio, shiftInDegree, shiftToAssign, userShiftEdges);
		}
		updateDiningHall(dh->edgeList, userHours, userHoursRatio, shiftInDegree, assignments, shiftToAssign, userToAssign, userShiftEdges);
    	/*count++;
    	if (count > 2)
    	{
    		count = 0;
    	}*/
    }
    
	//cout << "Enter Something to End" << endl;
	//cin >> i;
	delete dh;
	return 0;
}
