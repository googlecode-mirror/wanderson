package cs.unisinos.prog1.net.abstracts;

public abstract class Packet {
	private String content;
	private int    ttl;
	
	/*
	 * Constructors
	 */
	
	public Packet(String content, int ttl) {
		this
			.setContent(content)
			.setTtl(ttl);
	}
	
	/*
	 * Methods
	 */
	
	public Packet countDown() {
		this.setTtl(this.getTtl() - 1);
		return this;
	}
	
	public Packet drop() {
		this.setTtl(0);
		return this;
	}
	
	/*
	 * Setters
	 */
	
	public Packet setContent(String content) {
		this.content = content;
		return this;
	}
	
	public Packet setTtl(int ttl) {
		if(ttl < 0)
			ttl = 0;
		this.ttl = ttl;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public String getContent() {
		return this.content;
	}
	
	public int getTtl() {
		return this.ttl;
	}
}
