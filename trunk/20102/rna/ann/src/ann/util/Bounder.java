package ann.util;

public class Bounder
{
    public static final double TOO_SMALL = -1.0E16;

    public static final double TOO_BIG = 1.0E16;

    public static double bound(double value)
    {
        if (value < Bounder.TOO_SMALL) {
            return Bounder.TOO_SMALL;
        } else if (value > Bounder.TOO_BIG) {
            return Bounder.TOO_BIG;
        } else {
            return value;
        }
    }
}
