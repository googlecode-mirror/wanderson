package cs.piana.vliw.pipeline;

import cs.piana.memory.*;

/**
 * Piana Vliw Node
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class VliwNode {
	
	/**
	 * Vliw Next Node
	 */
	private VliwNode next;
	
	/**
	 * Vliw Brother Node
	 */
	private VliwNode brother;
	
	/**
	 * Vliw Node Content
	 */
	private Instruction content;
	
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
	 * Configure Brother Node
	 * @param brother Brother Node
	 * @return Self Object
	 */
	public VliwNode setBrother(VliwNode brother) {
		this.brother = brother;
		return this;
	}
	
	/**
	 * Configure Content
	 * @param content Content
	 * @return Self Object
	 */
	public VliwNode setContent(Instruction content) {
		this.content = content;
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
	 * Return Brother Node
	 * @return Brother Node
	 */
	public VliwNode getBrother() {
		return this.brother;
	}
	
	/**
	 * Return Content
	 * @return Content
	 */
	public Instruction getContent() {
		return this.content;
	}
}
