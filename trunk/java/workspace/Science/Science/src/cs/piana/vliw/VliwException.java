package cs.piana.vliw;

import cs.piana.*;

/**
 * Piana VLIW Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class VliwException extends PianaException {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana VLIW Error Message
	 */
	public static final String VLIW_ERROR = "VLIW Error";
	
	/**
	 * Complete Constructor
	 * @param message Exception Message
	 */
	public VliwException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public VliwException() {
		this(VliwException.VLIW_ERROR);
	}
	
}
