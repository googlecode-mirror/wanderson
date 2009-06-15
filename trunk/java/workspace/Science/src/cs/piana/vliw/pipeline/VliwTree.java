package cs.piana.vliw.pipeline;

/**
 * Vliw Tree
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
	public VliwTree addBrother(VliwNode node) {
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
}
