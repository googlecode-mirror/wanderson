package cs.piana.memory;

/**
 * Piana Memory Instruction Block
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Instruction extends Block {
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Time to Live
	 */
	private int ttl;
	
	/**
	 * Out Register
	 */
	private String out;
	
	/**
	 * In Register
	 */
	private String in1;
	
	/**
	 * In Register
	 */
	private String in2;
	
	/**
	 * Instruction Name
	 */
	private String name;
	
	/**
	 * Complete Constructor
	 * @param out Out Register
	 * @param in1 First Attribute
	 * @param in2 Second Attribute
	 */
	public Instruction(String out, String in1, String in2) {
		this
			.setOut(out)
			.setIn1(in1)
			.setIn2(in2);
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Count Down the Time to Live
	 * @return Self Object
	 */
	public Instruction countDown() {
		if(this.ttl > 0)
			this.ttl -= 1;
		return this;
	}
	
	/**
	 * Kill the Instruction
	 * @return Self Object
	 */
	public Instruction kill() {
		this.ttl = 0;
		return this;
	}
	
	/**
	 * TTL Verification
	 * @return Boolean Flag
	 */
	public boolean isDead() {
		return this.ttl == 0;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configure Time to Live
	 * @param ttl Time to Live
	 * @return Self Object
	 * @throws InstructionException Wrong TTL
	 */
	public Instruction setTtl(int ttl) throws InstructionException {
		if(ttl < 0)
			throw new InstructionException(InstructionException.INSTRUCTION_ERROR);
		this.ttl = ttl;
		return this;
	}
	
	/**
	 * Configure Out Register
	 * @param out Out Register
	 * @return Self Object
	 */
	public Instruction setOut(String out) {
		this.out = out;
		return this;
	}
	
	/**
	 * Configure First Attribute
	 * @param in1 First Attribute
	 * @return Self Object
	 */
	public Instruction setIn1(String in1) {
		this.in1 = in1;
		return this;
	}
	
	/**
	 * Configure Second Attribute
	 * @param in2 Second Attribute
	 * @return Self Object
	 */
	public Instruction setIn2(String in2) {
		this.in2 = in2;
		return this;
	}
	
	/**
	 * Configure Instruction Name
	 * @param name Instruction Name
	 * @return Self Object
	 * TODO Create best class
	 */
	public Instruction setName(String name) {
		this.name = name;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Time to Live
	 * @return Time to Live
	 */
	public int getTtl() {
		return this.ttl;
	}
	
	/**
	 * Return Out Register
	 * @return Out Register
	 */
	public String getOut() {
		return this.out;
	}
	
	/**
	 * Return First Attribute
	 * @return First Attribute
	 */
	public String getIn1() {
		return this.in1;
	}
	
	/**
	 * Return Second Attribute
	 * @return Second Attribute
	 */
	public String getIn2() {
		return this.in2;
	}
	
	/**
	 * Return Instruction Name
	 * @return Instruction Name
	 */
	public String getName() {
		return this.name;
	}
}
