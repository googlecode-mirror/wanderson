package cs.estrutav.graph;

/**
 * Text Content for Graph Vertices
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Text implements Content {
	/**
	 * String Content
	 */
	protected String content;
	
	/**
	 * Complete Constructor
	 * @param content String Content
	 */
	public Text(String content) {
		this
			.setContent(content);
	}
	
	/**
	 * Configures String Content
	 * @param content String Content
	 * @return Self Object
	 */
	public Text setContent(String content) {
		this.content = content;
		return this;
	}
	
	/**
	 * Returns String Content
	 * @return String Content
	 */
	public String getContent() {
		return this.content;
	}
	
	/**
	 * Compares Two Contents
	 * @param content Text Content
	 * @return Compare Content Type
	 * @throws GraphException Wrong Text Instance
	 */
	public int compareTo(Content content) throws GraphException {
		if(!(content instanceof Text))
			throw new GraphException(GraphException.CONTENT_ERROR);
		Text text = (Text) content;
		return this.compareTo(text);
	}
	
	/**
	 * Compares Two Text Contents
	 * @param content Text Content
	 * @return Compare Content Type
	 */
	public int compareTo(Text content) {
		return this.getContent().compareTo(content.getContent());
	}
	
	/**
	 * Parses Text
	 * @return Parsed Text
	 */
	public String toString() {
		return this.getContent().toString();
	}
}
