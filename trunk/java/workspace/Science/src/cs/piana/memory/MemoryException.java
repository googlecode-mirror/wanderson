package cs.piana.memory;

import cs.piana.*;

/**
 * Piana Memory Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class MemoryException extends PianaException {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana Memory Error Message
	 */
	public static final String MEMORY_ERROR = "Memory Error";

	/**
	 * Complete Constructor
	 * @param message Memory Error Message
	 */
	public MemoryException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public MemoryException() {
		this(MemoryException.MEMORY_ERROR);
	}
}
