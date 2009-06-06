package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.abstracts.*;

public class Message extends Packet {
	
	/*
	 * Constructors
	 */
	
	public Message(String destiny, String content) {
		super(destiny, content, 64);
	}
}
