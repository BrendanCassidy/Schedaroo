#include <iostream>
#include <vector>
#include <algorithm>
#include <string>
#include <utility> // make_pair
#include <stdio.h>
#include <stdlib.h>
#include <sstream>
#include "FileParser.h"
#include "BPMatch.h"
using namespace std;

Edge::Edge(string x, string y, int z)
{
    fwd = -1;
	u=x; 
	v=y; 
	w=z; 
	flow = 0;
}

Edge::Edge(){}
//Edge::~Edge(){}

string IntToString(int i)
{
	string s;
	stringstream out;
	out << i;
	s = out.str();
	return s;
}

FlowNetwork::FlowNetwork(vector<Edge*> & edgeList)
{
	FlowNetwork::edgeList = edgeList;
}

FlowNetwork::~FlowNetwork()
{
	for (vector<Edge*>::iterator iter = edgeList.begin(); iter != edgeList.end(); ++iter)
	{
		//cout << "garbage collecting edge" << endl;
		delete (*iter);
	}
}

void FlowNetwork::addEdge(vector<Edge*> & edgeList, string u, string v, int w)
{
	Edge* fedge = new Edge(u, v, w);
	Edge* redge = new Edge(v, u, 0);
	fedge->redge = redge;
	redge->redge = fedge;
	edgeList.push_back(fedge);
	edgeList.push_back(redge);
}

void FlowNetwork::findPath(FlowNetwork* fn, string source, string sink)
{
	string s;
	//printf("Source: %s\n", source.c_str());
	//printf("Sink: %s\n", sink.c_str());
	//printf("Comparing Source and Sink: %d\n", source.compare(sink));
	if (source.compare(sink) == 0)
	{
		//cout << "returning newPath" << endl;
		return;
		//return newPath;
	}
	//cout << "beginning findPath recursions" << endl;
	for (vector<Edge*>::iterator iter = fn->edgeList.begin(); iter != fn->edgeList.end(); ++iter)
	{
		//printf("Source: %s\n", source.c_str());
		//printf("Iter->u: %s\n", (*iter)->u.c_str());
		//printf("Comparing Source and iter->u: %d\n", source.compare((*iter)->u));
		if (source.compare((*iter)->u) == 0)
		{
			int residual = (*iter)->w - (*iter)->flow;
			int match = 0;
			for (vector<pair<int, Edge*> >::iterator i = fn->path.begin(); i != fn->path.end(); ++i)
			{
				//cout << "(*iter)->u: " << (*iter)->u << endl << "i->second->u: " << i->second->u << endl;
				//cout << "u_cmp: " << (i->second->u.compare((*iter)->u)) << endl;
				//cout << "(*iter)->v: " << (*iter)->v << endl << "i->second->v: " << i->second->v << endl;
				//cout << "v_cmp: " << (i->second->v.compare((*iter)->v)) << endl;
				//cout << "residual: " << residual << endl << "i->first: " << i->first << endl;
				if ((i->second->u.compare((*iter)->u) == 0) && (i->second->v.compare((*iter)->v) == 0) && residual == i->first)
				{
					match++;
				}
			}
			//cout << "match: " << match << endl;
			//cout << "residual: " << residual << endl;
			if (residual > 0 && !match)
			{
				pair<int, Edge*> p = make_pair(residual, (*iter));
				fn->path.push_back(p);
				//cout << "Recursing on findPath" << endl;
				fn->findPath(fn, (*iter)->v, sink);
				//cout << "Done recursing on findPath" << endl;
				//cout << fn->path.end()->first << endl;
				if (fn->path.at(fn->path.size()-1).first)
				{
					return;
				}
				else
				{
					fn->path.pop_back();
					fn->path.pop_back();
				}
			}
		}
	}
	//cout << "ending findPath without a path" << endl;
	string y ("stringy");
	string z ("stringz");
	int zero = 0;
	Edge *fakeEdge = new Edge(y, z, zero);
	pair<int, Edge*> fakePair = make_pair(zero, fakeEdge);
	//fn->path.clear();
	fn->path.push_back(fakePair);
}

void FlowNetwork::maxFlow(FlowNetwork* fn, string source, string sink)
{
	int flow;
	vector<int> weights;
	//cout << "calling find path" << endl;
	fn->findPath(fn, source, sink);
	//cout << "Path found" << endl;
	while (1)
	{
		if (!fn->path.at(0).first)
		{
			//cout << "Returning finalPath" << endl;
			return;
		}
		for (vector<pair<int, Edge*> >::iterator i = fn->path.begin(); i != fn->path.end(); ++i)
		{
			weights.push_back(i->first);
		}
		flow = *(min_element(weights.begin(), weights.end()));
		//cout << "Altering Flow Values" << endl;
		for (vector<pair<int, Edge*> >::iterator iter = fn->path.begin(); iter != fn->path.end(); ++iter)
		{
			iter->second->flow += flow;
			iter->second->redge->flow -= flow;
			//cout << "Flow from " << iter->second->u << " to " << iter->second->v << " = " << iter->second->flow << endl;
			//cout << "Flow from " << iter->second->v << " to " << iter->second->u << " = " << iter->second->redge->flow << endl;
			fn->finalPath.push_back((*iter));
		}
		//cout << "calling find path" << endl;
		fn->path.clear();
		weights.clear();
		fn->findPath(fn, source, sink);
		//cout << "Path found" << endl;
		//cout << "beginning new loop" << endl;
	}
	//cout << "ending loop" << endl;
	return;
}

/*
int main()
{
	int i;
	int j;
	vector<Edge> edgesList (11);
	
	edgesList.at(0) = Edge(string("WES"), string("1:30"), 2);
	edgesList.at(1) = Edge(string("NATE"), string("1:30"), 2);
    edgesList.at(2) = Edge(string("NATE"), string("3:30"), 2);
	edgesList.at(3) = Edge(string("NATE"), string("5:30"), 2);
	edgesList.at(4) = Edge(string("CARL"), string("3:30"), 2);
	edgesList.at(5) = Edge(string("source"), string("WES"), 2);
	edgesList.at(6) = Edge(string("1:30"), string("sink"), 2);
	edgesList.at(7) = Edge(string("source"), string("NATE"), 2);
	edgesList.at(8) = Edge(string("3:30"), string("sink"), 2);
	edgesList.at(9) = Edge(string("5:30"), string("sink"), 2);
    edgesList.at(10) = Edge(string("source"), string("CARL"), 2);


	for (j=0; j < edgesList.size(); j++)
	{
		cout << "u: " << edgesList.at(j).u << endl;
		cout << "v: " << edgesList.at(j).v << endl;
		cout << "weight: " << edgesList.at(j).w << endl;
	}
    FlowNetwork flownet (edgesList);
	vector<pair<int, Edge> > path;
	path = flownet.maxFlow(string("source"), string("sink"));

	for (i=0; i < path.size(); i++)
	{
		cout << path.at(i).second.u << ", " << path.at(i).second.v << ", " << path.at(i).second.flow << endl;
	}
	cout << "Enter Something to End";
	cin >> i;
	path.clear();
	//path2.clear();
	return 0;
}
*/

int main(int argc, char * argv[])
{
	int i;
	int j;
	vector<Edge*> edgesList;
	FlowNetwork* flownet = new FlowNetwork(edgesList);
	char input [strlen(argv[1])+1];
    strcpy(input,argv[1]);
    
	//cout << "calling fileParser" << endl;
	FileParser(flownet, input);
	//cout << "done calling fileParser" << endl;
	if (flownet->edgeList.size() == 0)
	{
		//cout << "void working improperly" << endl;
		return 1;
	}

	//for (j=0; j < edgesList.size(); j++)
	//{
	//	cout << "u: " << edgesList.at(j).u << endl;
	//	cout << "v: " << edgesList.at(j).v << endl;
	//	cout << "weight: " << edgesList.at(j).w << endl;
	//}

	//cout << edgesList.size() << endl;
	if (flownet->edgeList.size() > 0)
	{
		vector<pair<int, Edge*> > *path;
		//cout << "Calling Max Flow" << endl;
		flownet->maxFlow(flownet, string("source"), string("sink"));
		//cout << "Max Flow Complete" << endl;
		for (j=0; j < flownet->finalPath.size(); j++) //erase source and sink edges
		{
			if (flownet->finalPath.at(j).second->u.compare(string("source")) == 0)
			{
				flownet->finalPath.erase(flownet->finalPath.begin()+j);
				j--;
			}
			else if (flownet->finalPath.at(j).second->v.compare(string("source")) == 0)
			{
				flownet->finalPath.erase(flownet->finalPath.begin()+j);
				j--;
			}
			else if (flownet->finalPath.at(j).second->v.compare(string("sink")) == 0)
			{
				flownet->finalPath.erase(flownet->finalPath.begin()+j);
				j--;
			}
			else if (flownet->finalPath.at(j).second->u.compare(string("sink")) == 0)
			{
				flownet->finalPath.erase(flownet->finalPath.begin()+j);
				j--;
			}
		}
		for (vector<pair<int, Edge*> >::iterator iter = flownet->finalPath.begin(); iter != flownet->finalPath.end(); ++iter) // erase edges that have been 'repealed'
		{
			for (vector<pair<int, Edge*> >::iterator i = (iter + 1); i != flownet->finalPath.end(); ++i)
			{
				//cout << "iter->second->u: " << iter->second->u << endl;
				//cout << "iter->second->v: " << iter->second->v << endl;
				//cout << "i->second->u: " << i->second->u << endl;
				//cout << "i->second->v: " << i->second->v << endl;
				if ((i->second->u.compare(iter->second->v) == 0) && (i->second->u.compare(iter->second->v) == 0))
				{
					flownet->finalPath.erase(i, i+1);
					flownet->finalPath.erase(iter, iter+1);
					i--;
					iter--;
					break;
				}
			}
		}
		for (i=0; i < flownet->finalPath.size(); i++)
		{
			cout << flownet->finalPath.at(i).second->u << " " << flownet->finalPath.at(i).second->v << endl;
		}
	}
	//cout << "Enter Something to End" << endl;
	//cin >> i;
	delete flownet;
	return 0;
}
