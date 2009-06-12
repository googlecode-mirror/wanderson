package cs.estrutav.graph;

/**
 * Number Content for Graph Edges
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Number implements Content {
	/**
	 * Integer Content
	 */
	protected Integer content;
	
	/**
	 * Infinite Constant
	 */
	public static Integer INFINITE = Integer.MAX_VALUE;
	
	/**
	 * Complete Constructor
	 * @param content Integer Content
	 * @throws GraphException Negative Value
	 */
	public Number(Integer content) throws GraphException {
		this
			.setContent(content);
	}
	
	/**
	 * Configures Integer Content
	 * @param content Integer Content
	 * @return Self Object
	 * @throws GraphException Negative Value
	 */
	public Number setContent(Integer content) throws GraphException {
		if(content.intValue() < 0 && content.intValue() != INFINITE)
			throw new GraphException(GraphException.CONTENT_ERROR);
		this.content = content;
		return this;
	}
	
	/**
	 * Retruns Integer Content
	 * @return Integer Content
	 */
	public Integer getContent() {
		return this.content;
	}
	
	/**
	 * Compares Two Contents
	 * @param content Number Content
	 * @return Compare Content Type
	 * @throws GraphException Wrong Number Instance
	 */
	public int compareTo(Content content) throws GraphException {
		if(!(content instanceof Number))
			throw new GraphException(GraphException.CONTENT_ERROR);
		Number number = (Number) content;
		return this.compareTo(number);
	}
	
	/**
	 * Compares Two Number Contents
	 * @param content Number Content
	 * @return Compare Content Type
	 */
	public int compareTo(Number content) {
		return this.getContent().compareTo(content.getContent());
	}
	
	/**
	 * Parses Number
	 * @return Parsed Number
	 */
	public String toString() {
		return this.getContent().toString();
	}
}
