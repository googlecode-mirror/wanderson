package cs.estrutav.graph;

import java.util.*;

public class Vertice {
	protected Content content;
	protected ArrayList<Edge> edges;
	
	/*
	 * Constructors
	 */
	
	public Vertice(Content content) {
		this
			.setContent(content)
			.clearEdges();
	}
	
	/*
	 * Methods
	 */
	
	public Vertice addEdge(Edge edge) throws GraphException {
		if(this.isEdge(edge.getContent()))
			throw new GraphException(GraphException.VERTICE_ERROR);
		this.getEdges().add(edge);
		return this;
	}
	
	public Vertice addEdges(Edge[] edges) throws GraphException {
		for(Edge edge : edges)
			this.addEdge(edge);
		return this;
	}
	
	public Vertice addEdge(Vertice pointer, Content content) throws GraphException {
		this.addEdge(new Edge(pointer, content));
		return this;
	}
	
	public Vertice addEdge(Content content) throws GraphException {
		this.addEdge(new Edge(content));
		return this;
	}
	
	public boolean isEdge(Content content) throws GraphException {
		return this.getIndex(content) != -1;
	}
	
	public Edge removeEdge(Content content) throws GraphException {
		Edge edge = this.getEdge(content);
		this.getEdges().remove(edge);
		return edge;
	}
	
	public Vertice clearEdges() {
		this.edges = new ArrayList<Edge>();
		return this;
	}
	
	/*
	 * Setters
	 */
	
	public Vertice setContent(Content content) {
		this.content = content;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Edge getEdge(int index) throws GraphException {
		try {
			return this.getEdges().get(index);
		}
		catch(IndexOutOfBoundsException e) {
			throw new GraphException(GraphException.VERTICE_ERROR);
		}
	}
	
	public Edge getEdge(Content content) throws GraphException {
		int index = this.getIndex(content);
		if(index == -1)
			throw new GraphException(GraphException.VERTICE_ERROR);
		return this.getEdge(index);
	}

	public int getIndex(Content content) throws GraphException {
		Edge edge = null;
		boolean found = false;
		int size = this.getNumberOfEdges();
		int index = 0;
		while(!found && index < size) {
			edge = this.getEdge(index);
			found = edge.getContent().compareTo(content) == 0;
			index++;
		}
		index = index - 1;
		return found ? index : -1;
	}
	
	public ArrayList<Edge> getEdges() {
		return this.edges;
	}
	
	public Content getContent() {
		return this.content;
	}
	
	public int getNumberOfEdges() {
		return this.getEdges().size();
	}
}
