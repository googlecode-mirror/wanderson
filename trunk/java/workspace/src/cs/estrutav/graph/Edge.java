package cs.estrutav.graph;

public class Edge {
	protected Vertice pointer;
	protected Content content;
	
	/*
	 * Constructors
	 */
	
	public Edge(Vertice pointer, Content content) throws GraphException {
		this
			.setPointer(pointer)
			.setContent(content);
	}
	
	public Edge(Content content) throws GraphException {
		this(null, content);
	}
	
	/*
	 * Setters
	 */
	
	public Edge setPointer(Vertice pointer) throws GraphException {
		this.pointer = pointer;
		return this;
	}
	
	public Edge setContent(Content content) throws GraphException {
		this.content = content;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Vertice getPointer() {
		return this.pointer;
	}
	
	public Content getContent() {
		return this.content;
	}
}
