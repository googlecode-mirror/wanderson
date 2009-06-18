package cs.piana.vliw;

import cs.piana.memory.*;

/**
 * Piana VLIW Node
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class VliwNode {
	
	/**
	 * Next Node
	 */
	private VliwNode next;
	
	/**
	 * Dependent Node
	 */
	private VliwNode dependent;
	
	/**
	 * Instruction
	 */
	private Instruction inst;
	
	/**
	 * Complete Constructor
	 * @param inst Instruction
	 */
	public VliwNode(Instruction inst) {
		this
			.setInstruction(inst);
	}
	
	/**
	 * Configure Next Node
	 * @param next Next Node
	 * @return Self Object
	 */
	public VliwNode setNext(VliwNode next) {
		this.next = next;
		return this;
	}
	
	/**
	 * Configure Dependent Node
	 * @param dependent Dependent Node
	 * @return Self Object
	 */
	public VliwNode setDependent(VliwNode dependent) {
		this.dependent = dependent;
		return this;
	}
	
	/**
	 * Configure Instruction
	 * @param inst Instruction
	 * @return Self Object
	 */
	public VliwNode setInstruction(Instruction inst) {
		this.inst = inst;
		return this;
	}
	
	/**
	 * Return Next Node
	 * @return Next Node
	 */
	public VliwNode getNext() {
		return this.next;
	}
	
	/**
	 * Return Dependent Node
	 * @return Dependent Node
	 */
	public VliwNode getDependent() {
		return this.dependent;
	}
	
	/**
	 * Return Instruction
	 * @return Instruction
	 */
	public Instruction getInstruction() {
		return this.inst;
	}
}
