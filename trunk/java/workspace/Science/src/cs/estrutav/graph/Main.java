package cs.estrutav.graph;

/**
 * Main Test Class
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Main {
	/**
	 * Main Test Method
	 * @param args Terminal Arguments
	 */
	public static void main(String args[]) {
		try {
			
			Text a = new Text("a");
			Text b = new Text("b");
			Text c = new Text("c");
			Text d = new Text("d");
			
			Number d1 = new Number(1);
			Number d2 = new Number(2);
			Number d3 = new Number(3);
			Number d4 = new Number(4);
			Number d5 = new Number(5);
			Number d6 = new Number(6);
			
			Graph graph = new Graph();
			
			graph
				.addVertice(a)
				.addVertice(b)
				.addVertice(c)
				.addVertice(d);
			
			graph
				.linkVertice(graph.getVertice(a), graph.getVertice(c), d1, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(a), graph.getVertice(b), d3, Edge.TO_LEFT)
				.linkVertice(graph.getVertice(a), graph.getVertice(d), d6, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(b), graph.getVertice(d), d2, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(b), graph.getVertice(c), d5, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(c), graph.getVertice(d), d4, Edge.TO_LEFT);
			
			graph
				.removeVertice(a);
			
			System.out.println();
		}
		catch (GraphException e) {
			System.out.println(e);
			e.printStackTrace();
		}
		catch (Exception e) {
			System.out.println("Unknown Error");
			e.printStackTrace();
		}
		System.out.println("Finish");
	}
}
