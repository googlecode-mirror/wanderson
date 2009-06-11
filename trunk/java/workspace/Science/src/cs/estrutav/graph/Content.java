package cs.estrutav.graph;

/**
 * Content Interface
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public interface Content {
	
	/**
	 * Content Comparison 
	 * @param content Content to Compare
	 * @return int Compare Identificator
	 * @throws GraphException Wrong Content Instances
	 */
	public int compareTo(Content content) throws GraphException;
	
	/**
	 * Parses Content
	 * @return Parsed Content
	 */
	public String toString();
}
