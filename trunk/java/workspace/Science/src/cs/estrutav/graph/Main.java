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
			
			Number d1 = new Number(1);
			
			Graph graph = new Graph();
			
			graph
				.addVertice(a)
				.addVertice(b);
			
			graph
				.linkVertice(graph.getVertice(a), graph.getVertice(b), d1, Edge.BOTH);
			
			System.out.println(graph.getVertice(a).visit(graph.getVertice(b)).visitFrom(graph.getVertice(a)).getContent());
			
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
