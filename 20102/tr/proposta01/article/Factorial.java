public class Factorial
{
    private int input;

    public Factorial(int input)
    {
        this.input = input;
    }

    public int execute()
    {
        int answer = 1;
        int x = 1;
        while (x <= input) {
            answer = answer * x;
            x = x + 1;
        }
        return answer;
    }

    public static void main(String args[])
    {
        Factorial f = new Factorial(10);
        int result = f.execute();
    }
}