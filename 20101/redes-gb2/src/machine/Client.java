package machine;

import java.net.*;

public class Client extends Machine
{
    protected String address;

    protected int port;

    public Client(String address) throws Exception
    {
        super();
        this.address = address.substring(0, address.indexOf(":"));
        this.port    = Integer.parseInt(address.substring(address.indexOf(":") + 1));
        this.init();
    }

    public Machine init() throws Exception
    {
        socket = new Socket(address, port);
        return null;
    }

}
