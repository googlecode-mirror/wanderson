package cs.complex.floydwarshall;

/**
 * Floyd-Warshall Algorithm Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class FloydWarshallException extends Exception {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Floyd-Warshall Error Message
	 */
	public static final String FLOYDWARSHALL_ERROR   = "Floyd-Warshall Error";
	
	/**
	 * Complete Constructor
	 * @param message Message Exception
	 */
	public FloydWarshallException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor 
	 */
	public FloydWarshallException() {
		super(FloydWarshallException.FLOYDWARSHALL_ERROR);
	}
}
