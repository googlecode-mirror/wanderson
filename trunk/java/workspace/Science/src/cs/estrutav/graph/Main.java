package cs.estrutav.graph;

public class Main {
	public static void main(String args[]) {
		Graph graph = new Graph();
		
		Text a   = new Text("a");
		Text b   = new Text("b");
		Number d12 = new Number(12);
		
		try {
			graph
				.addVertice(a)
				.addVertice(b)
				.link(a, b, d12);
		}
		catch(GraphException e) {
			System.out.println(e);
		}
		
		System.out.println();
	}
}
