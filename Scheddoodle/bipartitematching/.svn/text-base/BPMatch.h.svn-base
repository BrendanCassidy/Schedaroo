#include <vector>
#include <string>
#ifndef BPMatch_H
#define BPMatch_H
using namespace std;

class Edge
{
public:
    int fwd;
	string u;
	string v;
	int w;
	int flow;
	Edge(string x, string y, int z);
	Edge();
	Edge *redge;
	//virtual Edge oedge();
	//~Edge();
};

class FlowNetwork
{
public:
	vector<pair<int, Edge*> > path;
	vector<pair<int, Edge*> > finalPath;
	vector <Edge*> edgeList;
	FlowNetwork(vector<Edge*> & edgeList);
	void addEdge(vector<Edge*> & edgeList, string u, string v, int w);
	void findPath (FlowNetwork* fn, string source, string sink);
	void maxFlow (FlowNetwork* fn, string source, string sink);
	~FlowNetwork();
};
	
#endif
