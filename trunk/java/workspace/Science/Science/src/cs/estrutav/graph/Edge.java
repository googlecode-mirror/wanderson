package cs.estrutav.graph;

/**
 * Graph Edge
 * @author Wanderson Henrique Camargo Rosa
 * 
 */
public class Edge {
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Left Vertice
	 */
	protected Vertice left;
	
	/**
	 * Right Vertice
	 */
	protected Vertice right;
	
	/**
	 * Edge Content
	 */
	protected Content content;
	
	/**
	 * Link Type
	 */
	protected int link;
	
	/*
	 * Static Constants
	 */
	
	/**
	 * Two Sides Linked
	 */
	public static final int BOTH     = 0;
	
	/**
	 * Link to the Left Vertice 
	 */
	public static final int TO_LEFT  = 1;
	
	/**
	 * Link to the Right Vertice
	 */
	public static final int TO_RIGHT = 2;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Class Constructor
	 * @public
	 * @param left    Left Vertice
	 * @param right   Right Vertice
	 * @param content Edge Content
	 * @param link    Link Type
	 * @throws GraphException Null Vertices Pointers
	 */
	public Edge(Vertice left, Vertice right, Content content, int link) throws GraphException {
		this
			.setLeft(left)
			.setRight(right)
			.setContent(content)
			.setLinkType(link);
	}
	
	/**
	 * Visit a Vertice through an Edge Link Type
	 * @param leave Leave Vertice
	 * @return Arrive Vertice
	 * @throws GraphException Unable to Access Arrive Vertice
	 */
	public Vertice visitFrom(Vertice leave) throws GraphException {
		Vertice arrive = null;
		if(this.getLinkType() == BOTH) {
			arrive = this.getPointer(leave);
		}
		else if(this.getLinkType() == TO_LEFT) {
			if(this.getRight() == leave)
				arrive = this.getLeft();
		}
		else if(this.getLinkType() == TO_RIGHT) {
			if(this.getLeft() == leave)
				arrive = this.getRight();
		}
		if(arrive == null)
			throw new GraphException(GraphException.EDGE_ERROR);
		return arrive;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configures Left Vertice
	 * @param left Left Vertice
	 * @return Self Object
	 * @throws GraphException Null Left Vertice
	 */
	public Edge setLeft(Vertice left) throws GraphException {
		if(left == null || left == this.getRight())
			throw new GraphException(GraphException.EDGE_ERROR);
		this.left = left;
		return this;
	}
	
	/**
	 * Configures Right Vertice
	 * @param right Right Vertice
	 * @return Self Object
	 * @throws GraphException Null Right Vertice
	 */
	public Edge setRight(Vertice right) throws GraphException {
		if(right == null || right == this.getLeft())
			throw new GraphException(GraphException.EDGE_ERROR);
		this.right = right;
		return this;
	}
	
	/**
	 * Configures Edge Content
	 * @param content Edge Content
	 * @return Self Object
	 * @throws GraphException Null Content
	 */
	public Edge setContent(Content content) throws GraphException {
		if(content == null)
			throw new GraphException(GraphException.EDGE_ERROR);
		this.content = content;
		return this;
	}
	
	/**
	 * Configures Edge Link Constant Type
	 * @param link Link Constant Type
	 * @return Self Object
	 * @exception GraphException Wrong Link Constant Type
	 */
	public Edge setLinkType(int link) throws GraphException {
		switch(link) {
		case BOTH:
		case TO_LEFT:
		case TO_RIGHT:
			this.link = link;
			break;
		default:
			throw new GraphException(GraphException.EDGE_ERROR);
		}
		return this;
	}
	
	/*
	 * Getters
	 */
	
	/**
	 * Returns the Left Vertice
	 * @return Left Vertice
	 */
	public Vertice getLeft() {
		return this.left;
	}
	
	/**
	 * Returns the Right Vertice
	 * @return Right Vertice
	 */
	public Vertice getRight() {
		return this.right;
	}
	
	/**
	 * Returns the Linked Vertice Pointer
	 * @param pointer Link Vertice Pointer
	 * @return Linked Vertice
	 * @throws GraphException Link Vertice Pointer isn't Configured into the Edge 
	 */
	public Vertice getPointer(Vertice pointer) throws GraphException {
		Vertice side = null;
		if(this.getLeft() == pointer)
			side = this.getRight();
		else if(this.getRight() == pointer)
			side = this.getLeft();
		if(side == null)
			throw new GraphException(GraphException.EDGE_ERROR);
		return side;
	}
	
	/**
	 * Returns Edge Content
	 * @return Edge Content
	 */
	public Content getContent() {
		return this.content;
	}
	
	/**
	 * Returns Link Type
	 * @return Link Type
	 */
	public int getLinkType() {
		return this.link;
	}
}
