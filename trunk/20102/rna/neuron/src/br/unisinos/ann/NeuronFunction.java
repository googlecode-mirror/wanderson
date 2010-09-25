package br.unisinos.ann;

import java.lang.reflect.Method;

public enum NeuronFunction
{
    THRESHOLD ("threshold");

    private final String name;

    private NeuronFunction(String name)
    {
        this.name = name;
    }

    public double transfer(double input) throws AnnException
    {
        double result;
        try {
            @SuppressWarnings("rawtypes")
            Class[] params = new Class[1];
            params[0] = Double.class;
            Method method = this.getClass().getMethod(name, params);
            Object args[] = new Object[1];
            args[0] = input;
            result = (Double) method.invoke(this, args);
        } catch (Exception e) {
            throw new AnnException("Invalid Transfer Function");
        }
        return result;
    }

    public double threshold(Double input)
    {
        return input >= 0 ? 1 : 0;
    }
}
