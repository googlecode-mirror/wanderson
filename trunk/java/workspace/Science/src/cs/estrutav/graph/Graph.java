package cs.estrutav.graph;

import java.util.*;

/**
 * Graph
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Graph {
	
	/**
	 * Graph Vertices 
	 */
	protected ArrayList<Vertice> vertices;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Constructor
	 * @throws GraphException Internal Error
	 * TODO Change This Javadoc
	 */
	public Graph() throws GraphException {
		this
			.clearVertices();
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Clear all Vertices
	 * @return Self Object
	 * @throws GraphException Internal Error
	 * TODO Change this Javadoc
	 */
	public Graph clearVertices() throws GraphException {
		if(this.getVertices() == null) {
			for(Vertice vertice: this.getVertices())
				vertice.clearEdges();
		}
		else {
			this.vertices = new ArrayList<Vertice>();
		}
		return this;
	}
	
	/**
	 * Add a New Vertice to the Graph
	 * @param content Vertice Content
	 * @return Self Object
	 * @throws GraphException Null Content
	 */
	public Graph addVertice(Content content) throws GraphException {
		Vertice vertice = new Vertice(content);
		this.getVertices().add(vertice);
		return this;
	}
	
	/**
	 * Add a New Vertice to the Graph Linked with Right Vertice
	 * @param content Vertice Content
	 * @param edge    Edge Content
	 * @param link    Edge Link Type
	 * @param right   Link Vertice
	 * @return Self Object
	 * @throws GraphException Vertice Error
	 */
	public Graph addVertice(Content content, Content edge, int link, Vertice right) throws GraphException {
		if(!this.isVertice(right))
			throw new GraphException(GraphException.GRAPH_ERROR);
		boolean found = false;
		int counter = this.getNumberOfVertices();
		int index = 0;
		while(!found && index < counter) {
			found = content.compareTo(this.getVertices().get(index).getContent()) == 0;
		}
		if(found)
			throw new GraphException(GraphException.GRAPH_ERROR);
		Vertice vertice = new Vertice(content);
		vertice.addEdge(right, edge, link);
		this.getVertices().add(vertice);
		return this;
	}
	
	/**
	 * Verify if the Vertice Exists in Graph
	 * @param vertice Search Graph Vertice
	 * @return Found Flag
	 * @throws GraphException Null Vertice
	 */
	public boolean isVertice(Vertice vertice) throws GraphException {
		if(vertice == null)
			throw new GraphException(GraphException.GRAPH_ERROR);
		boolean found = false;
		int counter = this.getNumberOfVertices();
		int index = 0;
		while(!found && index < counter) {
			found = vertice == this.getVertices().get(index);
			index++;
		}
		return found;
	}
	
	/**
	 * Remove a Vertice by Content
	 * @param content Vertice Content
	 * @return Removed Vertice
	 * @throws GraphException Vertice doesn't Exists in the Graph
	 */
	public Vertice removeVertice(Content content) throws GraphException {
		Vertice vertice = null;
		boolean found = false;
		int counter = this.getNumberOfVertices();
		int index = 0;
		while(!found && index < counter) {
			vertice = this.getVertices().get(index);
			found = vertice.getContent().compareTo(content) == 0;
			index++;
		}
		if(!found)
			throw new GraphException(GraphException.GRAPH_ERROR);
		vertice.clearEdges();
		this.getVertices().remove(vertice);
		return vertice;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Returns Graph Vertices
	 * @return Graph Vertices
	 */
	public ArrayList<Vertice> getVertices() {
		return this.vertices;
	}
	
	/**
	 * Returns Vertices Counter
	 * @return Number of Vertices into the Graph
	 */
	public int getNumberOfVertices() {
		return this.getVertices().size();
	}
}
