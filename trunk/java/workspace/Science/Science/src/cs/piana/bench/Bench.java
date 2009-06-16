package cs.piana.bench;

import java.util.*;

/**
 * Piana Bench
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Bench {
	
	/**
	 * Register List
	 */
	private ArrayList<Register> bench;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Constructor
	 */
	public Bench() {
		this
			.clearBench();
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Create or Remove All Registers
	 * @return Self Object
	 */
	public Bench clearBench() {
		this.bench = new ArrayList<Register>();
		return this;
	}
	
	/**
	 * Reset All Registers
	 * @return Self Object
	 */
	public Bench resetBench() {
		for(Register register : this.getBench())
			register.reset();
		return this;
	}
	
	/**
	 * Add a Register into the Bench
	 * @param register Register to Add
	 * @return Self Object
	 * @throws BenchException Duplicated Register
	 */
	public Bench addRegister(Register register) throws BenchException {
		boolean found = false;
		int count = this.getSize();
		int index = 0;
		
		while(!found && index < count) {
			found = this.bench.get(index).compareTo(register) == 0;
			index++;
		}
		
		if(found) throw new BenchException(BenchException.BENCH_ERROR);
		
		this.getBench().add(register);
		
		return this;
	}
	
	/**
	 * Add a Register Family
	 * @param prepend Family Surname
	 * @param size    Number of Register
	 * @return Self Object
	 * @throws BenchException Wrong Size
	 */
	public Bench addRegisterFamily(String prepend, int size) throws BenchException {
		if(size < 1)
			throw new BenchException(BenchException.BENCH_ERROR);
		for(int i = 0; i < size; i++)
			this.addRegister(new Register(prepend + i));
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Register List
	 * @return Register List
	 */
	public ArrayList<Register> getBench() {
		return this.bench;
	}
	
	/**
	 * Return Indexed Register
	 * @param index Index Number
	 * @return Indexed Register
	 * @throws BenchException Index Error
	 */
	public Register getRegister(int index) throws BenchException {
		try {
			return this.getBench().get(index);
		}
		catch(IndexOutOfBoundsException e) {
			throw new BenchException(BenchException.BENCH_ERROR);
		}
	}
	
	/**
	 * Get a Register by Internal Name
	 * @param name Register Internal Name
	 * @return Searched Register
	 * @throws BenchException Register not Found
	 */
	public Register getRegister(String name) throws BenchException {
		Register register = null;
		boolean found = false;
		int count = this.getSize();
		int index = 0;
		
		while(!found && index < count) {
			register = this.getBench().get(index);
			found = register.compareTo(register) == 0;
			index++;
		}
		
		if(!found) throw new BenchException(BenchException.BENCH_ERROR);
		
		return register;
	}
	
	/**
	 * Return Number of Registers
	 * @return Counter
	 */
	public int getSize() {
		return this.getBench().size();
	}
}
