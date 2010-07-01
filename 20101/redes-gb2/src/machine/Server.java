package machine;

import java.net.*;

/**
 * Classe Servidor
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Server extends Machine
{
    protected int port;

    public Server(int port) throws Exception
    {
        super();
        this.port = port;
        this.init();
    }

    public Server init() throws Exception
    {
        ServerSocket server = new ServerSocket(port);
        socket = server.accept();
        return this;
    }

}
