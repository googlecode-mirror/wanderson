package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.abstracts.*;
import cs.unisinos.prog1.net.exceptions.*;

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
	
	public boolean send(Packet packet) throws NetException {
		if(packet == null)
			throw new DeviceException(NetException.DEVICE_ERROR);
		boolean died = false;
		if(died = packet.reached(this))
			this.setContent(packet.drop().getContent());
		if(!packet.isDropped())
			died = this.getConnection().send(packet.countDown());
		return died;
	}
	
	public boolean send(String destiny, String content) throws NetException {
		return this.send(new Message(destiny, content));
	}
}
