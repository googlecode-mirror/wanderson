package cs.piana.vliw.pipeline;

import cs.piana.vliw.VliwException;

/**
 * Piana VLIW Tree
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class VliwTree {
	
	/**
	 * Root Node
	 */
	private VliwNode root;
	
	/**
	 * Last Node
	 */
	private VliwNode last;
	
	/**
	 * Complete Constructor
	 */
	public VliwTree() {}
	
	/**
	 * Add Last Node Brother
	 * @param node New Node
	 * @return Self Object
	 */
	public VliwTree addNext(VliwNode node) {
		if(this.getRoot() == null) {
			this.root = node;
			this.last = node;
		}
		else {
			this.last.setBrother(node);
			this.last = node;
		}
		return this;
	}
	
	/**
	 * Add a Brother to the Node
	 * @param node Node Dependency
	 * @return Self Object
	 * TODO (Create best method and check the logic)
	 */
	public VliwTree addBrother(VliwNode node) {
		VliwNode parent, son;
		parent = son = null;
		try {
			parent = this.getNode(node.getContent().getOut());
			son = parent.getBrother();
			while(son != null) {
				parent = son;
				son = parent.getBrother();
			}
			parent.setBrother(node);
		}
		catch(VliwException e) {
			this.addNext(node);
		}
		return this;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configure Root Node
	 * @param root Root Node
	 * @return VliwTree Self Object
	 */
	public VliwTree setRoot(VliwNode root) {
		this.root = root;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Return Root Node
	 * @return Root Node
	 */
	public VliwNode getRoot() {
		return this.root;
	}
	
	/**
	 * Return Last Node
	 * @return Last Node
	 */
	public VliwNode getLast() {
		return this.last;
	}
	
	/**
	 * Find a the First Node with the Same Out Information
	 * @param out Out String Dependency
	 * @return Node Dependency
	 * @throws VliwException Node not found
	 */
	public VliwNode getNode(String out) throws VliwException {
		boolean found = false;
		VliwNode current = this.getRoot();
		while(!found && current != null) {
			current = current.getNext();
			found = out.compareTo(current.getContent().getOut()) == 0;
		}
		if(!found)
			throw new VliwException(VliwException.VLIW_ERROR);
		return current;
	}
}
