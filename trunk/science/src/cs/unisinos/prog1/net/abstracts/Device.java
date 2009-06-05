package cs.unisinos.prog1.net.abstracts;

import cs.unisinos.prog1.net.exceptions.DeviceException;
import cs.unisinos.prog1.net.exceptions.NetException;

public abstract class Device {
	protected Enlace enlace;
	protected String name;
	
	/*
	 * Constructors
	 */
	
	public Device(String name, Enlace enlace) {
		this
			.setName(name)
			.setEnlace(enlace);
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
		this
			.setEnlace(enlace);
		enlace
			.connect(this)
			.connect(device);
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
}
