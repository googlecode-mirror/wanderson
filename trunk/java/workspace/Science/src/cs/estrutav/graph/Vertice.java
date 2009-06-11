package cs.estrutav.graph;

import java.util.*;

/**
 * Graph Vertice
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Vertice {
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Vertice Content
	 */
	protected Content content;
	
	/**
	 * Vertice Edges
	 */
	protected ArrayList<Edge> edges;
	
	/*
	 * Construtors
	 */
	
	/**
	 * Complete Constructor
	 * @param content Vertice Content
	 * @throws GraphException Null Content Pointer
	 */
	public Vertice(Content content) throws GraphException {
		this
			.setContent(content)
			.clearEdges();
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Unlink All Vertice Edges
	 * @return Self Object
	 * @throws GraphException Null Vertice Pointer
	 */
	public Vertice clearEdges() throws GraphException {
		if(this.getEdges() != null) {
			Vertice vertice = null;
			for(Edge edge : this.getEdges()) {
				vertice = edge.getPointer(this);
				this.removePointer(vertice);
			}
		}
		else {
			this.edges = new ArrayList<Edge>();
		}
		return this;
	}
	
	/**
	 * Verify if the Vertice is Linked
	 * @param vertice Search Linked Vertice
	 * @return Found Flag
	 * @throws GraphException Null Vertice Pointer
	 */
	public boolean isPointer(Vertice vertice) throws GraphException {
		if(vertice == null)
			throw new GraphException(GraphException.VERTICE_ERROR);
		boolean found = false;
		int counter = this.getNumberOfEdges();
		int index = 0;
		while(!found && index < counter) {
			found = vertice == this.getEdges().get(index).getPointer(this);
			index++;
		}
		return found;
	}
	
	/**
	 * Link This Left Vertice with Right Link Vertice
	 * @param right Right Link Vertice
	 * @param content Edge Content
	 * @param link Edge Link Type
	 * @return Self Object
	 * @throws GraphException Right Vertice is already Linked
	 */
	public Vertice addEdge(Vertice right, Content content, int link) throws GraphException {
		if(this.isPointer(right))
			throw new GraphException(GraphException.VERTICE_ERROR);
		Edge edge = new Edge(this, right, content, link);
		this.getEdges().add(edge);
		right.getEdges().add(edge);
		return this;
	}
	
	/**
	 * Unlink This Vertice with Other Vertice
	 * @param pointer Vertice Linked
	 * @return Edge Linker
	 * @throws GraphException Vertice Pointer is not Linked
	 */
	public Edge removePointer(Vertice pointer) throws GraphException {
		if(pointer == null)
			throw new GraphException(GraphException.VERTICE_ERROR);
		Edge search = null;
		boolean found = false;
		int counter = this.getNumberOfEdges();
		int index = 0;
		while(!found && index < counter) {
			search = this.getEdges().get(index);
			found = pointer == search.getPointer(this);
			index++;
		}
		if(!found)
			throw new GraphException(GraphException.VERTICE_ERROR);
		this.getEdges().remove(search);
		search.getPointer(this).getEdges().remove(search);
		return search;
	}
	
	/**
	 * Visit a Vertice Pointer through an Edge
	 * @param pointer Vertice Pointer
	 * @return Path to Visit Vertice Pointer
	 * @throws GraphException Wrong Vertice Pointer
	 */
	public Edge visit(Vertice pointer) throws GraphException {
		if(pointer == null)
			throw new GraphException(GraphException.VERTICE_ERROR);
		Edge path = null;
		Vertice search = null;
		boolean found = false;
		int counter = this.getNumberOfEdges();
		int index = 0;
		while(!found && index < counter) {
			path = this.getEdges().get(index);
			search = path.getPointer(this);
			found = pointer == search;
			index++;
		}
		if(!found)
			throw new GraphException(GraphException.VERTICE_ERROR);
		return path;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configures Vertice Content
	 * @param content Vertice Content
	 * @return Self Object
	 * @throws GraphException Null Content Pointer
	 */
	public Vertice setContent(Content content) throws GraphException {
		if(content == null)
			throw new GraphException(GraphException.VERTICE_ERROR);
		this.content = content;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Returns Vertice Edges
	 * @return Vertice Edges
	 */
	public ArrayList<Edge> getEdges() {
		return this.edges;
	}
	
	/**
	 * Returns Edges Counter
	 * @return Number of Edges Linked to the Vertice
	 */
	public int getNumberOfEdges() {
		return this.getEdges().size();
	}
	
	/**
	 * Returns Vertice Content
	 * @return Vertice Content
	 */
	public Content getContent() {
		return this.content;
	}
	
}