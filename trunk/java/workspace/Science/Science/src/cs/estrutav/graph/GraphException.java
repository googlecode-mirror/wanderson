package cs.estrutav.graph;

/**
 * Graph Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class GraphException extends Exception {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Graph Error Message
	 */
	public static final String GRAPH_ERROR   = "Graph Error";
	
	/**
	 * Edge Error Message
	 */
	public static final String EDGE_ERROR    = "Edge Error";
	
	/**
	 * Vertice Error Message
	 */
	public static final String VERTICE_ERROR = "Vertice Error";
	
	/**
	 * Content Error Message 
	 */
	public static final String CONTENT_ERROR = "Content Error";
	
	/**
	 * Complete Constructor
	 * @param message Message Exception
	 */
	public GraphException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor 
	 */
	public GraphException() {
		super(GraphException.GRAPH_ERROR);
	}
}
