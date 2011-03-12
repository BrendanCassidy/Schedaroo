#include <iostream>
#include <vector>
#include <map>
#include <utility> // make_pair
using namespace std;

/*
void resizeChar(char arr[], int newSize) {
    char* newArr = new char[newSize];
    memcpy(newArr, arr, newSize);
    delete [] arr;
    arr = newArr;
}


void resizeEdge(Edge arr[], int newSize) {
    Edge* newArr = new Edge[newSize];
    memcpy(newArr, arr, newSize);
    delete [] arr;
    arr = newArr;
}
*/

/*
void FlowNetwork::AddVertex(char vertex)
{
	vertices[nextVerticesIndex]=vertex;
	nextVerticesIndex++;
}
*/
/*
class Redge
{
public:
	Redge(){};
	Redge(char x, char y, int z){u=x; v=y; w=z;};
	Edge redge;
	char u;
	char v;
	int w;
};
*/
class Edge
{
public:
	Edge(){};
	Edge(char x, char y, int z){u=x; v=y; w=z; flow = 0;};
	//Redge redge;
	char u;
	char v;
	int w;
	int flow;
};

class FlowNetwork
{
public:
	map<char, Edge> edgeMap;
	//typedef map<Edge, int> MapType;
	//MapType flowMap;
	//map<Edge, int> flowMap;
	vector<char> vertices;
	vector<Edge> edges;
	int nextEdgesIndex;
	int nextVerticesIndex;
	FlowNetwork(vector<char> vertexList, vector<Edge> edgesList);
	//void AddVertex (char vertex);
	void addEdges (vector<Edge> edgeList);
	vector<Edge> findPath (Edge source, Edge sink, vector<Edge> path);
	void maxFlow (Edge source, Edge sink);
};

FlowNetwork::FlowNetwork(vector<char> vertexList, vector<Edge> edgesList)
{
	nextEdgesIndex = 0; 
	nextVerticesIndex = 0;
	FlowNetwork::vertices = vertexList;
	FlowNetwork::edges = edgesList;
	FlowNetwork::addEdges(edges);
}

void FlowNetwork::addEdges(vector<Edge> edgesList)
{
	int i = 0;
	char zero = 'a';
	int edgeListSize = edgesList.size();
	for (i; i < edgeListSize; i++)
	{
		Edge curEdge = edgesList.at(i);
		//Redge curEdge.redge = new Redge(curEdge.v, curEdge.u, 0);
		//curEdge.redge.redge = curEdge;
		FlowNetwork::edgeMap.insert(pair<char, Edge>(curEdge.u, curEdge));
		//FlowNetwork.edgeMap.insert(pair<char, Redge>(curEdge.v, e));
		//FlowNetwork::flowMap.insert(pair<Edge, int>(curEdge, 0));
		//FlowNetwork.flowMap.insert(pair<Edge, int>(curEdge.redge, 0));
	}
}

vector<Edge> FlowNetwork::findPath(Edge source, Edge sink, vector<Edge> path)
{
	if (&source == &sink)
	{
		return path;
	}
	typedef map<char, Edge> MapType;
	MapType::const_iterator end = FlowNetwork::edgeMap.end();
	vector<pair<char, Edge>> sourceEdgesList;
	for (MapType::const_iterator iter = FlowNetwork::edgeMap.begin(); iter != end; ++iter)
	{
		if (iter->first == source.u)
		{
			sourceEdgesList.push_back(pair<char, Edge>(iter->first, iter->second));
		}
	}
	int i = 0;
	int sourceEdgesListSize = sourceEdgesList.size();
	for (i; i < sourceEdgesListSize; i++)
	{
	}
		//if (iter->first != source.u)
		//{
		//int i;
		//cout << "first" << iter->first << endl;
		//cout << "type something: ";
		//cin >> i;
		
		//int residual = iter->second.w - iter->second.flow;
		//if (residual > 0 && (FlowNetwork::edgeMap(iter->first) !=
		
		//source.u == sink.u && source.v 
}

int main()
{
	int i;	
	cout << "Hello World!" << endl;   
	cout << "Welcome to C++ Programming" << endl;
    vector<char> vectorList(3);
    vectorList.at(0) = 'a';
    vectorList.at(1) = 'b';
    vectorList.at(2) = 'c';
	vector<Edge> edgesList(3);
    edgesList.at(0) = Edge('a', 'd', 2);
    edgesList.at(1) = Edge('b', 'e', 2);
    edgesList.at(2) = Edge('c', 'f', 2);
    FlowNetwork flownet (vectorList, edgesList);
    cout << flownet.vertices.at(1) << endl;
	cout << flownet.edges.at(1).v << endl;
	cout << flownet.edgeMap['a'].v << endl;
	vector<Edge> path;
	vector<Edge> path2 = flownet.findPath(edgesList[1], edgesList[1], path);
	cout << "Press Enter to End";
	cin >> i;
	return 0;
}