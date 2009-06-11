package cs.estrutav.graph;

public class Text implements Content {
	protected String content;
	
	public Text(String content) {
		this
			.setContent(content);
	}
	
	public Text setContent(String content) {
		this.content = content;
		return this;
	}
	
	public String getContent() {
		return this.content;
	}
	
	public int compareTo(Content content) throws GraphException {
		if(!(content instanceof Text))
			throw new GraphException(GraphException.CONTENT_ERROR);
		return this.compareTo(content);
	}
	
	public int compareTo(Text content) {
		return this.getContent().compareTo(content.getContent());
	}
	
	public String toString() {
		return this.getContent().toString();
	}
}
