package cs.estrutav.graph;

/**
 * Main Test Class
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Main {
	/**
	 * Main Test Method
	 */
	public static void main() {
		try {
			
			Graph graph = new Graph();
			
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
