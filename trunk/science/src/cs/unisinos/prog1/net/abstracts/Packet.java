package cs.unisinos.prog1.net.abstracts;

import cs.unisinos.prog1.net.classes.Host;
import cs.unisinos.prog1.net.exceptions.*;

public abstract class Packet {
	private String content;
	private String destiny;
	private int    ttl;
	
	/*
	 * Constructors
	 */
	
	public Packet(String destiny, String content, int ttl) {
		this
			.setDestiny(destiny)
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
	
	public boolean isDropped() {
		return this.getTtl() == 0;
	}
	
	public boolean reached(Host host) throws NetException {
		if(host == null)
			throw new PacketException(NetException.PACKET_ERROR);
		return host.getName().compareTo(this.getDestiny()) == 0;
	}
	
	/*
	 * Setters
	 */
	
	public Packet setContent(String content) {
		this.content = content;
		return this;
	}
	
	public Packet setDestiny(String destiny) {
		this.destiny = destiny;
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
	
	public String getDestiny() {
		return this.destiny;
	}
	
	public int getTtl() {
		return this.ttl;
	}
}
