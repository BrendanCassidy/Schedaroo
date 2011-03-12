#include <iostream>
#include <vector>
#include <algorithm>
#include <utility> // make_pair
using namespace std;

class Edge
{
public:
	Edge(){};
	Edge(char x, char y, int z){u=x; v=y; w=z; flow = 0;};
	char u;
	char v;
	int w;
	int flow;
};

class FlowNetwork
{
public:
	vector<char> vertices;
	vector<Edge> edges;
	FlowNetwork(vector<char> vertexList, vector<Edge> edgesList);
	vector<pair<int, Edge>> findPath (char * source, char * sink, vector<pair<int,Edge>> path, vector<pair<int,Edge>> newPath);
	vector<pair<int, Edge>> maxFlow (char * source, char * sink);
};

FlowNetwork::FlowNetwork(vector<char> vertexList, vector<Edge> edgesList)
{
	FlowNetwork::vertices = vertexList;
	FlowNetwork::edges = edgesList;
}

vector<pair<int, Edge>> FlowNetwork::findPath(char * source, char * sink, vector<pair<int, Edge>> path, vector<pair<int, Edge>> newPath)
{
	if (*source == *sink)
	{
		return newPath;
	}
	vector<pair<int, Edge>> result;
	//vector<Edge> sourceEdgesList;
	for (vector<Edge>::iterator iter = FlowNetwork::edges.begin(); iter != FlowNetwork::edges.end(); ++iter)
	{
		if (iter->u == *source)
		{
			//sourceEdgesList.push_back(*iter);
			int residual = iter->w - iter->flow;
			//cout << "residual: " << residual << endl;
			int match = 0;
			for (vector<pair<int, Edge>>::iterator i = path.begin(); i != path.end(); ++i)
			{
				if (i->second.u == iter->u && i->second.v == iter->v && residual == i->first)
				{
					//cout << "match found" << endl;
					match++;
				}
			}
			if (residual > 0 && !match)
			{
				pair<int, Edge> p = make_pair(residual, *iter);
				newPath.push_back(p);
				result = FlowNetwork::findPath(&iter->v, sink, path, newPath);
				if (result.at(0).first)
				{
					return result;	
				}
				else
				{
					newPath.pop_back();
				}
			}
		}
	}
	char y = 'y';
	char z = 'z';
	int zero = 0;
	Edge fakeEdge = Edge(y, z, zero);
	pair<int, Edge> fakePair = make_pair(zero, fakeEdge);
	result.clear();
	result.push_back(fakePair);
	return result;
}

vector<pair<int, Edge>> FlowNetwork::maxFlow(char * source, char * sink)
{
	vector<pair<int, Edge>> path;
	vector<pair<int, Edge>> finalPath;
	int flow;
	vector<int> weights;
	while (1)
	{
		path.clear();
		weights.clear();
		path = FlowNetwork::findPath(source, sink, finalPath, path);
		if (!path.at(0).first)
		{
			return finalPath;
		}
		for (vector<pair<int, Edge>>::iterator i = path.begin(); i != path.end(); ++i)
		{
			weights.push_back(i->first);
		}
		flow = *(min_element(weights.begin(), weights.end()));
		for (vector<pair<int, Edge>>::iterator i = path.begin(); i != path.end(); ++i)
		{
			i->second.flow += flow;
			//cout << "FLOW" << i->second.flow << endl;
			finalPath.push_back(*i);
		}
	}
}

int main()
{
	pair <char, int> p ('a',0);
	int i;
	cout << "Hello World!" << endl;   
	cout << "Welcome to C++ Programming" << endl;
    vector<char> vectorList(4);
    vectorList.at(0) = 'a';
    vectorList.at(1) = 'b';
    vectorList.at(2) = 'c';
	vectorList.at(3) = 'd';
	vector<Edge> edgesList(8);
    edgesList.at(0) = Edge('a', 'b', 2);
	edgesList.at(1) = Edge('a', 'c', 2);
    edgesList.at(2) = Edge('b', 'd', 2);
	edgesList.at(3) = Edge('c', 'f', 2);
	edgesList.at(4) = Edge('f', 'e', 2);
    edgesList.at(5) = Edge('c', 'e', 2);
	edgesList.at(6) = Edge('a', 'e', 2);
	edgesList.at(7) = Edge('d', 'e', 2);
    FlowNetwork flownet (vectorList, edgesList);
	vector<pair<int, Edge>> path;
	/* vector<pair<int, Edge>> path2 = flownet.findPath(&edgesList.at(0).u, &edgesList.at(7).v, path);
	 * cout << "first edge in path" << path2.begin()->second.u << path2.begin()->second.v << endl;
	 * cout << "last edge in path" << path2.at(1).second.u << path2.at(1).second.v << endl;
	 * path.clear();
	 */
	path = flownet.maxFlow(&edgesList.at(0).u, &edgesList.at(7).v);
	for (i=0; i < path.size(); i++)
	{
		cout << path.at(i).second.u << ", " << path.at(i).second.v << ", " << path.at(i).second.flow << endl;
	}
	cout << "Press Enter to End";
	cin >> i;
	path.clear();
	//path2.clear();
	return 0;
}
