#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <string>
#include <vector>
#include "BPMatch.h"
#include <string>
#include "FileParser.h"


using namespace std;

void AddSourceSinkEdges(FlowNetwork* fn)
{
	int i;
	int j;
	int k;
	int matchSource;
	int matchSink;
	string source ("source");
	string sink ("sink");
	vector<Edge*> newEdges;
	for (i = 0; i < fn->edgeList.size(); i++)
	{
	    //cout << "i: " << i << endl;
		matchSource = 0;
		matchSink = 0;
	    if (fn->edgeList.at(i)->fwd)
	    {
		    for (j = 0; j < newEdges.size(); j++)
		    {
			    //cout << "j: " << j << endl;
			    if (newEdges.at(j)->v.compare(fn->edgeList.at(i)->u) == 0)
			    {
				    matchSource = 1;
			    }
			    if (newEdges.at(j)->u.compare(fn->edgeList.at(i)->v) == 0)
			    {
				    matchSink = 1;
			    }
		    }
		}
		if (matchSource == 0)
		{
			fn->addEdge(newEdges, source, fn->edgeList.at(i)->u, 2);
			//newEdges.push_back(&Fedge(source, fn.edgeList.at(i).u, 2));
			//newEdges.push_back(&Redge(fn.edgeList.at(i).u, source, 0));
		}
		if (matchSink == 0)
		{
			fn->addEdge(newEdges, fn->edgeList.at(i)->v, sink, 2);
			//newEdges.push_back(&Fedge(fn.edgeList.at(i).v, sink, 2));
			//newEdges.push_back(&Redge(sink, fn.edgeList.at(i).v, 0));
		}
	}
	for (k = 0; k < newEdges.size(); k++)
	{
		fn->edgeList.push_back(newEdges.at(k));
	}
	//return fn->edgeList;
}

void FileParser(FlowNetwork* fn, char * s) {
	//cout << "beginning fileParser" << endl;
	//FILE * stream;
    char * mystring;
	string user;
	string resource;
	//vector<Edge> finalEdgeList;
	mystring = strtok (s, "\\n\\t");
	while (mystring != NULL)
	{
		//cout << "user obtainted" << endl;
		//cout << "user: " << mystring << " :user" << endl;
		user = mystring;
		//cout << "user assigned" << endl;
		mystring = strtok(NULL, "\\n\\t");
		//cout << "resource obtained" << endl;
		//cout << "resource: " << mystring << " :resource" << endl;
		resource = mystring;
		//cout << "adding edge" << endl;
		fn->addEdge(fn->edgeList, user, resource, 2);
		//edgeList.push_back(Fedge(user, resource, 2));
		//edgeList.push_back(Redge(resource, user, 0));
		//cout << "edge added" << endl;
		mystring = strtok(NULL, "\\n\\t");
		//cout << "end of loop" << endl;
	}
	/*
	//pFile = fopen("C:/test.txt", "r");
	stream = stdin;
	if (stream == NULL){
		edgeList.clear();
		return edgeList;
	}
	else {
		cout << "fgets" << endl;
		while (fgets (mystring , 100 , stream)) {
			cout << mystring;
			//cout << "Line: " << mystring << endl;
			user = strtok(mystring, " \n");
			resource = strtok(NULL, " \n");
			//cout << "User: " << user << endl;
			//cout << "Resource: " << resource << endl;
			edgeList.push_back(Edge(user, resource, 2));
		}
	}
	*/
	//cout << "adding source sink edges" << endl;
	AddSourceSinkEdges(fn);
	//cout << "added source sink edges" << endl;
	//fclose(stream);
	//return fn->edgeList;
}
