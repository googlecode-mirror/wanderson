package cs.unisinos.prog1.net;

import cs.unisinos.prog1.net.exceptions.*;
import cs.unisinos.prog1.net.classes.*;

public class Main {
	public static void main(String args[]) {
		Host wanderson = new Host("Wanderson");
		Host welington = new Host("Welington");
		Connector cabo = new Connector("Cabo");
		
		try {
			wanderson.setConnection(cabo, welington);
			if(wanderson.send("Teste", "Hello!"))
				System.out.println("Envio Sucesso!");
			else
				System.out.println("Falha de Envio");
			
			System.out.println(welington.getContent());
		}
		catch(NetException e) {
			System.out.println(e);
		}
	}
}
