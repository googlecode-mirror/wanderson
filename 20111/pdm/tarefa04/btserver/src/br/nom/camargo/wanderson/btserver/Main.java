package br.nom.camargo.wanderson.btserver;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;

import javax.bluetooth.DiscoveryAgent;
import javax.bluetooth.LocalDevice;
import javax.microedition.io.Connector;
import javax.microedition.io.StreamConnection;
import javax.microedition.io.StreamConnectionNotifier;

public class Main
{
    public static void main(String args[]) throws Exception
    {
        LocalDevice device = LocalDevice.getLocalDevice();
        if (!device.setDiscoverable(DiscoveryAgent.GIAC)) {
            System.out.println("Discoverable Error");
        } else {
            StreamConnectionNotifier notifier = 
                (StreamConnectionNotifier) Connector.open("btspp://localhost:86b4d249fb8844d6a756ec265dd1f6a3");
            StreamConnection conn = notifier.acceptAndOpen();
            InputStream in = conn.openInputStream();

            int data;
            ByteArrayOutputStream out = new ByteArrayOutputStream();
            while ((data = in.read()) != -1) {
                out.write(data);
            }
            
            System.out.println(out.toString());

            in.close();
            conn.close();
            notifier.close();
        }
    }
}
