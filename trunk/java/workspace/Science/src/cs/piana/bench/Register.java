package cs.piana.bench;

/**
 * Bench Register
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Register {
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Alias Name
	 */
	private String alias;
	
	/**
	 * Internal Name
	 */
	private String name;
	
	/**
	 * Status Number
	 */
	private int status;
	
	/**
	 * Available Status
	 */
	public static final int AVAILABLE = 0;
	
	/**
	 * Blocked Status
	 */
	public static final int BLOCKED   = 1;
	
	/**
	 * Complete Constructor
	 * @param name   Internal Name
	 * @param alias  Alias Name
	 * @param status Status Number
	 * @throws BenchException Unknown Status
	 */
	public Register(String name, String alias, int status) throws BenchException {
		this
			.setName(name)
			.setAlias(alias)
			.setStatus(status);
	}
	
	/**
	 * Constructor
	 * @param name  Internal Name
	 * @param alias Alias Name
	 * @throws BenchException Unknown Status
	 */
	public Register(String name, String alias) throws BenchException {
		this(name, alias, Register.AVAILABLE);
	}
	
	/**
	 * Fast Constructor
	 * @param name Internal Name
	 * @throws BenchException Unknown Status
	 */
	public Register(String name) throws BenchException {
		this(name, name, Register.AVAILABLE);
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Register Compare
	 * @param register Compared Register
	 * @return Compare Status
	 */
	public int compareTo(Register register) {
		return this.getName().compareTo(register.getName());
	}
	
	/**
	 * Reset Register Status
	 * @return Self Object
	 */
	public Register reset() {
		this.status = Register.AVAILABLE;
		return this;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configure Alias Name
	 * @param alias Alias Name
	 * @return Self Object
	 */
	public Register setAlias(String alias) {
		this.alias = alias;
		return this;
	}
	
	/**
	 * Configure Internal Name
	 * @param name Internal Name
	 * @return Self Object
	 */
	public Register setName(String name) {
		this.name = name;
		return this;
	}
	
	/**
	 * Configure Status 
	 * @param status Status Number
	 * @return Self Object
	 * @throws BenchException Unknown Status
	 */
	public Register setStatus(int status) throws BenchException {
		switch(status) {
		case AVAILABLE:
		case BLOCKED:
			this.status = status;
			break;
		default:
			throw new BenchException(BenchException.REGISTER_ERROR);
		}
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Alias Name
	 * @return Alias Name
	 */
	public String getAlias() {
		return this.alias;
	}
	
	/**
	 * Return Internal Name
	 * @return Internal Name
	 */
	public String getName() {
		return this.name;
	}
	
	/**
	 * Return Status
	 * @return Status
	 */
	public int getStatus() {
		return this.status;
	}
}
