package cs.piana.vliw.pipeline;

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
	
	public VliwNode(Instruction inst) {
		this
			.set
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
	
	public VliwNode getAdd
	
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
}
