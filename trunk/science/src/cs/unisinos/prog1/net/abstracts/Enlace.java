package cs.unisinos.prog1.net.abstracts;

import cs.unisinos.prog1.net.exceptions.EnlaceException;
import cs.unisinos.prog1.net.exceptions.NetException;

public abstract class Enlace {
	protected String name;
	protected Device connection1;
	protected Device connection2;
	
	/*
	 * Constructors
	 */
	
	public Enlace(String name, Device conn1, Device conn2) {
		this
			.setName(name)
			.setConnection1(conn1)
			.setConnection2(conn2);
	}
	
	public Enlace(String name) {
		this(name, null, null);
	}
	
	/*
	 * Methods
	 */
	
	public Enlace connect(Device device) throws NetException {
		if(device == null)
			throw new EnlaceException(NetException.ENLACE_ERROR);
		device.setEnlace(this);
		if(this.getConnection1() == null)
			this.setConnection1(device);
		else if(this.getConnection2() == null)
			this.setConnection2(device);
		else
			throw new EnlaceException(NetException.ENLACE_ERROR);
		return this;
	}
	
	/*
	 * Setters
	 */
	
	public Enlace setConnection1(Device device) {
		this.connection1 = device;
		return this;
	}
	
	public Enlace setConnection2(Device device) {
		this.connection2 = device;
		return this;
	}
	
	public Enlace setName(String name) {
		this.name = name;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Device getConnection1() {
		return this.connection1;
	}
	
	public Device getConnection2() {
		return this.connection2;
	}
	
	public String getName() {
		return this.name;
	}
	
	public Device getConnection(Device device) throws NetException {
		Device out = null;
		if(device == this.getConnection1())
			out = this.getConnection2();
		else if(device == this.getConnection2())
			out = this.getConnection1();
		else
			throw new EnlaceException(NetException.ENLACE_ERROR);
		return out;
	}
}
