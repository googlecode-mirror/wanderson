package cs.unisinos.prog1.net.exceptions;

public class PacketException extends NetException {
	private static final long serialVersionUID = 1L;
	
	public PacketException() {
		super();
	}
	
	public PacketException(String message) {
		super(message);
	}
}
