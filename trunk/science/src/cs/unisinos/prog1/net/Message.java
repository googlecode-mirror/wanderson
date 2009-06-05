package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.abstracts.*;

public class Message extends Packet {
	
	/*
	 * Constructors
	 */
	
	public Message(String content) {
		super(content, 64);
	}
}
