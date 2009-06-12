package cs.estrutav.graph;

import cs.complex.floydwarshall.*;

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
			
			Number d1 = new Number(10);
			Number d2 = new Number(2);
			Number d3 = new Number(3);
			Number d4 = new Number(4);
			
			Graph graph = new Graph();
			
			graph
				.addVertice(a)
				.addVertice(b)
				.addVertice(c)
				.addVertice(d);
			
			graph
				.linkVertice(graph.getVertice(a), graph.getVertice(b), d1, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(c), graph.getVertice(a), d2, Edge.TO_LEFT)
				.linkVertice(graph.getVertice(c), graph.getVertice(d), d3, Edge.TO_RIGHT)
				.linkVertice(graph.getVertice(d), graph.getVertice(b), d4, Edge.TO_RIGHT);
			
			@SuppressWarnings("unused")
			FloydWarshall floyd = new FloydWarshall(graph);
			
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
