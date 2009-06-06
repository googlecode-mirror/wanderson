package cs.unisinos.prog1.net.abstracts;

import cs.unisinos.prog1.net.exceptions.DeviceException;
import cs.unisinos.prog1.net.exceptions.NetException;

public abstract class Device {
	protected Enlace enlace;
	protected String name;
	protected String content;
	
	/*
	 * Abstract Methods
	 */
	
	abstract public boolean send(Packet packet) throws NetException;
	
	/*
	 * Constructors
	 */
	
	public Device(String name, Enlace enlace) {
		this
			.setName(name)
			.setEnlace(enlace)
			.setContent("");
	}
	
	public Device(String name) {
		this(name, null);
	}
	
	/*
	 * Setters
	 */
	
	public Device setEnlace(Enlace enlace) {
		this.enlace = enlace;
		return this;
	}
	
	public Device setName(String name) {
		this.name = name;
		return this;
	}
	
	public Device setConnection(Enlace enlace, Device device) throws NetException {
		enlace
			.connect(this)
			.connect(device);
		return this;
	}
	
	public Device setContent(String content) {
		this.content = content;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Enlace getEnlace() {
		return this.enlace;
	}
	
	public String getName() {
		return this.name;
	}
	
	public Device getConnection() throws NetException {
		Enlace enlace = this.getEnlace();
		if(enlace == null)
			throw new DeviceException(NetException.DEVICE_ERROR);
		return enlace.getConnection(this);
	}
	
	public String getContent() {
		return this.content;
	}
}
