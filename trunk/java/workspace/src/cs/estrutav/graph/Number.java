package cs.estrutav.graph;

public class Number implements Content {
	protected Integer content;
	
	public Number(Integer content) {
		this
			.setContent(content);
	}
	
	public Number setContent(Integer content) {
		this.content = content;
		return this;
	}
	
	public Integer getContent() {
		return this.content;
	}
	
	public int compareTo(Content content) throws GraphException {
		if(!(content instanceof Number))
			throw new GraphException(GraphException.CONTENT_ERROR);
		return this.compareTo(content);
	}
	
	public int compareTo(Number content) {
		return this.getContent().compareTo(content.getContent());
	}
	
	public String toString() {
		return this.getContent().toString();
	}
}
