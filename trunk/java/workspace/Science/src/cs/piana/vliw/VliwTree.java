package cs.piana.vliw;


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
	 * Get Node with an Output Register Name
	 * @param out Output Register Name
	 * @return Node found or null
	 */
	public VliwNode getNode(String out) {
		
		VliwNode curH = this.getFirst(); // Horizontal Current
		VliwNode curV = null;            // Vertical Current
		VliwNode curF = null;            // Found Current
		
		int vertical  = 0;
		int foundV    = 0; // Height Found
		
		while(curH != null) {
			vertical = 0;
			curV = curH.getDependent();
			while(curV != null) {
				vertical = vertical + 1;
				if(curV.getInstruction().getOut().compareTo(out) == 0) {
					if(foundV < vertical) {
						foundV = vertical;
						curF   = curV;
					}
				}
				curV = curV.getDependent();
			}
			if(foundV == 0) {
				if(curH.getInstruction().getOut().compareTo(out) == 0)
					curF = curH;
			}
			curH = curH.getNext();
		}
		
		return curF;
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
