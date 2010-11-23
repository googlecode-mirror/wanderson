public class Factorial
{
	private int input;

	public Factorial(int input)
	{
		this.input = input;
	}

	public int execute()
	{
		int answer;
		answer = 1;
		int x;
		x = 1;
		while (x <= answer) {
			answer = answer * x;
			x = x + 1;
		}
		return x;
	}

	public static void main(String args[]) {
		Factorial f;
		f = new Factorial(10);
		int result;
		result = f.execute();
	}
}
