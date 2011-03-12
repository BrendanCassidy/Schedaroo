#include <vector>
#include <string>
#ifndef dHall_H
#define dHall_H
using namespace std;

class Edge
{
public:
	float edgeType;
    bool fwd;
	float flow;
	float capacity;
	//Edge(string x, string y, int z);
	//Edge();
	//virtual Edge oedge();
	//~Edge();
	virtual void useless() {};
};

class SourceEdge: public Edge
{
public:
	string user;
	float contracted;
	float desired;
	SourceEdge(string x, float y, float z);
	SourceEdge();
	SourceEdge *rSourceEdge;
	//virtual Edge oedge();
	//~Edge();
};

class UserShiftEdge: public Edge
{
public:
	string user;
	string shift;
	float shiftLength;
	float rank;
	UserShiftEdge(string w, string x, float y, float z);
	UserShiftEdge();
	UserShiftEdge *rUserShiftEdge;
	//virtual Edge oedge();
	//~Edge();
};

class SinkEdge: public Edge
{
public:
	string shift;
	float shiftLength;
	SinkEdge(string x, float y);
	SinkEdge();
	SinkEdge *rSinkEdge;
	//virtual Edge oedge();
	//~Edge();
};

class DiningHall
{
public:
	vector <Edge*> edgeList;
	DiningHall(vector<Edge*> & edgeList);
	void addSourceEdge(vector<Edge*> & edgeList, string u, float v, float w);
	void addUserShiftEdge(vector<Edge*> & edgeList, string u, string v, float w, float x);
	void addSinkEdge(vector<Edge*> & edgeList, string u, float v);
	~DiningHall();
};
	
#endif
