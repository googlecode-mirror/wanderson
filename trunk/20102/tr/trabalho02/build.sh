#!/bin/bash
rm *.java
rm *.class
javacc -debug_parser Main.jj && javac *.java && java Main < input.txt
