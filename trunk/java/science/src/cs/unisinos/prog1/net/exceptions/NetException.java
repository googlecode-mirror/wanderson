package cs.unisinos.prog1.net.exceptions;

public class NetException extends Exception {
	private static final long serialVersionUID = 1L;
	
	public static String ENLACE_ERROR = "Enlace Error";
	public static String DEVICE_ERROR = "Device Error";
	public static String PACKET_ERROR = "Packet Error";
	public static String NET_ERROR    = "Net Error";
	
	public NetException() {
		super(NetException.NET_ERROR);
	}
	
	public NetException(String message) {
		super(message);
	}
}
