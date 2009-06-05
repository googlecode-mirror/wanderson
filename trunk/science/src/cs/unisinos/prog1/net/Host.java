package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.abstracts.*;

public class Host extends Device {
	
	/*
	 * Constructors 
	 */
	
	public Host(String name, Enlace enlace) {
		super(name,enlace);
	}
	
	public Host(String name) {
		super(name);
	}
	
	/*
	 * Methods
	 */
	
	public Host send(Packet packet) {
		return this;
	}
	
	public Host send(String content) {
		this.send(new Message(content));
		return this;
	}
}
