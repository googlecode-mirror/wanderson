package cs.unisinos.prog1.net.classes;

import cs.unisinos.prog1.net.abstracts.*;

public class Connector extends Enlace {
	
	/*
	 * Constructors
	 */
	
	public Connector(String name, Device conn1, Device conn2) {
		super(name, conn1, conn2);
	}
	
	public Connector(String name) {
		super(name);
	}
}
