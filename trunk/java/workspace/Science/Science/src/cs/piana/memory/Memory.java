package cs.piana.memory;

import java.util.*;

/**
 * Piana Memory
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Memory {
	
	/**
	 * Block List
	 */
	private ArrayList<Block> memory;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Constructor
	 */
	public Memory() {
		this
			.clearMemory();
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Create or Remove All Blocks
	 * @return Self Object
	 */
	public Memory clearMemory() {
		this.memory = new ArrayList<Block>();
		return this;
	}
	
	/**
	 * Add a Block into the Memory
	 * @param block Block to Add
	 * @return Self Object
	 */
	public Memory addBlock(Block block) {
		this.getMemory().add(block);
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Block List
	 * @return Block List
	 */
	public ArrayList<Block> getMemory() {
		return this.memory;
	}
	
	/**
	 * Return Indexed Block
	 * @param index Index Number
	 * @return Indexed Block
	 * @throws MemoryException Index Error
	 */
	public Block getBlock(int index) throws MemoryException {
		try {
			return this.getMemory().get(index);
		}
		catch(IndexOutOfBoundsException e) {
			throw new MemoryException(MemoryException.MEMORY_ERROR);
		}
	}
	
	/**
	 * Return Number of Blocks
	 * @return Counter
	 */
	public int getSize() {
		return this.getMemory().size();
	}
}
