package cs.estrutav.graph;

import java.util.*;

public class Graph {
	protected ArrayList<Vertice> vertices;
	
	/*
	 * Constructors
	 */
	
	public Graph() {
		this
			.clearVertices();
	}
	
	/*
	 * Methods
	 */
	
	public Graph link(Content from, Content to, Content value) throws GraphException {
		Vertice vfrom = this.getVertice(from);
		Vertice vto   = this.getVertice(to);
		vfrom.addEdge(vto, value);
		return this;
	}
	
	public Edge unlink(Content from, Content to, Content value) throws GraphException {
		Vertice vfrom = this.getVertice(from);
		Edge edge = vfrom.removeEdge(value);
		return edge;
	}
	
	public Graph addVertice(Vertice vertice) throws GraphException {
		if(this.isVertice(vertice.getContent()))
			throw new GraphException(GraphException.GRAPH_ERROR);
		this.getVertices().add(vertice);
		return this;
	}
	
	public Graph addVertices(Vertice[] vertices) throws GraphException {
		for(Vertice vertice : vertices)
			this.addVertice(vertice);
		return this;
	}
	
	public Graph addVertice(Content content) throws GraphException {
		this.addVertice(new Vertice(content));
		return this;
	}
	
	public boolean isVertice(Content content) throws GraphException {
		return this.getIndex(content) != -1;
	}
	
	public Vertice removeVertice(Content content) throws GraphException {
		Vertice vertice = this.getVertice(content);
		this.getVertices().remove(vertice);
		return vertice;
	}
	
	public Graph clearVertices() {
		this.vertices = new ArrayList<Vertice>();
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Vertice getVertice(int index) throws GraphException {
		try {
			return this.getVertices().get(index);
		}
		catch(IndexOutOfBoundsException e) {
			throw new GraphException(GraphException.GRAPH_ERROR);
		}
	}
	
	public Vertice getVertice(Content content) throws GraphException {
		int index = this.getIndex(content);
		if(index == -1)
			throw new GraphException(GraphException.GRAPH_ERROR);
		return this.getVertice(index);
	}
	
	public ArrayList<Vertice> getVertices() {
		return this.vertices;
	}
	
	public int getIndex(Content content) throws GraphException {
		Vertice vertice = null;
		boolean found = false;
		int size = this.getNumberOfVertices();
		int index = 0;
		while(!found && index < size) {
			vertice = this.getVertice(index);
			found = vertice.getContent().compareTo(content) == 0;
			index++;
		}
		index = index - 1;
		return found ? index : -1;
	}
	
	public int getNumberOfVertices() {
		return this.getVertices().size();
	}
	
	public int getNumberOfEdges() {
		int counter = 0;
		for(Vertice vertice : this.getVertices())
			counter += vertice.getNumberOfEdges();
		return counter;
	}
}
