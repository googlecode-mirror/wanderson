package cs.piana.vliw.pipeline;

import cs.piana.memory.*;

/**
 * Piana Very Long Instruction Word
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Vliw {
	
	/**
	 * Complete Constructor
	 */
	public Vliw(){}
	
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
}
