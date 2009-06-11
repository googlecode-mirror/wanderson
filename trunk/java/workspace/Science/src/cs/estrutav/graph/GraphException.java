package cs.estrutav.graph;

public class GraphException extends Exception {

	private static final long serialVersionUID = 1L;

	public static final String GRAPH_ERROR   = "Graph Error";
	public static final String EDGE_ERROR    = "Edge Error";
	public static final String VERTICE_ERROR = "Vertice Error";
	public static final String CONTENT_ERROR = "Content Error";
	
	public GraphException(String message) {
		super(message);
	}
	
	public GraphException() {
		super(GraphException.GRAPH_ERROR);
	}
}
