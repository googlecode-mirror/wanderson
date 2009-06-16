package cs.piana;

import cs.piana.bench.*;
import cs.piana.memory.*;
import java.util.*;

/**
 * Piana
 * Processor Independent Architecture Analyzer
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Piana {
	
	/**
	 * Complete Mode
	 */
	public static final int MODE_COMPLETE = 0;
	
	/**
	 * Burst Mode
	 */
	public static final int MODE_BURST = 1;
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Piana Bench
	 */
	private Bench bench;
	
	/**
	 * Piana Memory
	 */
	private Memory memory;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Constructor
	 * @param bench Piana Bench
	 * @param memory Piana Memory
	 * @throws PianaException Wrong Objects
	 */
	public Piana(Bench bench, Memory memory) throws PianaException {
		this
			.setBench(bench)
			.setMemory(memory);
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configure Piana Bench
	 * @param bench Piana Bench
	 * @return Self Object
	 * @throws PianaException Wrong Bench
	 */
	public Piana setBench(Bench bench) throws PianaException {
		if(bench == null)
			throw new PianaException(PianaException.PIANA_ERROR);
		this.bench = bench;
		return this;
	}
	
	/**
	 * Configure Piana Memory
	 * @param memory Piana Memory
	 * @return Self Object
	 * @throws PianaException Wrong Memory
	 */
	public Piana setMemory(Memory memory) throws PianaException {
		if(memory == null)
			throw new PianaException(PianaException.PIANA_ERROR);
		this.memory = memory;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Bench
	 * @return Bench Object
	 */
	public Bench getBench() {
		return this.bench;
	}
	
	/**
	 * Return Bench Registers
	 * @return Register List
	 */
	public ArrayList<Register> getRegisters() {
		return this.getBench().getBench();
	}
	
	/**
	 * Return Memory
	 * @return Memory Object
	 */
	public Memory getMemory() {
		return this.memory;
	}
	
	/**
	 * Return Memory Blocks 
	 * @return Block List
	 */
	public ArrayList<Block> getBlocks() {
		return this.getMemory().getMemory();
	}
}
