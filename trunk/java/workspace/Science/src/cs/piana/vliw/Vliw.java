package cs.piana.vliw;

import java.util.*;
import cs.piana.memory.*;

/**
 * Piana Very Long Instruction Word
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Vliw {
	
	/*
	 * Class Attributes
	 */
	
	/**
	 * Pipeline Names
	 */
	private String pipes[];
	
	/**
	 * Instructions List
	 */
	private ArrayList<ArrayList<Instruction>> pipelines;
	
	/*
	 * Constructor
	 */
	
	/**
	 * Complete Constructor
	 * @param pipes Pipeline Names
	 * @param memory Piana Memory
	 */
	public Vliw(String pipes[], Memory memory) {
		this
			.setPipes(pipes);
		
		int count = pipes.length;
		this.pipelines = new ArrayList<ArrayList<Instruction>>();
		for(int i = 0; i < count; i++)
			pipelines.add(i, new ArrayList<Instruction>());
		
		VliwTree tree = this.createTree(memory);
		
		Instruction temp = null;
		int j = 0;
		while(!tree.isEmpty()) {
			for(int i = 0; i < count; i++) {
				if(j > 0) {
					if(!pipelines.get(i).get(j-1).isDead())
						temp = pipelines.get(i).get(j-1);
					else
						temp = tree.removeInstruction(pipes[i]);
				}
				else
					temp = tree.removeInstruction(pipes[i]);
				if(temp != null)
					temp.countDown();
				pipelines.get(i).add(j, temp);
			}
			j = j + 1;
		}
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Construct a Vliw Dependency Tree
	 * @param memory Piana Memory
	 * @return Self Object
	 */
	public VliwTree createTree(Memory memory) {
		VliwTree tree = new VliwTree();
		VliwNode node  = null;
		VliwNode temp1 = null;
		VliwNode temp2 = null;
		Instruction instruction = null;
		for(Block block : memory.getMemory()) {
			
			instruction = (Instruction) block;
			
			node = new VliwNode(instruction);
			
			temp1 = tree.getNode(instruction.getIn1());
			temp2 = tree.getNode(instruction.getIn2());
			
			if(temp1 == null && temp2 == null)
				tree.addNode(node);
			else if(temp1 != null)
				tree.addDependent(temp1, node);
			else if(temp2 != null)
				tree.addDependent(temp2, node);
		}
		return tree;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configure Pipelines
	 * @param pipes Pipeline Names
	 * @return Self Object
	 */
	public Vliw setPipes(String pipes[]) {
		this.pipes = pipes;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Pipelines
	 * @return Pipeline Names
	 */
	public String[] getPipes() {
		return this.pipes;
	}
}
