package cs.piana;

/**
 * Piana Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class PianaException extends Exception {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana Error Message
	 */
	public static final String PIANA_ERROR    = "Piana Error"; 
	
	/**
	 * Complete Constructor
	 * @param message Exception Message
	 */
	public PianaException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public PianaException() {
		this(PianaException.PIANA_ERROR);
	}
	
}
