package cs.piana.vliw;

import cs.piana.memory.*;

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
	 * Tree Empty Check
	 * @return Check Flag
	 */
	public boolean isEmpty() {
		return this.first == null;
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
	 * Tree Instruction Get
	 * Flag TRUE:  Remove Node from Tree
	 * Flag FALSE: Mark Node as 'is Used'
	 * @param type Instruction Type
	 * @return Required Instruction or Null
	 */
	public Instruction getInstruction(String type) {
		VliwNode node = this.getFirst();
		VliwNode current = null;
		while(node != null) { 
			if(node.getInstruction().getName().compareTo(type) == 0)
				if(!node.isUsed())
					current = node;
			node = node.getNext();
		}
		Instruction instruction = null;
		if(current != null) {
			instruction = current.use().getInstruction().countDown();
		}
		return instruction;
	}
	
	/**
	 * Free all Nodes
	 * @return Self Object
	 */
	public VliwTree freeAll() {
		VliwNode current = this.getFirst();
		while(current != null) {
			current.free();
			current = current.getNext();
		}
		return this;
	}
	
	/**
	 * Remove Used Nodes in Iteration
	 * @return Self Object
	 */
	public VliwTree removeUsedAndDead() {
		VliwNode parent = null;
		VliwNode current = this.getFirst();
		VliwNode dependent = null;
		while(current != null) {
			dependent = current.getDependent();
			if(current.isUsed() && current.getInstruction().isDead()) {
				if(current == this.getFirst()) {
					if(dependent == null) {
						this.first = this.first.getNext();
					}
					else {
						this.first = dependent;
						dependent.setNext(current.getNext());
					}
				}
				else {
					if(dependent == null) {
						parent.setNext(current.getNext());
					}
					else {
						parent.setNext(dependent);
						dependent.setNext(current.getNext());
					}
				}
				
			}
			parent  = current;
			current = current.getNext();
		}
		return this;
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
