# Variáveis
CFLAGS = -Wall
CC     = g++ ${CFLAGS}

# Diretivas

all: main.o node.o operand.o operator.o
	${CC} $? -o main

node.o:
	${CC} -c node.cpp

operand.o:
	${CC} -c operand.cpp

operator.o:
	${CC} -c operator.cpp

main.o:
	${CC} -c main.cpp

clean:
	rm -rf main main.o node.o operand.o operator.o
