package cs.piana.memory;

/**
 * Piana Memory Instruction Exception
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class InstructionException extends MemoryException {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * Piana Memory Error Message
	 */
	public static final String INSTRUCTION_ERROR = "Instruction Error";

	/**
	 * Complete Constructor
	 * @param message Memory Instruction Error Message
	 */
	public InstructionException(String message) {
		super(message);
	}
	
	/**
	 * Fast Constructor
	 */
	public InstructionException() {
		this(InstructionException.INSTRUCTION_ERROR);
	}
}
