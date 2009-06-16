package cs.piana.parser;

import cs.piana.*;

/**
 * Piana Parser Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class ParserException extends PianaException {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana Parser Error Message
	 */
	public static final String PARSER_ERROR = "Parser Error";
	
	/**
	 * Complete Constructor
	 * @param message Parser Error Message
	 */
	public ParserException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public ParserException() {
		this(ParserException.PARSER_ERROR);
	}
}
