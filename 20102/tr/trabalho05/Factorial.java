public class Factorial
{
	private int input;

	public Factorial(int input)
	{
		if (input <= 0) {
            this.input = 1;
        } else {
            this.input = input;
        }
	}

	public int execute()
	{
		int answer = 1;
		int x = 1;
		while (x <= this.input) {
			answer = answer * x;
			x = x + 1;
		}
		return x;
	}

	public static void main(String args[]) {
		Factorial f = new Factorial(10);
		int result = f.execute();
	}
}
