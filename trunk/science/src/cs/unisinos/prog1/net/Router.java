package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.abstracts.*;
import cs.unisinos.prog1.net.exceptions.*;

public class Router extends Device {
	private Device ports[];
	
	/*
	 * Constructors
	 */
	
	public Router(String name, int ports, Enlace enlace) {
		super(name, enlace);
		this
			.cleanPorts(ports);
	}
	
	public Router(String name, int ports) {
		this(name, ports, null);
	}
	
	/*
	 * Methods
	 */
	
	public Router send(Packet packet) {
		return this;
	}
	
	private Router cleanPorts(int value) {
		this.ports = new Host[value];
		return this;
	}
	
	/*
	 * Setters
	 */
	
	public Router setPort(int port, Device device) throws NetException {
		if(port < 0 || port > this.getNumberOfPorts())
			throw new DeviceException(NetException.DEVICE_ERROR);
		this.ports[port] = device;
		return this;
	}
	
	/*
	 * Getters
	 */
	
	public Device getPort(int port) throws NetException {
		if(port < 0 || port > this.getNumberOfPorts())
			throw new DeviceException(NetException.DEVICE_ERROR);
		return this.ports[port];
	}
	
	public int getNumberOfPorts() {
		return this.ports.length;
	}
}
