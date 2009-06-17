package cs.piana.vliw.pipeline;

/**
 * Piana VLIW Tree
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class VliwTree {
	
	/**
	 * First Node
	 */
	private VliwNode first;
	
	/**
	 * Last Node
	 */
	private VliwNode last;
	
	/**
	 * Complete Constructor
	 */
	public VliwTree() {
		this.first = this.last = null;
	}
	
	/**
	 * VliwTree Node Increment
	 * @param node VliwNode
	 * @return Self Object
	 */
	public VliwTree addNode(VliwNode node) {
		if(first == null)
			this.first = this.last = node;
		else {
			this.last.setNext(node);
			this.last = node;
		}
		return this;
	}
	
	/**
	 * Set Maximum Dependent
	 * @param parent Parent
	 * @param dependent Dependent
	 * @return Self Object
	 */
	public VliwTree addDependent(VliwNode parent, VliwNode dependent) {
		if(parent == null)
			return this;
		VliwNode current = parent.getDependent();
		while(current != null) {
			parent = current;
			current = current.getDependent();
		}
		parent.setDependent(dependent);
		return this;
	}
	
	/**
	 * Drop Parent Node Swapping with Dependent Node
	 * @param out Output Register Name
	 * @return Parent Node or Null
	 */
	public VliwNode dropParent(String out) {
		VliwNode parent  = null;
		VliwNode current = this.getNode(out); 
		if(current != null) {
			parent = current;
			current = current.getDependent();
		}
		return parent;
	}
	
	/**
	 * Get Node with an Output Register Name
	 * @param out Output Register Name
	 * @return Node found or null
	 */
	public VliwNode getNode(String out) {
		boolean found = false;
		VliwNode current = this.getFirst();
		while(!found && current != null) {
			found = current.getInstruction().getOut().compareTo(out) == 0;
			current = current.getNext();
		}
		return found ? current : null;
	}
	
	/**
	 * Return Last Node
	 * @return Last Node
	 */
	public VliwNode getLast() {
		return this.last;
	}
	
	/**
	 * Return First Node
	 * @return First Node
	 */
	public VliwNode getFirst() {
		return this.first;
	}
}
