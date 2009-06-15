package cs.piana.bench;

import cs.piana.*;

/**
 * Piana Bench Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class BenchException extends PianaException {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana Bench Exception
	 */
	public static final String BENCH_ERROR = "Bench Error";
	
	/**
	 * Piana Bench Register Error
	 */
	public static final String REGISTER_ERROR = "Register Error";
	
	/**
	 * Complete Constructor
	 * @param message Exception Message
	 */
	public BenchException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public BenchException() {
		this(BenchException.BENCH_ERROR);
	}
	
}
